<?php

namespace NS\Auth\Controllers;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\{JsonResponse, RedirectResponse, Request, Response};
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\{Config};
use Illuminate\Validation\ValidationException;
use NS\Auth\Models\AuthLog;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')
            ->except('logout');
    }


    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username(): string
    {
        $login = request()->input(Config::get('auth.username', 'username'));

        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'login';
        request()->merge([
            $field => $login,
        ]);

        return $field;
    }

    /**
     * Handle a login request to the application.
     *
     * @param  Request  $request
     * @return JsonResponse|RedirectResponse|Response|\Symfony\Component\HttpFoundation\Response|void
     *
     * @throws ValidationException
     * @noinspection PhpVoidFunctionResultUsedInspection
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            AuthLog::saveEvent(
                AuthLog::EVENT_LOGIN_SUCCESS,
                $request->post($this->username()),
                $request->getClientIp(),
                $request->userAgent()
            );

            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        AuthLog::saveEvent(
            AuthLog::EVENT_LOGIN_FAILED,
            $request->post($this->username()),
            $request->getClientIp(),
            $request->userAgent()
        );

        return $this->sendFailedLoginResponse($request);
    }

    protected function redirectTo()
    {
        return Config::get('auth.after_login_redirect', 'home');
    }

}
