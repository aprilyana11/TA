<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Support\Facades\Auth;



class ProfileController extends Controller
{
    // Metode-metode controller Anda

    public function show()
    {
        $user = Auth::user();
        $user = auth()->user();
        $username = $user->username;
        $weight = $user->weight;
        return view('profile', [
            'username' => $username,
            'weight' => $weight
        ]);
    }



    public function updateProfile(Request $request)
    {
        $request->validate([
            'weight' => 'required',
        ]);

        $user = auth()->user();
        $user->weight = $request->weight;
        // Save the user with the updated weight
        $user->save();
        return redirect()->route('profile.show')->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        $user->password = Hash::make($request->new_password);
        /** @var \App\Models\User $user **/
        $user->save();


        return redirect()->route('profile.show')->with('success', 'Password updated successfully.');
    }
}
