@extends('backend.layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">Dashboard</h2>
    <div>
        <span class="text-muted">{{ now()->format('d F Y') }}</span>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon blue">
                <i class="fas fa-users"></i>
            </div>
            <div>
                <div class="stat-value">{{ \App\Models\User::where('role', 'customer')->count() }}</div>
                <div class="stat-label">Total Customer</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon green">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div>
                <div class="stat-value">{{ \App\Models\Booking::whereDate('booking_date', today())->count() }}</div>
                <div class="stat-label">Booking Hari Ini</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon orange">
                <i class="fas fa-receipt"></i>
            </div>
            <div>
                <div class="stat-value">{{ \App\Models\Transaction::whereDate('created_at', today())->count() }}</div>
                <div class="stat-label">Transaksi Hari Ini</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon purple">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div>
                <div class="stat-value">Rp {{ number_format(\App\Models\Transaction::whereDate('created_at', today())->sum('total_payment'), 0, ',', '.') }}</div>
                <div class="stat-label">Pendapatan Hari Ini</div>
            </div>
        </div>
    </div>
</div>

<!-- Additional Stats -->
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-box me-2"></i>Produk
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span>Total Produk</span>
                    <strong>{{ \App\Models\Product::count() }}</strong>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Produk Aktif</span>
                    <strong class="text-success">{{ \App\Models\Product::where('status', 'active')->count() }}</strong>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Stok Menipis</span>
                    <strong class="text-danger">{{ \App\Models\Product::where('stok', '<', 10)->count() }}</strong>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-wrench me-2"></i>Layanan
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span>Total Layanan</span>
                    <strong>{{ \App\Models\Service::count() }}</strong>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Layanan Aktif</span>
                    <strong class="text-success">{{ \App\Models\Service::where('status', 'active')->count() }}</strong>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Booking Bulan Ini</span>
                    <strong>{{ \App\Models\Booking::whereMonth('created_at', now()->month)->count() }}</strong>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-motorcycle me-2"></i>Kendaraan
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span>Total Kendaraan</span>
                    <strong>{{ \App\Models\Vehicle::count() }}</strong>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Customer Punya Kendaraan</span>
                    <strong>{{ \App\Models\Vehicle::distinct('user_id')->count('user_id') }}</strong>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Booking Pending</span>
                    <strong class="text-warning">{{ \App\Models\Booking::where('status', 'pending')->count() }}</strong>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Bookings -->
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-calendar-check me-2"></i>Booking Terbaru</span>
        <a href="{{ route('admin.bookings.index') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
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
                    @forelse(\App\Models\Booking::with(['user', 'vehicle', 'service'])->latest()->take(5)->get() as $booking)
                    <tr>
                        <td><strong>#{{ $booking->id }}</strong></td>
                        <td>{{ $booking->user->name }}</td>
                        <td>{{ $booking->vehicle->plate_number }}</td>
                        <td>{{ $booking->service->name }}</td>
                        <td>{{ $booking->booking_date->format('d/m/Y') }} {{ $booking->booking_time }}</td>
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
                            <span class="badge {{ $badgeClass }}">{{ ucfirst($booking->status) }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">Belum ada booking</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Recent Transactions -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-receipt me-2"></i>Transaksi Terbaru</span>
        <a href="{{ route('admin.transactions.index') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Invoice</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th>Metode</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse(\App\Models\Transaction::with('user')->latest()->take(5)->get() as $trx)
                    <tr>
                        <td><strong class="text-primary">{{ $trx->invoice_number }}</strong></td>
                        <td>{{ $trx->user->name }}</td>
                        <td class="fw-bold">Rp {{ number_format($trx->total_payment, 0, ',', '.') }}</td>
                        <td><span class="badge bg-secondary">{{ ucfirst($trx->payment_method) }}</span></td>
                        <td>
                            <span class="badge {{ $trx->status === 'completed' ? 'bg-success' : ($trx->status === 'cancelled' ? 'bg-danger' : 'bg-warning') }}">
                                {{ ucfirst($trx->status) }}
                            </span>
                        </td>
                        <td>{{ $trx->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">Belum ada transaksi</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection