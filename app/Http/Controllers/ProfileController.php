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

    public function uploadProfilePicture(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('profile_picture')) {
            $image = $request->file('profile_picture');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/profile_pictures', $imageName); // simpan gambar di storage/app/public/profile_pictures

            // Simpan nama gambar ke dalam tabel user
            $user = auth()->user();
            $user->profile_picture = 'profile_pictures/' . $imageName; // path relatif ke direktori storage/app/public

        }

        return back()->with('success', 'Profile picture has been uploaded.');
    }
}
