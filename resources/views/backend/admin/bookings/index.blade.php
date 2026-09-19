@extends('backend.layouts.admin')

@section('title', 'Booking')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0"><i class="fas fa-calendar-check me-2"></i>Booking</h2>
    <a href="{{ route('admin.bookings.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Tambah Booking
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Customer</th>
                        <th>Kendaraan</th>
                        <th>Layanan</th>
                        <th>Mekanik</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                    <tr>
                        <td><strong>#{{ $booking->id }}</strong></td>
                        <td>{{ $booking->user->name ?? '-' }}</td>
                        <td>
                            <span class="badge bg-dark">{{ $booking->vehicle->plate_number ?? '-' }}</span>
                        </td>
                        <td>{{ $booking->service->name ?? '-' }}</td>
                        <td>{{ $booking->mechanic->name ?? 'Belum ditugaskan' }}</td>
                        <td>
                            <div>{{ $booking->booking_date->format('d/m/Y') }}</div>
                            <small class="text-muted">{{ $booking->booking_time }}</small>
                        </td>
                        <td>
                            @php
                                $badgeClass = match($booking->status) {
                                    'pending' => 'bg-warning',
                                    'confirmed' => 'bg-info',
                                    'in_progress' => 'bg-primary',
                                    'completed' => 'bg-success',
                                    'cancelled' => 'bg-danger',
                                    default => 'bg-secondary'
                                };
                            @endphp
                            <span class="badge {{ $badgeClass }}">{{ ucfirst(str_replace('_', ' ', $booking->status)) }}</span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('admin.bookings.show', $booking) }}" class="btn-action btn-view" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.bookings.edit', $booking) }}" class="btn-action btn-edit" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.bookings.destroy', $booking) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus booking ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action btn-delete" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            <i class="fas fa-calendar fa-3x mb-3 d-block"></i>
                            Belum ada data booking
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