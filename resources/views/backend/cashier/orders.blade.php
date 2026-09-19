@extends('backend.layouts.cashier')

@section('title', 'Pesanan')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><i class="fas fa-shopping-bag me-2"></i>Pesanan</h1>

    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Customer</th>
                            <th>Kendaraan</th>
                            <th>Layanan</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $booking)
                        <tr>
                            <td><strong>#{{ $booking->id }}</strong></td>
                            <td>{{ $booking->user->name ?? '-' }}</td>
                            <td>{{ $booking->vehicle->plate_number ?? '-' }}</td>
                            <td>{{ $booking->service->name ?? '-' }}</td>
                            <td>{{ $booking->booking_date?->format('d/m/Y') ?? '-' }} {{ $booking->booking_time }}</td>
                            <td><span class="badge {{ $booking->status_badge }}">{{ $booking->status_label }}</span></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">Belum ada pesanan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $bookings->links() }}
        </div>
    </div>
</div>
@endsection
