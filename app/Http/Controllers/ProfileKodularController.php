<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Support\Facades\Auth;



class ProfileKodularController extends Controller
{
    // Metode-metode controller Anda

    public function index(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required'
        ]);

        $user = User::where('username', $credentials['username'])->first();

        return response()->json([
            "username" => $user['username'],
            "weight" => $user['weight'],
            "gender" => $user['gender']
        ]);
    }
    public function kodularUpdateWeight(Request $request)
    {
        $user = User::where('username', $request->input('username'))->first();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        // Update the user's weight
        $user->weight = $request->input('weight');
        // /** @var \App\Models\User $user **/
        $user->save();
        return response()->json(['message' => 'Weight updated successfully.']);
    }

    public function kodularUpdatePassword(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
            'newPassword' => 'required'
        ]);

        $user = User::where('username', $request->input('username'))->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            // Update the user's weight
            $user->password = Hash::make($request->new_password);
            /** @var \App\Models\User $user **/
            $user->save();


            return response()->json(['message' => 'Password updated successfully.']);
        }
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'weight' => 'required|numeric',
        ]);

        $user = auth()->user();
        $user->name = $request->name;
        $user->weight = $request->weight;


        return redirect()->route('profile.show')->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        $user->password = Hash::make($request->new_password);


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
