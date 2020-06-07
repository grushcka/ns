<?php

namespace NS\User\Controllers;

/**
 * @TODO add tests
 */

use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use NS\Http\Traits\ViewHelper;
use Illuminate\Routing\Controller;
use NS\User\Models\User;
use NS\User\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{
    use ViewHelper;

    /**
     * @var string $viewPrefix
     */
    private string $viewPrefix = 'user::profile';

    /**
     * Display a profile.
     * @param  User  $user
     * @return Application|Factory|View
     */
    public function index(User $user = null)
    {
        return $this->view('index', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  User  $user
     * @return Application|Factory|View
     */
    public function edit(User $user)
    {
        return $this->view('edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ProfileUpdateRequest  $request
     * @param  User  $user
     * @return RedirectResponse
     */
    public function update(ProfileUpdateRequest $request, User $user): RedirectResponse
    {
        Gate::authorize('change-profile', $user);
        $user->update($request->validated());
        session()->flash('status', trans('Profile Updated'));

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User  $user
     * @return void
     * @throws Exception
     */
    public function delete(User $user): void
    {
        Gate::authorize('change-profile', $user);
        $user->delete();
    }
}
