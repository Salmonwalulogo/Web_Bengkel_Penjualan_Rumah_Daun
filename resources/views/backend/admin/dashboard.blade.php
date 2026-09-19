@extends('backend.layouts.admin')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-2 fw-bold">Dashboard Admin</h2>
        <p class="text-muted mb-0">Selamat datang kembali, {{ auth()->user()->name }}! 👋</p>
    </div>
    <a href="{{ route('admin.reports.index') }}" class="btn btn-primary">
        <i class="fas fa-download me-2"></i>Generate Report
    </a>
</div>

<!-- Statistics Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon blue">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-value">{{ \App\Models\User::count() }}</div>
            <div class="stat-label">Total Users</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon green">
                <i class="fas fa-box"></i>
            </div>
            <div class="stat-value">{{ \App\Models\Product::count() }}</div>
            <div class="stat-label">Total Produk</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon orange">
                <i class="fas fa-calendar-day"></i>
            </div>
            <div class="stat-value">{{ \App\Models\Booking::whereDate('booking_date', today())->count() }}</div>
            <div class="stat-label">Booking Hari Ini</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon purple">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="stat-value">Rp {{ number_format(\App\Models\Transaction::whereMonth('created_at', now()->month)->where('status', 'completed')->sum('total_payment'), 0, ',', '.') }}</div>
            <div class="stat-label">Pendapatan Bulan Ini</div>
        </div>
    </div>
</div>

<!-- Welcome Alert -->
<div class="alert alert-info border-0 shadow-sm">
    <i class="fas fa-info-circle me-2"></i>
    Selamat datang di panel admin. Statistik akan ditampilkan di sini setelah data tersedia.
</div>

<!-- Recent Activity -->
<div class="row g-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-calendar-check me-2"></i>Booking Terbaru
            </div>
            <div class="card-body">
                @forelse(\App\Models\Booking::with(['user', 'service'])->latest()->take(5)->get() as $booking)
                <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                    <div>
                        <div class="fw-bold">{{ $booking->user->name ?? '-' }}</div>
                        <small class="text-muted">{{ $booking->service->name ?? '-' }}</small>
                    </div>
                    <span class="badge {{ $booking->status === 'completed' ? 'bg-success' : ($booking->status === 'pending' ? 'bg-warning' : 'bg-info') }}">
                        {{ ucfirst($booking->status) }}
                    </span>
                </div>
                @empty
                <p class="text-muted text-center mb-0">Belum ada booking</p>
                @endforelse
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-receipt me-2"></i>Transaksi Terbaru
            </div>
            <div class="card-body">
                @forelse(\App\Models\Transaction::with('user')->latest()->take(5)->get() as $trx)
                <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                    <div>
                        <div class="fw-bold">{{ $trx->invoice_number }}</div>
                        <small class="text-muted">{{ $trx->user->name ?? '-' }}</small>
                    </div>
                    <div class="text-end">
                        <div class="fw-bold">Rp {{ number_format($trx->total_payment, 0, ',', '.') }}</div>
                        <small class="{{ $trx->status === 'completed' ? 'text-success' : 'text-warning' }}">
                            {{ ucfirst($trx->status) }}
                        </small>
                    </div>
                </div>
                @empty
                <p class="text-muted text-center mb-0">Belum ada transaksi</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection