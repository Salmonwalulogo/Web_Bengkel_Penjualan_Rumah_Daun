@extends('backend.layouts.customer')

@section('title', 'Kendaraan Saya')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Kendaraan Saya</h1>
    </div>

    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

    <div class="row g-4">
        <div class="col-lg-5">
            <div class="card shadow">
                <div class="card-header fw-bold">Tambah Kendaraan</div>
                <div class="card-body">
                    <form action="{{ route('customer.vehicles.store') }}" method="POST">
                        @csrf
                        <div class="mb-3"><label class="form-label">Nomor Plat</label><input name="plate_number" class="form-control" value="{{ old('plate_number') }}" required>@error('plate_number')<small class="text-danger">{{ $message }}</small>@enderror</div>
                        <div class="mb-3"><label class="form-label">Merek</label><input name="brand" class="form-control" value="{{ old('brand') }}" required></div>
                        <div class="mb-3"><label class="form-label">Model</label><input name="model" class="form-control" value="{{ old('model') }}" required></div>
                        <div class="row"><div class="col-6 mb-3"><label class="form-label">Tahun</label><input type="number" name="year" class="form-control" value="{{ old('year') }}"></div><div class="col-6 mb-3"><label class="form-label">Warna</label><input name="color" class="form-control" value="{{ old('color') }}"></div></div>
                        <button class="btn btn-success w-100"><i class="fas fa-plus me-2"></i>Simpan Kendaraan</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="card shadow"><div class="card-body"><div class="table-responsive"><table class="table align-middle"><thead><tr><th>Plat</th><th>Kendaraan</th><th>Tahun</th><th></th></tr></thead><tbody>
                @forelse($vehicles as $vehicle)<tr><td><strong>{{ $vehicle->plate_number }}</strong></td><td>{{ $vehicle->brand }} {{ $vehicle->model }}<br><small class="text-muted">{{ $vehicle->color ?: 'Warna belum diisi' }}</small></td><td>{{ $vehicle->year ?: '-' }}</td><td class="text-end"><form action="{{ route('customer.vehicles.destroy', $vehicle) }}" method="POST" onsubmit="return confirm('Hapus kendaraan ini?');">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button></form></td></tr>
                @empty<tr><td colspan="4" class="text-center text-muted py-4">Belum ada kendaraan.</td></tr>@endforelse
                </tbody></table></div>{{ $vehicles->links() }}</div></div>
        </div>
    </div>
</div>
@endsection
