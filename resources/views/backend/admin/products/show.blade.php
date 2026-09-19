    @vite('resources/css/backend/show.css')
@extends('backend.layouts.admin')

@section('title', 'Detail Produk')
@section('page-title', 'Detail Produk')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0"><i class="fas fa-box me-2"></i>{{ $product->name }}</h2>
    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="row g-4">
            <div class="col-md-4 text-center">
                <img src="{{ $product->foto ? asset('storage/' . $product->foto) : asset('images/no-image.png') }}"
                     alt="{{ $product->name }}" class="img-fluid rounded page-style-1" >
            </div>
            <div class="col-md-8">
                <dl class="row mb-0">
                    <dt class="col-sm-4">Nama</dt>
                    <dd class="col-sm-8">{{ $product->name }}</dd>
                    <dt class="col-sm-4">Kategori</dt>
                    <dd class="col-sm-8">{{ $product->category->name ?? '-' }}</dd>
                    <dt class="col-sm-4">Harga</dt>
                    <dd class="col-sm-8 fw-bold">Rp {{ number_format($product->harga, 0, ',', '.') }}</dd>
                    <dt class="col-sm-4">Stok</dt>
                    <dd class="col-sm-8">{{ $product->stok }}</dd>
                    <dt class="col-sm-4">Status</dt>
                    <dd class="col-sm-8"><span class="badge {{ $product->status === 'active' ? 'bg-success' : 'bg-danger' }}">{{ ucfirst($product->status) }}</span></dd>
                    <dt class="col-sm-4">Deskripsi</dt>
                    <dd class="col-sm-8">{{ $product->description ?: '-' }}</dd>
                </dl>
                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-primary mt-3">
                    <i class="fas fa-edit me-2"></i>Edit Produk
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
