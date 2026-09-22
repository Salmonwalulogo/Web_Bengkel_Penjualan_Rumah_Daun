    @vite('resources/css/backend/show.css')
@extends('backend.layouts.admin')

@section('title', 'Detail User')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0"><i class="fas fa-user me-2"></i>Detail User</h2>
    <div>
        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary">
            <i class="fas fa-edit me-2"></i>Edit
        </a>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                @if($user->photo)
                    <img src="{{ asset('storage/' . $user->photo) }}" alt="{{ $user->name }}" 
                         class="rounded-circle mb-3 page-style-1" >
                @else
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3 page-style-2" 
                         >
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                @endif
                <h4>{{ $user->name }}</h4>
                @php
                    $badgeClass = match($user->role) {
                        'admin' => 'bg-danger',
                        'kasir' => 'bg-warning',
                        'customer' => 'bg-success',
                        default => 'bg-secondary'
                    };
                @endphp
                <span class="badge {{ $badgeClass }} mb-3">{{ ucfirst($user->role) }}</span>
                <p class="text-muted mb-0">{{ $user->email }}</p>
                <p class="text-muted">{{ $user->username }}</p>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-info-circle me-2"></i>Informasi User
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>Nama Lengkap</strong>
                        <p class="text-muted mb-0">{{ $user->name }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Email</strong>
                        <p class="text-muted mb-0">{{ $user->email }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Username</strong>
                        <p class="text-muted mb-0">{{ $user->username }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>No. HP</strong>
                        <p class="text-muted mb-0">{{ $user->no_hp ?? '-' }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Role</strong>
                        <p class="text-muted mb-0">{{ ucfirst($user->role) }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Bergabung</strong>
                        <p class="text-muted mb-0">{{ $user->created_at->format('d F Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>

        @if($user->role === 'customer')
        <div class="card mt-3">
            <div class="card-header">
                <i class="fas fa-motorcycle me-2"></i>Kendaraan
            </div>
            <div class="card-body">
                @forelse($user->vehicles as $vehicle)
                    <div class="border rounded p-3 mb-2">
                        <div class="row">
                            <div class="col-md-4"><strong>Plat Nomor:</strong> {{ $vehicle->plate_number }}</div>
                            <div class="col-md-4"><strong>Merek:</strong> {{ $vehicle->brand }}</div>
                            <div class="col-md-4"><strong>Model:</strong> {{ $vehicle->model }}</div>
                        </div>
                    </div>
                @empty
                    <p class="text-muted mb-0">Belum ada kendaraan terdaftar</p>
                @endforelse
            </div>
        </div>
        @endif
    </div>
</div>
@endsection