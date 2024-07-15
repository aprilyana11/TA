<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function testLogin()
    {
        // Create and save a new user
        $user = new User;
        $user->username = 'joe';
        $user->fullname = 'joejoe';
        $user->email = 'joe@gmail.com';
        $user->phone_number = '081234567890';
        $user->weight = '22';
        $plainPassword = '123456';
        $user->password = Hash::make($plainPassword); // Hash the password

        // Save the user and check if saved correctly
        if (!($user->save())) {
            dd('user is not being saved to database properly - this is the problem');
        }

        // Retrieve the saved user to check the hashed password
        $savedUser = User::where('email', 'joe@gmail.com')->first();
        if (!$savedUser) {
            dd('user was not found in the database - this is the problem');
        }

        // Debug: Output the saved hashed password and plain password to verify their values
        // Check if the hashed password matches the plain password
        $isPasswordMatch = Hash::check($plainPassword, $savedUser->password);
        if (!$isPasswordMatch) {
            dd('hashing of password is not working correctly - this is the problem');
        } else {
            dd('Hash::check works: ', $isPasswordMatch);
        }

        // Attempt to authenticate the user
        if (!Auth::attempt(['email' => 'joe@gmail.com', 'password' => $plainPassword])) {
            dd('storage of user password is not working correctly - this is the problem');
        } else {
            dd('everything is working when the correct data is supplied - so the problem is related to your forms and the data being passed to the function');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout(); // Logout the user

        $request->session()->invalidate(); // Invalidate the session

        $request->session()->regenerateToken(); // Regenerate the CSRF token

        return redirect('/'); // Redirect to the home page after logout
    }
}
