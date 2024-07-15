<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;
use App\Models\User;

class RegistrasiController extends Controller
{
    public function index()
    {
        return view('registrasi');
    }

    public function register(Request $request)
    {


        try {
            User::create([
                'fullname' => $request->fullname,
                'username' => $request->username,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'password' => Hash::make($request->password),
                'gender' => $request->gender,
                'weight' => $request->weight,
            ]);
        } catch (QueryException $e) {
            if ($e->errorInfo[1] === 1062) {
                if ($request->ajax()) {
                    return response()->json(['error' => 'Email sudah terdaftar.'], 409);
                } else {
                    return redirect()->back()->withInput()->withErrors(['email' => 'Email sudah terdaftar.']);
                }
            }
            return redirect()->back()->withInput()->withErrors(['error' => 'Gagal mendaftar. Silakan coba lagi.']);
        }

        return $request->ajax()
            ? response()->json(['success' => 'Registrasi berhasil!'], 200)
            : redirect('/login')->with('success', 'Registrasi berhasil! Silakan masuk.');
    }
}
