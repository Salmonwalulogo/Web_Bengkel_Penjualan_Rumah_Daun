    @vite('resources/css/backend/jobs.css')
@extends('backend.layouts.mechanic')

@section('title', 'Pekerjaan')
@section('page-title', 'Pekerjaan Saya')

@section('content')
<div class="card">
    <div class="card-header">
        <i class="bi bi-clipboard-check me-2"></i>Pekerjaan yang Sedang Dikerjakan
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
                        <th>Keluhan</th>
                        <th>Catatan</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jobs as $job)
                    <tr>
                        <td><strong>#{{ $job->id }}</strong></td>
                        <td>
                            <div>{{ $job->user->name ?? '-' }}</div>
                            <small class="text-muted">{{ $job->user->no_hp ?? '' }}</small>
                        </td>
                        <td>
                            <span class="badge bg-dark">{{ $job->vehicle->plate_number ?? '-' }}</span>
                            <br><small>{{ $job->vehicle->brand ?? '' }} {{ $job->vehicle->model ?? '' }}</small>
                        </td>
                        <td>{{ $job->service->name ?? '-' }}</td>
                        <td>
                            <div>{{ \Carbon\Carbon::parse($job->booking_date)->format('d/m/Y') }}</div>
                            <small class="text-muted">{{ $job->booking_time }}</small>
                        </td>
                        <td><small>{{ Str::limit($job->complaint ?? '-', 40) }}</small></td>
                        <td><small>{{ Str::limit($job->notes ?? '-', 40) }}</small></td>
                        <td class="text-center">
                            <form action="{{ route('mekanik.bookings.updateStatus', $job) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="completed">
                                <button type="submit" class="btn-action btn-view" title="Selesaikan" onclick="return confirm('Yakin ingin menyelesaikan pekerjaan ini?')">
                                    <i class="bi bi-check-lg"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            <i class="bi bi-clipboard page-style-1" ></i>
                            <p class="mt-2">Tidak ada pekerjaan yang sedang dikerjakan</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($jobs->hasPages())
        <div class="mt-3">{{ $jobs->links() }}</div>
        @endif
    </div>
</div>
@endsection