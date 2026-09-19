@extends('backend.layouts.customer')

@section('title', 'Booking Saya')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4"><h1 class="h3 mb-0 text-gray-800">Booking Saya</h1><a href="{{ route('customer.booking.create') }}" class="btn btn-success"><i class="fas fa-plus me-2"></i>Booking Baru</a></div>
    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    <div class="card shadow"><div class="card-body"><div class="table-responsive"><table class="table align-middle"><thead><tr><th>Tanggal</th><th>Kendaraan</th><th>Layanan</th><th>Keluhan</th><th>Status</th></tr></thead><tbody>
    @forelse($bookings as $booking)<tr><td>{{ $booking->booking_date?->format('d/m/Y') }}<br><small>{{ $booking->booking_time }}</small></td><td>{{ $booking->vehicle->plate_number ?? '-' }}</td><td>{{ $booking->service->name ?? '-' }}</td><td>{{ Str::limit($booking->complaint ?: '-', 35) }}</td><td><span class="badge {{ $booking->status_badge }}">{{ $booking->status_label }}</span></td></tr>
    @empty<tr><td colspan="5" class="text-center text-muted py-4">Belum ada booking.</td></tr>@endforelse
    </tbody></table></div>{{ $bookings->links() }}</div></div>
</div>
@endsection
