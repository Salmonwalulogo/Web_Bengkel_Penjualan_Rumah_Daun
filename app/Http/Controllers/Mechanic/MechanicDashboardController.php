<?php

namespace App\Http\Controllers\Mechanic;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MechanicDashboardController extends Controller
{
    public function index()
    {
        $mechanicId = Auth::id();
        
        $stats = [
            'pending' => Booking::where('mechanic_id', $mechanicId)
                ->where('status', 'confirmed')
                ->count(),
            'in_progress' => Booking::where('mechanic_id', $mechanicId)
                ->where('status', 'in_progress')
                ->count(),
            'completed' => Booking::where('mechanic_id', $mechanicId)
                ->where('status', 'completed')
                ->count(),
            'today' => Booking::where('mechanic_id', $mechanicId)
                ->whereDate('booking_date', today())
                ->count(),
        ];

        $recentBookings = Booking::with(['user', 'vehicle', 'service'])
            ->where('mechanic_id', $mechanicId)
            ->whereIn('status', ['confirmed', 'in_progress'])
            ->latest()
            ->take(5)
            ->get();

        return view('backend.mechanic.dashboard', compact('stats', 'recentBookings'));
    }

    public function bookings()
    {
        $mechanicId = Auth::id();
        
        $bookings = Booking::with(['user', 'vehicle', 'service'])
            ->where('mechanic_id', $mechanicId)
            ->whereIn('status', ['confirmed', 'in_progress'])
            ->latest()
            ->paginate(10);

        return view('backend.mechanic.bookings', compact('bookings'));
    }

    public function jobs()
    {
        $mechanicId = Auth::id();
        
        $jobs = Booking::with(['user', 'vehicle', 'service'])
            ->where('mechanic_id', $mechanicId)
            ->where('status', 'in_progress')
            ->latest()
            ->paginate(10);

        return view('backend.mechanic.jobs', compact('jobs'));
    }

    public function history()
    {
        $mechanicId = Auth::id();
        
        $history = Booking::with(['user', 'vehicle', 'service'])
            ->where('mechanic_id', $mechanicId)
            ->where('status', 'completed')
            ->latest()
            ->paginate(10);

        return view('backend.mechanic.history', compact('history'));
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        if ($booking->mechanic_id !== Auth::id()) {
            return back()->with('error', 'Anda tidak memiliki akses ke booking ini.');
        }

        $allowedTransitions = [
            'confirmed' => ['in_progress'],
            'in_progress' => ['completed'],
            'completed' => [],
        ];

        $validated = $request->validate([
            'status' => 'required|in:confirmed,in_progress,completed',
            'notes' => 'nullable|string',
        ]);

        if (!in_array($validated['status'], $allowedTransitions[$booking->status] ?? [], true)) {
            return back()->with('error', 'Urutan status pekerjaan tidak valid.');
        }

        $booking->update([
            'status' => $validated['status'],
            'notes' => $validated['notes'] ?? $booking->notes,
        ]);

        return back()->with('success', 'Status booking berhasil diperbarui.');
    }
}