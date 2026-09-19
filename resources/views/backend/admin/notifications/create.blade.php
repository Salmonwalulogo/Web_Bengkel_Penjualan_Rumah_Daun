@extends('backend.layouts.admin')

@section('title', 'Kirim Notifikasi')
@section('page-title', 'Kirim Notifikasi')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0"><i class="fas fa-bell me-2"></i>Kirim Notifikasi</h2>
    <a href="{{ route('admin.notifications.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.notifications.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="user_id" class="form-label">Penerima <span class="text-danger">*</span></label>
                    <select id="user_id" name="user_id" class="form-select @error('user_id') is-invalid @enderror" required>
                        <option value="">Pilih penerima</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->role }})
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label for="type" class="form-label">Tipe</label>
                    <select id="type" name="type" class="form-select @error('type') is-invalid @enderror">
                        <option value="general">Umum</option>
                        <option value="booking" {{ old('type') === 'booking' ? 'selected' : '' }}>Booking</option>
                        <option value="payment" {{ old('type') === 'payment' ? 'selected' : '' }}>Pembayaran</option>
                        <option value="system" {{ old('type') === 'system' ? 'selected' : '' }}>Sistem</option>
                    </select>
                    @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <label for="title" class="form-label">Judul <span class="text-danger">*</span></label>
                    <input id="title" type="text" name="title" value="{{ old('title') }}" class="form-control @error('title') is-invalid @enderror" required>
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <label for="message" class="form-label">Pesan <span class="text-danger">*</span></label>
                    <textarea id="message" name="message" rows="5" class="form-control @error('message') is-invalid @enderror" required>{{ old('message') }}</textarea>
                    @error('message')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('admin.notifications.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane me-2"></i>Kirim Notifikasi</button>
            </div>
        </form>
    </div>
</div>
@endsection
