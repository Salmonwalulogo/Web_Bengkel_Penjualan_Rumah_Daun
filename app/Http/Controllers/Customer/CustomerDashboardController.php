<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Notification;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CustomerDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('backend.customer.dashboard', [
            'transactionCount' => $user->transactions()->count(),
            'vehicleCount' => $user->vehicles()->count(),
            'activeBookingCount' => $user->bookings()->whereIn('status', ['pending', 'confirmed', 'in_progress'])->count(),
        ]);
    }

    public function vehicles()
    {
        $vehicles = Auth::user()->vehicles()->latest()->paginate(10);
        return view('backend.customer.vehicles', compact('vehicles'));
    }

    public function storeVehicle(Request $request)
    {
        $validated = $request->validate([
            'plate_number' => 'required|string|max:20',
            'brand' => 'required|string|max:100',
            'model' => 'required|string|max:100',
            'year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'color' => 'nullable|string|max:50',
        ]);

        Auth::user()->vehicles()->create($validated);
        return back()->with('success', 'Kendaraan berhasil ditambahkan.');
    }

    public function destroyVehicle($vehicle)
    {
        Auth::user()->vehicles()->findOrFail($vehicle)->delete();
        return back()->with('success', 'Kendaraan berhasil dihapus.');
    }

    public function createBooking()
    {
        $vehicles = Auth::user()->vehicles()->orderBy('plate_number')->get();
        $services = Service::where('status', 'active')->orderBy('name')->get();
        return view('backend.customer.booking-create', compact('vehicles', 'services'));
    }

    public function storeBooking(Request $request)
    {
        $validated = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'service_id' => [
                'required',
                Rule::exists('services', 'id')->where(fn ($query) => $query->where('status', 'active')),
            ],
            'booking_date' => 'required|date|after_or_equal:today',
            'booking_time' => 'required|date_format:H:i',
            'complaint' => 'nullable|string|max:2000',
        ]);

        $vehicleOwned = Auth::user()->vehicles()->whereKey($validated['vehicle_id'])->exists();
        abort_unless($vehicleOwned, 403);

        Auth::user()->bookings()->create($validated);
        return redirect()->route('customer.bookings')->with('success', 'Booking servis berhasil dibuat.');
    }

    public function bookings()
    {
        $bookings = Auth::user()->bookings()->with(['vehicle', 'service'])->latest('booking_date')->paginate(10);
        return view('backend.customer.bookings', compact('bookings'));
    }

    public function transactions()
    {
        $transactions = Auth::user()->transactions()->with('payment')->latest()->paginate(10);
        return view('backend.customer.transactions', compact('transactions'));
    }

    public function notifications()
    {
        $notifications = Auth::user()->notifications()->latest()->paginate(15);
        return view('backend.customer.notifications', compact('notifications'));
    }

    public function markNotificationAsRead($notification)
    {
        Auth::user()->notifications()->whereKey($notification)->update(['is_read' => true]);
        return back()->with('success', 'Notifikasi ditandai sudah dibaca.');
    }
}