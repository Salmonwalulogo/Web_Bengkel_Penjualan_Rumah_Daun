    @vite('resources/css/backend/bookings.css')
@extends('backend.layouts.mechanic')

@section('title', 'Booking Servis')
@section('page-title', 'Booking Servis')

@section('content')
<div class="card">
    <div class="card-header">
        <i class="bi bi-calendar-check me-2"></i>Daftar Booking Servis
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
                        <th>Tanggal & Waktu</th>
                        <th>Keluhan</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                    <tr>
                        <td><strong>#{{ $booking->id }}</strong></td>
                        <td>
                            <div>{{ $booking->user->name ?? '-' }}</div>
                            <small class="text-muted">{{ $booking->user->no_hp ?? '' }}</small>
                        </td>
                        <td>
                            <span class="badge bg-dark">{{ $booking->vehicle->plate_number ?? '-' }}</span>
                            <br><small>{{ $booking->vehicle->brand ?? '' }} {{ $booking->vehicle->model ?? '' }}</small>
                        </td>
                        <td>{{ $booking->service->name ?? '-' }}</td>
                        <td>
                            <div>{{ \Carbon\Carbon::parse($booking->booking_date)->format('d/m/Y') }}</div>
                            <small class="text-muted">{{ $booking->booking_time }}</small>
                        </td>
                        <td><small>{{ Str::limit($booking->complaint ?? '-', 50) }}</small></td>
                        <td>
                            <span class="badge-status badge-{{ $booking->status }}">
                                {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                            </span>
                        </td>
                        <td class="text-center">
                            @if($booking->status === 'confirmed')
                            <form action="{{ route('mekanik.bookings.updateStatus', $booking) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="in_progress">
                                <button type="submit" class="btn-action btn-edit" title="Mulai Kerjakan">
                                    <i class="bi bi-play-fill"></i>
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            <i class="bi bi-calendar-x page-style-1" ></i>
                            <p class="mt-2">Tidak ada booking yang ditugaskan</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($bookings->hasPages())
        <div class="mt-3">{{ $bookings->links() }}</div>
        @endif
    </div>
</div>
@endsection