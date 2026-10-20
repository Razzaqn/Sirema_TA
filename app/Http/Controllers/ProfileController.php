<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use App\Models\BuktiPenerimaan;
use App\Models\HasilRekomendasi;
use App\Models\KonfirmasiRekomendasi;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
{
    $user = $request->user();

    $totalRekomendasi = HasilRekomendasi::whereHas('rekomendasi', function ($q) use ($user) {
        $q->where('user_id', $user->id);
    })->count();

    $holdAktif = KonfirmasiRekomendasi::where('user_id', $user->id)
        ->where('status', 'hold_aktif')
        ->count();

    $buktiDiterima = BuktiPenerimaan::where('user_id', $user->id)->count();

    return view('profile.edit', compact(
        'user',
        'totalRekomendasi',
        'holdAktif',
        'buktiDiterima'
    ));
}

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
{
    $user = $request->user();

    $user->fill($request->validated());

    if ($request->hasFile('photo')) {

        if ($user->photo && Storage::disk('public')->exists($user->photo)) {
            Storage::disk('public')->delete($user->photo);
        }

        $user->photo = $request->file('photo')->store('profile', 'public');
    }

    if ($user->isDirty('email')) {
        $user->email_verified_at = null;
    }

    $user->save();

    return Redirect::route('profile.edit')
        ->with('success', 'Profil berhasil diperbarui.');
}

public function deletePhoto(Request $request): RedirectResponse
{
    $user = $request->user();

    if ($user->photo && Storage::disk('public')->exists($user->photo)) {
        Storage::disk('public')->delete($user->photo);
    }

    $user->update([
        'photo' => null,
    ]);

    return back()->with('success', 'Foto profil berhasil dihapus.');
}


public function updatePassword(Request $request): RedirectResponse
{
    $request->validate([
        'current_password' => ['required'],
        'password' => ['required', 'confirmed', 'min:8'],
    ]);

    $user = $request->user();

    if (!Hash::check($request->current_password, $user->password)) {

        return back()->withErrors([
            'current_password' => 'Password lama tidak sesuai.'
        ]);

    }

    $user->update([
        'password' => Hash::make($request->password)
    ]);

    return back()->with('success', 'Password berhasil diperbarui.');
}

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
