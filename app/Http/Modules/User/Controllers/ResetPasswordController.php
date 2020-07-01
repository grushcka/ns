<?php

namespace NS\User\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\View\View;
use NS\Http\Controllers\Controller;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Display the password reset view for the given token.
     *
     * If no token is present, display the link request form.
     *
     * @param  Request  $request
     * @param  string|null  $token
     * @return Factory|View
     */
    public function showResetForm(Request $request, $token = null)
    {
        return view('user.register.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    public function redirectTo(): string
    {
        session()->flash('password', 'password_reset');
        auth()->logout();

        return 'auth/login';
    }
}
