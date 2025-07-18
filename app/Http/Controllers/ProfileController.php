<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // $request->user()->fill($request->validated());

        // if ($request->user()->isDirty('email')) {
        //     $request->user()->email_verified_at = null;
        // }

        // $request->user()->save();

        // return Redirect::route('profile.edit')->with('status', 'profile-updated');

        $user = $request->user();

        //Validasi & isi data name, email dari ProfileUpdateRequest
        $user->fill($request->validated());

        // Handle upload foto profil
        if ($request->hasFile('photo')) {
            if ($user->photo_path && file_exists(public_path($user->photo_path))){
                unlink(public_path($user->photo_path));
            }
            $file = $request->file('photo');

            // Simpan di folder storage/app/public/profile_photos
            $path = $file->store('profile_photos', 'public');

            // Simpan path akses file ke kolom photo_path
            $user->photo_path = 'storage/' . $path;
        }

        // Reset verifikasi email jika email berubah
        if ($user->isDirty('email')){
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profil')->with('status', 'profile-updated');
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
