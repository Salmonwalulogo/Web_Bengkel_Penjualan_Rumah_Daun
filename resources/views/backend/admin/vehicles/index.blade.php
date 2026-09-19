@extends('backend.layouts.admin')

@section('title', 'Kendaraan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0"><i class="fas fa-motorcycle me-2"></i>Kendaraan</h2>
    <a href="{{ route('admin.vehicles.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Tambah Kendaraan
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Pemilik</th>
                        <th>Plat Nomor</th>
                        <th>Merek</th>
                        <th>Model</th>
                        <th>Tahun</th>
                        <th>Warna</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($vehicles as $vehicle)
                    <tr>
                        <td><strong>#{{ $vehicle->id }}</strong></td>
                        <td>{{ $vehicle->user->name ?? '-' }}</td>
                        <td><span class="badge bg-dark">{{ $vehicle->plate_number }}</span></td>
                        <td>{{ $vehicle->brand }}</td>
                        <td>{{ $vehicle->model }}</td>
                        <td>{{ $vehicle->year ?? '-' }}</td>
                        <td>{{ $vehicle->color ?? '-' }}</td>
                        <td class="text-center">
                            <a href="{{ route('admin.vehicles.edit', $vehicle) }}" class="btn-action btn-edit" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.vehicles.destroy', $vehicle) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus kendaraan ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action btn-delete" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            <i class="fas fa-motorcycle fa-3x mb-3 d-block"></i>
                            Belum ada data kendaraan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($vehicles->hasPages())
        <div class="mt-3">{{ $vehicles->links() }}</div>
        @endif
    </div>
</div>
@endsection