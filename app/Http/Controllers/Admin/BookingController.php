<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Service;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['user', 'vehicle', 'service'])
                          ->latest()
                          ->paginate(10);
        return view('backend.admin.bookings.index', compact('bookings'));
    }

    public function create()
    {
        $customers = User::where('role', 'customer')->get();
        $services = Service::where('status', 'active')->get();
        $vehicles = Vehicle::all();
        return view('backend.admin.bookings.create', compact('customers', 'services', 'vehicles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'vehicle_id' => 'required|exists:vehicles,id',
            'service_id' => 'required|exists:services,id',
            'booking_date' => 'required|date',
            'booking_time' => 'required',
            'complaint' => 'nullable|string',
            'notes' => 'nullable|string',
            'status' => 'required|in:pending,confirmed,in_progress,completed,cancelled',
        ]);

        Booking::create($validated);

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking berhasil ditambahkan.');
    }

    public function show(Booking $booking)
    {
        $booking->load(['user', 'vehicle', 'service']);
        return view('backend.admin.bookings.show', compact('booking'));
    }

    public function edit(Booking $booking)
    {
        $customers = User::where('role', 'customer')->get();
        $services = Service::where('status', 'active')
            ->orWhere('id', $booking->service_id)
            ->get();
        $vehicles = Vehicle::all();
        return view('backend.admin.bookings.edit', compact('booking', 'customers', 'services', 'vehicles'));
    }

    public function update(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'user_id' => [
                'required',
                Rule::exists('users', 'id')->where(fn ($query) => $query->where('role', 'customer')),
            ],
            'vehicle_id' => [
                'required',
                Rule::exists('vehicles', 'id')->where(fn ($query) => $query->where('user_id', $request->input('user_id'))),
            ],
            'service_id' => 'required|exists:services,id',
            'booking_date' => 'required|date',
            'booking_time' => 'required|date_format:H:i',
            'complaint' => 'nullable|string|max:2000',
            'notes' => 'nullable|string|max:2000',
            'status' => 'required|in:pending,confirmed,in_progress,completed,cancelled',
        ]);

        $booking->update($validated);

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking berhasil diperbarui.');
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking berhasil dihapus.');
    }
}