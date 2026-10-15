<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\User;
use App\Support\StrongPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/** Simple "forgot password": the customer enters their email and picks a new password (no email is sent). */
class PasswordResetController extends Controller
{
    public function show()
    {
        return view('auth.forgot');
    }

    public function update(Request $r)
    {
        $r->merge(['email' => strtolower(trim((string) $r->email))]);

        $r->validate([
            'email'    => 'required|email',
            'password' => array_merge(StrongPassword::rules(), ['confirmed']),
        ], [
            'password.confirmed' => 'The two passwords do not match.',
        ]);

        $user = User::where('email', $r->email)->first();

        // Admin accounts can't be reset here: they change their password inside the admin area.
        if (!$user || $user->isAdmin()) {
            return back()->withInput($r->only('email'))
                ->withErrors(['email' => "We couldn't find a customer account with that email."]);
        }

        $user->forceFill([
            'password'       => Hash::make($r->password),
            'remember_token' => Str::random(60),
        ])->save();

        AuditLog::record('account.password_reset', 'Customer password reset from the login page: ' . $user->email);

        return redirect()->route('login')->with('msg', 'Password updated. You can log in now.');
    }
}
