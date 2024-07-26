<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\Session;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return redirect('dashboard');
        } else {
            return view('index2');
        }
    }

    public function actionlogin(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (Auth::Attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('dashboard')
                ->withSuccess('You have successfully logged in!');
        }
        return back()->withErrors([
            'username' => 'Your provided credentials do not match in our records.',
        ])->onlyInput('username');
    }

    public function actionlogout()
    {
        Auth::logout();
        session()->flush();
        return redirect('/');
    }

    // BUAT HP


    public function kodularlogin(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string'
        ]);

        $user = User::where('username', $credentials['username'])->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            // Credentials are correct
            return response()->json(['message' => 'Login Berhasil'], 200);
        }

        // Credentials are incorrect
        return response()->json(['message' => 'Username / Password Gagal'], 401);
    }
    public function kodularUpdateWeight(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'weight' => 'required'
        ]);

        $user = User::where('username', $credentials['username'])->first();
        $user->weight = $request->weight;

        // Credentials are incorrect
        return response()->json(['message' => 'Weight berhasil Diubah'], 200);
    }
}
