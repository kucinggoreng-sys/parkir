<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\VehicleType;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use PDF;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $locations = Location::all();

        foreach ($locations as $location) {
            $location->active_motorcycles = Transaction::where('id_lokasi', $location->id)
                ->whereNull('keluar')
                ->whereHas('vehicleType', function ($q) {
                    $q->where('jenis', 'motorcycle');
                })->count();

            $location->active_cars = Transaction::where('id_lokasi', $location->id)
                ->whereNull('keluar')
                ->whereHas('vehicleType', function ($q) {
                    $q->where('jenis', 'car');
                })->count();

            $location->active_others = Transaction::where('id_lokasi', $location->id)
                ->whereNull('keluar')
                ->whereHas('vehicleType', function ($q) {
                    $q->where('jenis', 'other');
                })->count();
        }

        $vehicleTypes = VehicleType::all();

        $activeTickets = Transaction::with(['location', 'vehicleType'])
            ->whereNull('keluar')
            ->orderBy('masuk', 'desc')
            ->get();

        $allTransactions = Transaction::with(['location', 'vehicleType'])
            ->whereNotNull('keluar')
            ->orderBy('keluar', 'desc')
            ->get();

        // SINKRONISASI VISUAL: Menyesuaikan tampilan durasi menit di tabel/modal history
        $allTransactions->map(function ($tr) {
            // Kolom 'total_jam' di database sekarang murni menyimpan angka MENIT
            $total_menit = (int) $tr->total_jam;
            
            // Diarahkan langsung ke jumlah menit aslinya agar blade tidak bingung
            $tr->total_hours = $total_menit < 1 ? 1 : $total_menit;

            $masuk = Carbon::parse($tr->masuk);
            $keluar = Carbon::parse($tr->keluar);
            $days_murni = $masuk->diffInDays($keluar);

            // Logika status hari: Jika belum menyentuh max_perhari, set ke 0 hari
            if ($tr->total_bayar < $tr->max_perhari && $days_murni < 1) {
                $tr->total_days = 0;
            } else {
                $tr->total_days = $days_murni < 1 ? 1 : $days_murni;
            }

            $tr->total_pays = $tr->total_bayar;

            return $tr;
        });

        return view('transactions.index', [
            'title' => 'Transaction',
            'locations' => $locations,
            'vehicleTypes' => $vehicleTypes,
            'activeTickets' => $activeTickets,
            'allTransactions' => $allTransactions
        ]);
    }

    /**
     * Store a newly created resource in storage (Check-In Kendaraan).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_lokasi' => 'required|exists:locations,id',
            'id_jenis' => 'required|exists:vehicle_types,id',
            'no_polisi' => 'required|string|max:15',
        ]);

        $location = Location::findOrFail($validated['id_lokasi']);
        $vehicleType = VehicleType::findOrFail($validated['id_jenis']);

        $currentCount = Transaction::where('id_lokasi', $location->id)
            ->whereNull('keluar')
            ->where('id_jenis', $vehicleType->id)
            ->count();

        $limit = 0;
        if ($vehicleType->jenis == 'motorcycle') {
            $limit = $location->max_motorcycle;
        } elseif ($vehicleType->jenis == 'car') {
            $limit = $location->max_car;
        } else {
            $limit = $location->max_other;
        }

        if ($currentCount >= $limit) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['id_lokasi' => "Location {$location->location_name} is full for {$vehicleType->jenis}s!"]);
        }

        $no_tiket = 'TKT-' . date('YmdHis') . rand(10, 99);

        Transaction::create([
            'id_lokasi' => $location->id,
            'no_tiket' => $no_tiket,
            'no_polisi' => strtoupper(str_replace(' ', '', $validated['no_polisi'])),
            'id_jenis' => $vehicleType->id,
            'masuk' => now(),
            'perjam_pertama' => $vehicleType->perjam_pertama, // Di sini menyimpan tarif per menit dari DB
            'perjam_berikutnya' => $vehicleType->perjam_berikutnya,
            'max_perhari' => $vehicleType->max_perhari,
        ]);

        return redirect()->route('transactions.index')
            ->with('success', "Vehicle entered successfully! Ticket: {$no_tiket}");
    }

    /**
     * Handle the vehicle exit (Check-Out Kendaraan - MURNI HITUNGAN PER MENIT).
     */
    /**
     * Handle the vehicle exit (Check-Out Kendaraan - PROGRESSIVE MINUTELY).
     */
    public function exit(Request $request)
    {
        $validated = $request->validate([
            'no_tiket' => 'required|string',
        ]);

        $transaction = Transaction::where('no_tiket', $validated['no_tiket'])
            ->whereNull('keluar')
            ->first();

        if (!$transaction) {
            $transaction = Transaction::where('no_polisi', strtoupper(str_replace(' ', '', $validated['no_tiket'])))
                ->whereNull('keluar')
                ->first();

            if (!$transaction) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['no_tiket' => 'Active ticket or license plate not found.']);
            }
        }

        $masuk = Carbon::parse($transaction->masuk);
        $keluar = now();

        // 1. Ambil selisih menit murni bulat bersih
        $total_menit = (int) ceil($masuk->diffInMinutes($keluar));
        if ($total_menit < 1) {
            $total_menit = 1;
        }

        // 2. HITUNG TARIF BERDASARKAN RUMUS MENIT PROGRESIF
        $total_bayar = 0;
        if ($total_menit <= 1) {
            // Jika parkir hanya 1 menit atau kurang, hanya kena tarif menit pertama
            $total_bayar = $transaction->perjam_pertama; 
        } else {
            // Jika lebih dari 1 menit: menit_pertama + (menit_berikutnya * (total_menit - 1))
            $total_bayar = $transaction->perjam_pertama + ($transaction->perjam_berikutnya * ($total_menit - 1));
        }

        // 3. Batasan Maksimal Tarif Per Hari
        $days_murni = $masuk->diffInDays($keluar);
        if ($total_bayar < $transaction->max_perhari && $days_murni < 1) {
            $final_days = 0;
        } else {
            $final_days = $days_murni < 1 ? 1 : $days_murni;
        }

        $hitung_hari_untuk_caps = $final_days < 1 ? 1 : $final_days;
        $max_cap = $transaction->max_perhari * $hitung_hari_untuk_caps;
        
        // Bandingkan nominal hitungan menit progresif dengan batas max per hari, pilih terkecil
        $total_bayar_akhir = min($total_bayar, $max_cap);

        // 4. Update database dengan data bersih
        $transaction->update([
            'keluar' => $keluar,
            'total_jam' => $total_menit, // Menyimpan total menit asli
            'total_bayar' => $total_bayar_akhir,
        ]);

        $formattedBayar = 'Rp ' . number_format($total_bayar_akhir, 0, ',', '.');
        return redirect()->route('transactions.index')
            ->with('success', "Vehicle exited successfully! Ticket: {$transaction->no_tiket}. Total: {$formattedBayar} ({$total_menit} minutes)");
    }

    /**
     * Print ticket metadata into PDF block view.
     */
    public function print($no_tiket)
    {
        $transaction = Transaction::with(['location', 'vehicleType'])
            ->where('no_tiket', $no_tiket)
            ->firstOrFail();

        $pdf = PDF::loadView('transactions.print', compact('transaction'));

        $fileName = 'ticket-' . $no_tiket . '.pdf';
        $filePath = 'tickets/' . $fileName;

        if (!Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->put($filePath, $pdf->output());
        }

        return response()->file(storage_path('app/public/' . $filePath));
    }
}