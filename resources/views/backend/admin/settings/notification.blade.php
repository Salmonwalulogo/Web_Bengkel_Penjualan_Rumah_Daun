@extends('backend.layouts.admin')

@section('title', 'Pengaturan Notifikasi')
@section('page-title', 'Pengaturan Notifikasi')

@section('content')
<div class="card">
    <div class="card-header fw-bold">
        <i class="fas fa-bell me-2"></i>Preferensi Notifikasi
    </div>
    <div class="card-body">
        <form action="{{ route('admin.settings.notification.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <h6 class="fw-bold mb-3"><i class="fas fa-envelope me-2"></i>Notifikasi Email</h6>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="email_notification" id="emailNotif" checked>
                    <label class="form-check-label" for="emailNotif">
                        Aktifkan notifikasi via email
                    </label>
                </div>
            </div>

            <div class="mb-4">
                <h6 class="fw-bold mb-3"><i class="fas fa-calendar-check me-2"></i>Notifikasi Booking</h6>
                <div class="form-check form-switch mb-2">
                    <input class="form-check-input" type="checkbox" name="booking_notification" id="bookingNotif" checked>
                    <label class="form-check-label" for="bookingNotif">
                        Notifikasi saat ada booking baru
                    </label>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="bookingStatusNotif" checked>
                    <label class="form-check-label" for="bookingStatusNotif">
                        Notifikasi saat status booking berubah
                    </label>
                </div>
            </div>

            <div class="mb-4">
                <h6 class="fw-bold mb-3"><i class="fas fa-money-bill-wave me-2"></i>Notifikasi Pembayaran</h6>
                <div class="form-check form-switch mb-2">
                    <input class="form-check-input" type="checkbox" name="payment_notification" id="paymentNotif" checked>
                    <label class="form-check-label" for="paymentNotif">
                        Notifikasi saat ada pembayaran baru
                    </label>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="paymentStatusNotif" checked>
                    <label class="form-check-label" for="paymentStatusNotif">
                        Notifikasi saat status pembayaran berubah
                    </label>
                </div>
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Simpan Preferensi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection