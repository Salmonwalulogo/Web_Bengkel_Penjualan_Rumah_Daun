    @vite('resources/css/backend/history.css')
@extends('backend.layouts.mechanic')

@section('title', 'Riwayat')
@section('page-title', 'Riwayat Pekerjaan')

@section('content')
<div class="card">
    <div class="card-header">
        <i class="bi bi-clock-history me-2"></i>Riwayat Pekerjaan Selesai
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
                        <th>Tanggal Servis</th>
                        <th>Tanggal Selesai</th>
                        <th>Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($history as $item)
                    <tr>
                        <td><strong>#{{ $item->id }}</strong></td>
                        <td>
                            <div>{{ $item->user->name ?? '-' }}</div>
                            <small class="text-muted">{{ $item->user->no_hp ?? '' }}</small>
                        </td>
                        <td>
                            <span class="badge bg-dark">{{ $item->vehicle->plate_number ?? '-' }}</span>
                            <br><small>{{ $item->vehicle->brand ?? '' }} {{ $item->vehicle->model ?? '' }}</small>
                        </td>
                        <td>{{ $item->service->name ?? '-' }}</td>
                        <td>
                            <div>{{ \Carbon\Carbon::parse($item->booking_date)->format('d/m/Y') }}</div>
                            <small class="text-muted">{{ $item->booking_time }}</small>
                        </td>
                        <td>{{ $item->updated_at->format('d/m/Y H:i') }}</td>
                        <td><small>{{ Str::limit($item->notes ?? '-', 50) }}</small></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            <i class="bi bi-clock-history page-style-1" ></i>
                            <p class="mt-2">Belum ada riwayat pekerjaan</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($history->hasPages())
        <div class="mt-3">{{ $history->links() }}</div>
        @endif
    </div>
</div>
@endsection