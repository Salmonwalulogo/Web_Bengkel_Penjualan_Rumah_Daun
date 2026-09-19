    @vite('resources/css/backend/dashboard.css')
@extends('backend.layouts.mechanic')

@section('title', 'Dashboard Mekanik')
@section('page-title', 'Dashboard Mekanik')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon blue">
                <i class="bi bi-calendar-check"></i>
            </div>
            <div>
                <div class="stat-value">{{ $stats['today'] }}</div>
                <div class="stat-label">Booking Hari Ini</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon orange">
                <i class="bi bi-hourglass-split"></i>
            </div>
            <div>
                <div class="stat-value">{{ $stats['pending'] }}</div>
                <div class="stat-label">Menunggu Dikerjakan</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon purple">
                <i class="bi bi-tools"></i>
            </div>
            <div>
                <div class="stat-value">{{ $stats['in_progress'] }}</div>
                <div class="stat-label">Sedang Dikerjakan</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon green">
                <i class="bi bi-check-circle"></i>
            </div>
            <div>
                <div class="stat-value">{{ $stats['completed'] }}</div>
                <div class="stat-label">Selesai</div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="bi bi-calendar-check me-2"></i>Booking Terbaru</span>
        <a href="{{ route('mekanik.bookings') }}" class="btn btn-sm btn-mekanik">Lihat Semua</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
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
                    @forelse($recentBookings as $booking)
                    <tr>
                        <td><strong>#{{ $booking->id }}</strong></td>
                        <td>{{ $booking->user->name ?? '-' }}</td>
                        <td>
                            <span class="badge bg-dark">{{ $booking->vehicle->plate_number ?? '-' }}</span>
                            <br><small>{{ $booking->vehicle->brand ?? '' }} {{ $booking->vehicle->model ?? '' }}</small>
                        </td>
                        <td>{{ $booking->service->name ?? '-' }}</td>
                        <td>
                            <div>{{ \Carbon\Carbon::parse($booking->booking_date)->format('d/m/Y') }}</div>
                            <small class="text-muted">{{ $booking->booking_time }}</small>
                        </td>
                        <td>
                            @php
                                $badgeClass = 'badge-' . $booking->status;
                            @endphp
                            <span class="badge-status {{ $badgeClass }}">
                                {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            <i class="bi bi-calendar-x page-style-1" ></i>
                            <p class="mt-2">Belum ada booking yang ditugaskan</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection