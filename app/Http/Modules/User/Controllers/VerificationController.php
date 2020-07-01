<?php

namespace NS\User\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\{RedirectResponse, Request, Response};
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Config;
use Illuminate\View\View;
use NS\Http\Controllers\Controller;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }


    /**
     * Show the email verification notice.
     *
     * @param  Request  $request
     * @return Application|RedirectResponse|Response|Redirector|View
     */
    public function show(Request $request)
    {
        return $request->user()->hasVerifiedEmail()
            ? redirect($this->redirectPath())
            : view('user.register.verify');
    }

    public function redirectTo()
    {
        return Config::get('user.after_register_redirect');
    }
}
