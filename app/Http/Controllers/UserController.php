<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('frontend.edit_profil', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'photo' => 'nullable|image|max:2048',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('public/profiles');
            $user->photo_path = str_replace('public/', 'storage/', $path);
        }

        $user->save();

        return redirect()->route('profil')->with('success', 'Profil berhasil diperbaharui!');
    }
}
