<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('user')
                                  ->latest()
                                  ->paginate(10);
        return view('backend.admin.transactions.index', compact('transactions'));
    }

    public function create()
    {
        $customers = User::where('role', 'customer')->get();
        $products = Product::where('status', 'active')->where('stok', '>', 0)->get();
        return view('backend.admin.transactions.create', compact('customers', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
                'payment_method' => 'required|in:cash,qris,ewallet,transfer',
            'status' => 'required|in:pending,completed,cancelled',
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();

        try {
            $totalPayment = 0;
            $details = [];

            foreach ($validated['products'] as $item) {
                $product = Product::findOrFail($item['product_id']);
                
                if ($product->stok < $item['quantity']) {
                    throw new \Exception("Stok {$product->name} tidak mencukupi");
                }

                $subtotal = $product->harga * $item['quantity'];
                $totalPayment += $subtotal;

                $details[] = [
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $product->harga,
                    'subtotal' => $subtotal,
                ];

                // Kurangi stok
                $product->decrement('stok', $item['quantity']);
            }

            // Buat transaksi
            $transaction = Transaction::create([
                'user_id' => $validated['user_id'],
                'total_payment' => $totalPayment,
                'payment_method' => $validated['payment_method'],
                'status' => $validated['status'],
            ]);

            // Simpan detail transaksi
            foreach ($details as $detail) {
                $detail['transaction_id'] = $transaction->id;
                TransactionDetail::create($detail);
            }

            DB::commit();

            return redirect()->route('admin.transactions.index')
                ->with('success', 'Transaksi berhasil dibuat. Invoice: ' . $transaction->invoice_number);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function show(Transaction $transaction)
    {
        $transaction->load(['user', 'details.product']);
        return view('backend.admin.transactions.show', compact('transaction'));
    }

    public function updateStatus(Request $request, Transaction $transaction)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,completed,cancelled',
        ]);

        $transaction->update(['status' => $validated['status']]);

        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();

        return redirect()->route('admin.transactions.index')
            ->with('success', 'Transaksi berhasil dihapus.');
    }
}