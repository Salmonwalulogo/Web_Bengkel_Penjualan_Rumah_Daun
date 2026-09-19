<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(Request $request): View
    {
        $cart = $request->session()->get('cart', []);
        $products = Product::with('category')->whereIn('id', array_keys($cart))->get()->keyBy('id');
        $items = collect($cart)->map(function ($quantity, $productId) use ($products) {
            $product = $products->get($productId);
            return $product ? [
                'product' => $product,
                'quantity' => $quantity,
                'subtotal' => $product->harga * $quantity,
            ] : null;
        })->filter()->values();

        return view('backend.cart.index', [
            'items' => $items,
            'total' => $items->sum('subtotal'),
        ]);
    }

    public function add(Request $request, Product $product): RedirectResponse
    {
        abort_unless($product->status === 'active' && $product->is_active, 404);

        $quantity = max(1, (int) $request->input('quantity', 1));
        $cart = $request->session()->get('cart', []);
        $currentQuantity = (int) ($cart[$product->id] ?? 0);

        if ($currentQuantity + $quantity > $product->stok) {
            return back()->with('error', "Stok {$product->name} tidak mencukupi.");
        }

        $cart[$product->id] = $currentQuantity + $quantity;
        $request->session()->put('cart', $cart);

        return back()->with('success', "{$product->name} ditambahkan ke keranjang.");
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $quantity = (int) $request->input('quantity');
        $cart = $request->session()->get('cart', []);

        if ($quantity <= 0) {
            unset($cart[$product->id]);
        } elseif ($quantity <= $product->stok) {
            $cart[$product->id] = $quantity;
        } else {
            return back()->with('error', "Jumlah {$product->name} melebihi stok tersedia.");
        }

        $request->session()->put('cart', $cart);
        return back()->with('success', 'Keranjang diperbarui.');
    }

    public function remove(Request $request, Product $product): RedirectResponse
    {
        $cart = $request->session()->get('cart', []);
        unset($cart[$product->id]);
        $request->session()->put('cart', $cart);
        return back()->with('success', 'Produk dihapus dari keranjang.');
    }

    public function checkout(Request $request): RedirectResponse
    {
        abort_unless(Auth::check() && Auth::user()->role === 'customer', 403);

        $cart = $request->session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang masih kosong.');
        }

            $validated = $request->validate([
                'payment_method' => 'required|in:cash,qris,ewallet,transfer',
            ]);

        try {
            $transaction = DB::transaction(function () use ($cart, $validated) {
                $total = 0;
                $details = [];

                foreach ($cart as $productId => $quantity) {
                    $product = Product::whereKey($productId)->lockForUpdate()->firstOrFail();
                    if ($product->status !== 'active' || !$product->is_active || $product->stok < $quantity) {
                        throw new \RuntimeException("Stok {$product->name} tidak mencukupi.");
                    }

                    $subtotal = $product->harga * $quantity;
                    $total += $subtotal;
                    $details[] = compact('product', 'quantity', 'subtotal');
                    $product->decrement('stok', $quantity);
                }

                $transaction = Transaction::create([
                    'user_id' => Auth::id(),
                    'total_payment' => $total,
                    'payment_method' => $validated['payment_method'],
                    'status' => 'pending',
                ]);

                foreach ($details as $detail) {
                    TransactionDetail::create([
                        'transaction_id' => $transaction->id,
                        'product_id' => $detail['product']->id,
                        'quantity' => $detail['quantity'],
                        'price' => $detail['product']->harga,
                        'subtotal' => $detail['subtotal'],
                    ]);
                }

                Payment::create([
                    'transaction_id' => $transaction->id,
                    'payment_code' => 'PAY-' . date('Ymd') . '-' . strtoupper(Str::random(6)),
                    'amount' => $total,
                    'status' => 'pending',
                ]);

                return $transaction;
            });
        } catch (\RuntimeException $exception) {
            return redirect()->route('cart.index')->with('error', $exception->getMessage());
        }

        $request->session()->forget('cart');
        return redirect()->route('customer.transactions')->with('success', "Pesanan {$transaction->invoice_number} diterima dan menunggu diproses admin.");
    }
}
