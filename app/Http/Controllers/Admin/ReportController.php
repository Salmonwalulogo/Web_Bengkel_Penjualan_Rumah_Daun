<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Booking;
use App\Models\User;
use App\Models\Service;
use App\Models\Product;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->endOfMonth()->format('Y-m-d'));

        // Statistik
        $totalRevenue = Transaction::where('status', 'completed')
                                  ->whereBetween('created_at', [$startDate, $endDate])
                                  ->sum('total_payment');
        
        $totalTransactions = Transaction::whereBetween('created_at', [$startDate, $endDate])->count();
        $totalBookings = Booking::whereBetween('created_at', [$startDate, $endDate])->count();
        $totalCustomers = User::where('role', 'customer')
                             ->whereBetween('created_at', [$startDate, $endDate])
                             ->count();

        // Transaksi dalam periode
        $transactions = Transaction::with('user')
                                  ->whereBetween('created_at', [$startDate, $endDate])
                                  ->latest()
                                  ->paginate(10);

        // Layanan terpopuler
        $topServices = Service::withCount(['bookings' => function ($query) use ($startDate, $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }])->orderBy('bookings_count', 'desc')->take(5)->get();

        // Produk terlaris
        $topProducts = Product::withCount(['transactionDetails' => function ($query) use ($startDate, $endDate) {
            $query->whereHas('transaction', function ($q) use ($startDate, $endDate) {
                $q->whereBetween('created_at', [$startDate, $endDate]);
            });
        }])->orderBy('transaction_details_count', 'desc')->take(5)->get();

        return view('backend.admin.reports.index', compact(
            'totalRevenue', 'totalTransactions', 'totalBookings', 'totalCustomers',
            'transactions', 'topServices', 'topProducts', 'startDate', 'endDate'
        ));
    }
}