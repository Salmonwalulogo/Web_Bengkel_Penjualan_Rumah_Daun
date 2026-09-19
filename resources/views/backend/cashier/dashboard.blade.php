@extends('backend.layouts.cashier')

@section('title', 'Kasir Dashboard')
@section('page-title', 'Ringkasan Operasional')

@section('content')
<div class="container-fluid">
    <div class="page-heading">
        <h1>Dashboard Kasir</h1>
        <p>Pantau pesanan dan pembayaran bengkel dalam satu tampilan.</p>
    </div>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100 stat-card stat-card-amber">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Pesanan Pending</div>
                            <div class="h3 mb-0 font-weight-bold text-gray-800">{{ $pendingOrders }}</div>
                        </div>
                        <div class="col-auto">
                            <span class="stat-icon"><i class="fas fa-shopping-cart"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100 stat-card stat-card-teal">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Pembayaran Hari Ini</div>
                            <div class="h3 mb-0 font-weight-bold text-gray-800">{{ $todayPayments }}</div>
                        </div>
                        <div class="col-auto">
                            <span class="stat-icon"><i class="fas fa-money-bill-wave"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100 stat-card stat-card-blue">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Transaksi</div>
                            <div class="h3 mb-0 font-weight-bold text-gray-800">{{ $totalTransactions }}</div>
                        </div>
                        <div class="col-auto">
                            <span class="stat-icon"><i class="fas fa-receipt"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="welcome-panel">
        <i class="fas fa-cash-register me-2"></i>
        Selamat datang, {{ auth()->user()->name }}! Proses pembayaran dan kelola pesanan di sini.
    </div>
</div>
@endsection