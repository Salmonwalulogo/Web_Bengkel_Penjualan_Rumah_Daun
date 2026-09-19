@extends('backend.layouts.admin')
@section('title', 'Laporan')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Laporan & Statistik</h2>
</div>

<!-- Filter -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.reports.index') }}" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label fw-bold">Tanggal Mulai</label>
                <input type="date" name="start_date" value="{{ $startDate }}" class="form-control">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold">Tanggal Akhir</label>
                <input type="date" name="end_date" value="{{ $endDate }}" class="form-control">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search me-2"></i>Tampilkan</button>
            </div>
        </form>
    </div>
</div>

<!-- Stats Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon green"><i class="fas fa-dollar-sign"></i></div>
            <div>
                <div class="stat-value">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
                <div class="stat-label">Total Pendapatan</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon blue"><i class="fas fa-receipt"></i></div>
            <div>
                <div class="stat-value">{{ $totalTransactions }}</div>
                <div class="stat-label">Total Transaksi</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon orange"><i class="fas fa-calendar-check"></i></div>
            <div>
                <div class="stat-value">{{ $totalBookings }}</div>
                <div class="stat-label">Total Booking</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon purple"><i class="fas fa-users"></i></div>
            <div>
                <div class="stat-value">{{ $totalCustomers }}</div>
                <div class="stat-label">Customer Baru</div>
            </div>
        </div>
    </div>
</div>

<!-- Top Services & Products -->
<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header"><h5 class="mb-0"><i class="fas fa-trophy text-warning me-2"></i>Layanan Terpopuler</h5></div>
            <div class="card-body">
                @forelse($topServices as $service)
                <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                    <div><div class="fw-bold">{{ $service->name }}</div><small class="text-muted">Rp {{ number_format($service->harga, 0, ',', '.') }}</small></div>
                    <span class="badge bg-primary rounded-pill">{{ $service->bookings_count }} booking</span>
                </div>
                @empty
                <p class="text-muted text-center mb-0">Belum ada data</p>
                @endforelse
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header"><h5 class="mb-0"><i class="fas fa-box text-success me-2"></i>Produk Terlaris</h5></div>
            <div class="card-body">
                @forelse($topProducts as $product)
                <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                    <div><div class="fw-bold">{{ $product->name }}</div><small class="text-muted">Rp {{ number_format($product->harga, 0, ',', '.') }}</small></div>
                    <span class="badge bg-success rounded-pill">{{ $product->transaction_details_count }} terjual</span>
                </div>
                @empty
                <p class="text-muted text-center mb-0">Belum ada data</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Recent Transactions -->
<div class="card">
    <div class="card-header"><h5 class="mb-0"><i class="fas fa-history text-primary me-2"></i>Transaksi Terbaru</h5></div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead><tr><th>Invoice</th><th>Customer</th><th>Total</th><th>Metode</th><th>Status</th><th>Tanggal</th></tr></thead>
                <tbody>
                    @forelse($transactions as $trx)
                    <tr>
                        <td><strong class="text-primary">{{ $trx->invoice_number }}</strong></td>
                        <td>{{ $trx->user->name ?? '-' }}</td>
                        <td class="fw-bold">Rp {{ number_format($trx->total_payment, 0, ',', '.') }}</td>
                        <td><span class="badge bg-secondary">{{ ucfirst($trx->payment_method) }}</span></td>
                        <td><span class="badge {{ $trx->status === 'completed' ? 'bg-success' : ($trx->status === 'cancelled' ? 'bg-danger' : 'bg-warning') }}">{{ ucfirst($trx->status) }}</span></td>
                        <td>{{ $trx->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center text-muted">Belum ada transaksi</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($transactions->hasPages())<div class="mt-3">{{ $transactions->links() }}</div>@endif
    </div>
</div>
@endsection