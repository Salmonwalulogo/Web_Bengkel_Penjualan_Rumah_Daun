    @vite('resources/css/backend/profile.css')
@extends('backend.layouts.admin')

@section('title', 'Pengaturan Profil')
@section('page-title', 'Pengaturan Profil Saya')

@section('content')
<div class="row">
    <!-- Profile Card -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                @if(auth()->user()->photo)
                    <img src="{{ asset('storage/' . auth()->user()->photo) }}" 
                         class="rounded-circle mb-3 page-style-1" 
                         >
                @else
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3 page-style-2" 
                         >
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                @endif
                <h5 class="fw-bold mb-1">{{ auth()->user()->name }}</h5>
                <span class="badge bg-primary mb-3">{{ ucfirst(auth()->user()->role) }}</span>
                <p class="text-muted mb-1">
                    <i class="fas fa-envelope me-2"></i>{{ auth()->user()->email }}
                </p>
                @if(auth()->user()->no_hp)
                <p class="text-muted mb-0">
                    <i class="fas fa-phone me-2"></i>{{ auth()->user()->no_hp }}
                </p>
                @endif
            </div>
        </div>
    </div>

    <!-- Edit Form -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header fw-bold">
                <i class="fas fa-user-edit me-2"></i>Edit Profil Saya
            </div>
            <div class="card-body">
                <form action="{{ route('admin.settings.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" 
                                   value="{{ old('name', auth()->user()->name) }}" required>
                            @error('name')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Username <span class="text-danger">*</span></label>
                            <input type="text" name="username" class="form-control" 
                                   value="{{ old('username', auth()->user()->username) }}" required>
                            @error('username')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" 
                                   value="{{ old('email', auth()->user()->email) }}" required>
                            @error('email')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">No. HP</label>
                            <input type="text" name="no_hp" class="form-control" 
                                   value="{{ old('no_hp', auth()->user()->no_hp) }}">
                            @error('no_hp')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Foto Profil</label>
                            <input type="file" name="photo" class="form-control" accept="image/*">
                            <small class="text-muted">Format: JPG, PNG. Maksimal 2MB</small>
                            @error('photo')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection