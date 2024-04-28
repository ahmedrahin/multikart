<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use App\Rules\DifferentPassword;
use Auth;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => [
                'required',
                'confirmed',
                'min:6',
                Rule::notIn([$request->current_password])
            ],
        ],[
           'password.required'  => 'The new password field is required.',
           'password.not_in'     => 'Ensure new password is not the same as the current password' 
        ]);

        $user = auth()->user();
        if (!Hash::check($request->current_password, $user->password)) {
            session()->flash('alert-type', 'error');
            session()->flash('message', 'Your Current Password is Incorrect');
            return back()->withErrors(['current_password' => 'The password is incorrect']);
        }
        if ($request->password === $request->current_password) {
            session()->flash('alert-type', 'error');
            session()->flash('message', 'Ensure new password is not the same as the current password');
            return back()->withErrors(['password' => 'Ensure new password is not the same as the current password']);
        }
        // Update the password
        $user->update([
            'password' => Hash::make($request->password),
        ]);
        Auth::logout();
        
    }

}
