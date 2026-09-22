@extends('backend.layouts.customer')

@section('title', 'Customer Dashboard')

@section('content')
<div class="container-fluid">
    <div class="dashboard-hero customer-hero mb-4">
        <div>
            <span class="dashboard-eyebrow"><i class="fas fa-hand-sparkles me-2"></i>AREA PELANGGAN</span>
            <h1>Hai, {{ auth()->user()->name }}!</h1>
            <p>Rawat kendaraanmu dengan mudah. Booking servis, cek transaksi, dan pantau status kendaraan dari sini.</p>
        </div>
        <a href="{{ route('customer.booking.create') }}" class="dashboard-hero-action"><i class="fas fa-calendar-check me-2"></i>Booking Servis</a>
    </div>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card stat-card-modern h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Transaksi</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $transactionCount }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-receipt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card stat-card-modern h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Kendaraan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $vehicleCount }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-car fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card stat-card-modern h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Booking Aktif</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $activeBookingCount }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="quick-actions mb-4">
        <a href="{{ route('customer.booking.create') }}"><i class="fas fa-calendar-plus"></i><span>Booking Servis</span><small>Pilih jadwal dan layanan</small></a>
        <a href="{{ route('customer.vehicles') }}"><i class="fas fa-motorcycle"></i><span>Kendaraan Saya</span><small>Kelola data kendaraan</small></a>
        <a href="{{ route('produk') }}"><i class="fas fa-store"></i><span>Belanja Produk</span><small>Lihat suku cadang</small></a>
        <a href="{{ route('customer.transactions') }}"><i class="fas fa-receipt"></i><span>Transaksi</span><small>Cek riwayat pembayaran</small></a>
    </div>
</div>
@endsection