@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-custom">
                <div class="card-custom-header">
                    <div>
                        <h5 class="m-0 font-weight-bold text-dark"><i
                                class="fa-solid fa-list-check text-primary me-2"></i>Parking Transactions History</h5>
                        <p class="text-muted small m-0 mt-1">Daftar seluruh riwayat kendaraan masuk dan keluar di sistem</p>
                    </div>
                    <a href="{{ route('transactions.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill">
                        <i class="fa-solid fa-arrow-left me-1"></i> Back to Dashboard
                    </a>
                </div>
                <div class="card-custom-body">
                    <div class="table-responsive">
                        <table class="table table-custom table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Ticket Number</th>
                                    <th>Location</th>
                                    <th>Vehicle Type</th>
                                    <th>Plate Number</th>
                                    <th>Entry Time</th>
                                    <th>Exit Time</th>
                                    <th>Duration (Menit)</th>
                                    <th>Total Fee</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transactions as $index => $tx)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <strong>{{ $tx->no_tiket }}</strong>
                                            <a href="{{ route('transactions.print_ticket', $tx->id) }}" target="_blank"
                                                class="ms-1 text-muted" title="Buka/Cetak Tiket HTML">
                                                <i class="fa-solid fa-print"></i>
                                            </a>
                                        </td>
                                        <td>{{ $tx->location->location_name }}</td>
                                        <td>{{ ucfirst($tx->vehicleType->jenis) }}</td>
                                        <td><span class="badge bg-dark px-2 py-1">{{ $tx->no_polisi ?? '-' }}</span></td>
                                        <td>{{ $tx->masuk->format('d/m/Y H:i') }}</td>
                                        <td>{{ $tx->keluar ? $tx->keluar->format('d/m/Y H:i') : '-' }}</td>
                                        <td>{{ $tx->total_menit ? $tx->total_menit . ' Menit' : '-' }}</td>
                                        <td>
                                            @if($tx->total_bayar !== null)
                                                <span class="text-success font-weight-bold">Rp
                                                    {{ number_format($tx->total_bayar, 0, ',', '.') }}</span>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if($tx->keluar === null)
                                                <span class="badge-parked"><i class="fa-solid fa-spinner fa-spin me-1"></i>
                                                    Parked</span>
                                            @else
                                                <span class="badge-exited"><i class="fa-solid fa-check me-1"></i> Exited</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center py-4 text-muted">No transactions found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection