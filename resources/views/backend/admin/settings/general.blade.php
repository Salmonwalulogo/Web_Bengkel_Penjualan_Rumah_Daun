@extends('backend.layouts.admin')

@section('title', 'Pengaturan Bengkel')
@section('page-title', 'Pengaturan Bengkel')

@section('content')
<div class="card">
    <div class="card-header fw-bold">
        <i class="fas fa-store me-2"></i>Informasi Bengkel
    </div>
    <div class="card-body">
        <form action="{{ route('admin.settings.general.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Bengkel <span class="text-danger">*</span></label>
                    <input type="text" name="nama_bengkel" class="form-control" value="{{ old('nama_bengkel', $settings['nama_bengkel']) }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Telepon</label>
                    <input type="text" name="telepon" class="form-control" value="{{ old('telepon', $settings['telepon']) }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $settings['email']) }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Jam Operasional</label>
                    <input type="text" name="jam_operasional" class="form-control" value="{{ old('jam_operasional', $settings['jam_operasional']) }}" placeholder="Contoh: 08:00 - 17:00">
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" class="form-control" rows="3">{{ old('alamat', $settings['alamat']) }}</textarea>
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="4">{{ old('deskripsi', $settings['deskripsi']) }}</textarea>
                </div>
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Simpan Pengaturan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection