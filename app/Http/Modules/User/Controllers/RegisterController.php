<?php

namespace NS\User\Controllers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\{Config, Hash};
use NS\Http\Controllers\Controller;
use NS\User\Models\User;
use NS\User\Requests\RegisterRequest;

class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * @var User
     */
    private User $user;

    /**
     * Create a new controller instance.
     *
     * @param  User  $user
     */
    public function __construct(User $user)
    {
        $this->middleware('guest');
        $this->user = $user;
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  RegisterRequest  $request
     * @return RedirectResponse
     */
    public function register(RegisterRequest $request): RedirectResponse
    {
        $user = $this->create($request->validated());

        event(new Registered($user));

        auth()->login($user);

        session()->flash('register', 'success');

        return redirect($this->redirectPath());
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data): User
    {
        return $this->user::create([
            'login' => $data['login'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function redirectTo()
    {
        return Config::get('user.after_register_redirect');
    }
}
