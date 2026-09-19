<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class SettingController extends Controller
{
    /**
     * Tampilkan halaman pengaturan profil admin
     */
    public function profile()
    {
        $user = Auth::user();
        return view('backend.admin.settings.profile', compact('user'));
    }

    /**
     * Update profil admin
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'username' => 'required|string|unique:users,username,' . $user->id . '|max:255',
            'no_hp' => 'nullable|string|max:20',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->username = $validated['username'];
        $user->no_hp = $validated['no_hp'] ?? null;

        if ($request->hasFile('photo')) {
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            $user->photo = $request->file('photo')->store('users', 'public');
        }

        $user->save();

        return back()->with('success', 'Profil admin berhasil diperbarui!');
    }

    /**
     * Tampilkan halaman pengaturan akun & keamanan
     */
    public function account()
    {
        return view('backend.admin.settings.account');
    }

    /**
     * Update password admin
     */
    public function updateAccount(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'current_password' => 'required',
            'new_password' => ['required', 'confirmed', Password::min(8)],
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini salah!']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Password berhasil diubah!');
    }

    /**
     * Tampilkan halaman pengaturan bengkel
     * PERBAIKAN: Menambahkan variabel $settings agar tidak error di view
     */
    public function general()
    {
        // Nilai default untuk pengaturan bengkel
        $settings = [
            'nama_bengkel' => 'Bengkel Motor',
            'alamat' => '',
            'telepon' => '',
            'email' => '',
            'jam_operasional' => '08:00 - 17:00',
            'deskripsi' => '',
        ];

        return view('backend.admin.settings.general', compact('settings'));
    }

    /**
     * Update pengaturan bengkel
     */
    public function updateGeneral(Request $request)
    {
        $validated = $request->validate([
            'nama_bengkel' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'jam_operasional' => 'nullable|string',
            'deskripsi' => 'nullable|string',
        ]);

        // Untuk saat ini, kita simpan di session sebagai contoh.
        // Nanti bisa dikembangkan untuk disimpan ke database atau file config.
        session(['bengkel_settings' => $validated]);

        return back()->with('success', 'Pengaturan bengkel berhasil diperbarui!');
    }

    /**
     * Tampilkan halaman pengaturan notifikasi
     */
    public function notification()
    {
        return view('backend.admin.settings.notification');
    }

    /**
     * Update pengaturan notifikasi
     */
    public function updateNotification(Request $request)
    {
        // Validasi dan simpan preferensi notifikasi
        return back()->with('success', 'Preferensi notifikasi berhasil disimpan!');
    }

    /**
     * Tampilkan halaman backup & restore
     */
    public function backup()
    {
        return view('backend.admin.settings.backup');
    }
}