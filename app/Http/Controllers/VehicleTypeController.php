<?php

namespace App\Http\Controllers;

use App\Models\VehicleType;
use Illuminate\Http\Request;

class VehicleTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $vehicleTypes = VehicleType::when($search, function ($query, $search) {
            return $query->where('jenis', 'like', "%{$search}%");
        })->get();

        return view('vehicletypes.index', [
            'title' => 'Vehicle Type',
            'vehicleTypes' => $vehicleTypes,
            'search' => $search
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('vehicletypes.create', [
            'title' => 'Vehicle Type'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenis' => 'required|in:motorcycle,car,other',
            'perjam_pertama' => 'required|integer|min:0',
            'perjam_berikutnya' => 'required|integer|min:0',
            'max_perhari' => 'required|integer|min:0',
        ]);

        // Check if this jenis already exists to prevent duplicate types
        $exists = VehicleType::where('jenis', $validated['jenis'])->exists();
        if ($exists) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['jenis' => 'This vehicle type already exists.']);
        }

        VehicleType::create($validated);

        return redirect()->route('vehicletypes.index')->with('success', 'New Vehicle Type was successfully saved!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VehicleType $vehicletype)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VehicleType $vehicletype)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VehicleType $vehicletype)
    {

    }
}
