<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Transaction;
use Carbon\Carbon;

class CashierDashboardController extends Controller
{
    public function index()
    {
        return view('backend.cashier.dashboard', [
            'pendingOrders' => Booking::whereIn('status', ['pending', 'confirmed'])->count(),
            'todayPayments' => Payment::where('status', 'paid')
                ->whereDate('payment_date', Carbon::today())
                ->count(),
            'totalTransactions' => Transaction::count(),
        ]);
    }

    public function orders()
    {
        $bookings = Booking::with(['user', 'vehicle', 'service'])
            ->latest('booking_date')
            ->paginate(10);

        return view('backend.cashier.orders', compact('bookings'));
    }

    public function payments()
    {
        $payments = Payment::with('transaction')
            ->latest('payment_date')
            ->paginate(10);

        return view('backend.cashier.payments', compact('payments'));
    }

    public function invoices()
    {
        $transactions = Transaction::with('user')
            ->latest()
            ->paginate(10);

        return view('backend.cashier.invoices', compact('transactions'));
    }
}