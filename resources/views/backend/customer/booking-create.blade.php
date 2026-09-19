@extends('backend.layouts.customer')

@section('title', 'Booking Servis')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Booking Servis</h1>
    <div class="card shadow"><div class="card-body">
        @if($vehicles->isEmpty())
            <div class="alert alert-warning">Tambahkan kendaraan terlebih dahulu sebelum membuat booking.</div>
            <a href="{{ route('customer.vehicles') }}" class="btn btn-success">Tambah Kendaraan</a>
        @else
        <form action="{{ route('customer.booking.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label">Kendaraan</label><select name="vehicle_id" class="form-select" required><option value="">Pilih kendaraan</option>@foreach($vehicles as $vehicle)<option value="{{ $vehicle->id }}">{{ $vehicle->plate_number }} - {{ $vehicle->brand }} {{ $vehicle->model }}</option>@endforeach</select></div>
                <div class="col-md-6"><label class="form-label">Layanan</label><select name="service_id" class="form-select" required><option value="">Pilih layanan</option>@foreach($services as $service)<option value="{{ $service->id }}">{{ $service->name }} - {{ $service->formatted_harga }}</option>@endforeach</select></div>
                <div class="col-md-6"><label class="form-label">Tanggal</label><input type="date" name="booking_date" min="{{ date('Y-m-d') }}" class="form-control" required></div>
                <div class="col-md-6"><label class="form-label">Waktu</label><input type="time" name="booking_time" class="form-control" required></div>
                <div class="col-12"><label class="form-label">Keluhan</label><textarea name="complaint" rows="4" class="form-control" placeholder="Jelaskan keluhan kendaraan jika ada"></textarea></div>
            </div>
            <button class="btn btn-success mt-4"><i class="fas fa-calendar-check me-2"></i>Buat Booking</button>
        </form>
        @endif
    </div></div>
</div>
@endsection
