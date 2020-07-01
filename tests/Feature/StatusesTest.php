<?php

namespace Tests\Feature;

use NS\User\Models\User;
use Tests\TestCase;

class StatusesTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testSuspend()
    {
        $user = factory(User::class)->create(
            ['status' => User::STATUS_SUSPEND]
        );
        $this->actingAs($user)
            ->get('user/profile')
            ->assertRedirect('auth/login')
            ->assertSessionHas('message', __('user.suspend'));
    }

    public function testBanned()
    {
        $user = factory(User::class)->create(
            ['status' => User::STATUS_BANNED]
        );
        $this->actingAs($user)
            ->get('user/profile')
            ->assertRedirect('auth/login')
            ->assertSessionHas('message', __('user.banned'));
    }
}
