@extends('backend.layouts.admin')

@section('title', 'Pengaturan Akun')
@section('page-title', 'Pengaturan Akun & Keamanan')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header fw-bold">
                <i class="fas fa-key me-2"></i>Ubah Password
            </div>
            <div class="card-body">
                <form action="{{ route('admin.settings.account.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Password Saat Ini <span class="text-danger">*</span></label>
                        <input type="password" name="current_password" class="form-control" required>
                        @error('current_password')<div class="text-danger small">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password Baru <span class="text-danger">*</span></label>
                        <input type="password" name="new_password" class="form-control" required>
                        <small class="text-muted">Minimal 6 karakter</small>
                        @error('new_password')<div class="text-danger small">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Konfirmasi Password Baru <span class="text-danger">*</span></label>
                        <input type="password" name="new_password_confirmation" class="form-control" required>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Ubah Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header fw-bold">
                <i class="fas fa-shield-alt me-2"></i>Keamanan Akun
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Status Akun</strong>
                    <p class="text-success mb-0"><i class="fas fa-check-circle me-2"></i>Aktif</p>
                </div>
                <div class="mb-3">
                    <strong>Terakhir Login</strong>
                    <p class="text-muted mb-0">{{ auth()->user()->updated_at->format('d/m/Y H:i') }}</p>
                </div>
                <div class="mb-3">
                    <strong>Role</strong>
                    <p class="mb-0"><span class="badge bg-primary">{{ ucfirst(auth()->user()->role) }}</span></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection