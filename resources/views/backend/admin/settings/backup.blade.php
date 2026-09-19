@extends('backend.layouts.admin')

@section('title', 'Backup & Restore')
@section('page-title', 'Backup & Restore Database')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header fw-bold">
                <i class="fas fa-download me-2"></i>Backup Database
            </div>
            <div class="card-body">
                <p class="text-muted mb-4">Download backup database dalam format SQL untuk keamanan data.</p>
                
                <div class="mb-3">
                    <strong>Database:</strong>
                    <p class="text-primary mb-0">db_bengkel</p>
                </div>
                
                <div class="mb-3">
                    <strong>Ukuran:</strong>
                    <p class="mb-0">~2.5 MB</p>
                </div>
                
                <div class="mb-4">
                    <strong>Terakhir Backup:</strong>
                    <p class="mb-0">Belum pernah</p>
                </div>

                <button class="btn btn-primary w-100" onclick="alert('Fitur backup akan segera tersedia!')">
                    <i class="fas fa-download me-2"></i>Download Backup
                </button>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header fw-bold">
                <i class="fas fa-upload me-2"></i>Restore Database
            </div>
            <div class="card-body">
                <p class="text-muted mb-4">Upload file backup SQL untuk mengembalikan database.</p>
                
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Perhatian!</strong> Restore database akan menggantikan semua data yang ada. Pastikan Anda sudah memiliki backup terbaru.
                </div>

                <div class="mb-3">
                    <label class="form-label">File Backup (.sql)</label>
                    <input type="file" class="form-control" accept=".sql">
                </div>

                <button class="btn btn-warning w-100" onclick="alert('Fitur restore akan segera tersedia!')">
                    <i class="fas fa-upload me-2"></i>Upload & Restore
                </button>
            </div>
        </div>
    </div>
</div>
@endsection