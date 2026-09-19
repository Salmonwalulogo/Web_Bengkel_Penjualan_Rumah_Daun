@extends('backend.layouts.cashier')

@section('title', 'Invoice')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><i class="fas fa-file-invoice me-2"></i>Invoice</h1>

    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Nomor Invoice</th>
                            <th>Customer</th>
                            <th>Total</th>
                            <th>Metode Pembayaran</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $transaction)
                        <tr>
                            <td><strong class="text-primary">{{ $transaction->invoice_number }}</strong></td>
                            <td>{{ $transaction->user->name ?? '-' }}</td>
                            <td class="fw-bold">Rp {{ number_format($transaction->total_payment, 0, ',', '.') }}</td>
                            <td>{{ $transaction->payment_method_label }}</td>
                            <td><span class="badge {{ $transaction->status_badge }}">{{ $transaction->status_label }}</span></td>
                            <td>{{ $transaction->created_at?->format('d/m/Y H:i') ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">Belum ada invoice.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $transactions->links() }}
        </div>
    </div>
</div>
@endsection
