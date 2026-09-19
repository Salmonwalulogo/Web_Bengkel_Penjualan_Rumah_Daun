@extends('backend.layouts.cashier')

@section('title', 'Pembayaran')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><i class="fas fa-money-bill-wave me-2"></i>Pembayaran</h1>

    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Kode Pembayaran</th>
                            <th>Invoice</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payments as $payment)
                        <tr>
                            <td><code>{{ $payment->payment_code }}</code></td>
                            <td>{{ $payment->transaction->invoice_number ?? '-' }}</td>
                            <td class="fw-bold">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                            <td><span class="badge {{ $payment->status_badge }}">{{ ucfirst($payment->status) }}</span></td>
                            <td>{{ $payment->payment_date?->format('d/m/Y H:i') ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">Belum ada pembayaran.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $payments->links() }}
        </div>
    </div>
</div>
@endsection
