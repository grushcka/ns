<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Password;
use NS\User\Models\User;

class PasswordForgotTest extends BaseTest
{

    private const PASSWORD_RESET = 'password/reset';
    private const PASSWORD_EMAIL = 'password/email';

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testMainPageGuest()
    {
        $this->get(self::PASSWORD_RESET)
            ->assertStatus(200);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testMainPageAuth()
    {
        $this->actingAs(factory(User::class)->create())
            ->get(self::PASSWORD_RESET)
            ->assertStatus(200);
    }


    public function testPasswordResetPost()
    {
        $email = $this->faker->email;
        $user = factory(User::class)->create(
            ['email' => $email]
        );
        $this->actingAs($user)
            ->post(self::PASSWORD_EMAIL, [
                'email' => $email,
            ]);

        $this->assertDatabaseHas('password_resets', [
            'email' => $email,
        ]);
    }


    public function testPasswordReset()
    {
        $email = $this->faker->email;
        $user = factory(User::class)->create(
            ['email' => $email]
        );
        $this->actingAs($user)
            ->post(self::PASSWORD_EMAIL, [
                'email' => $email,
            ]);

        $this->assertDatabaseHas('password_resets', [
            'email' => $email,
        ]);
        $token = Password::broker()->createToken($user);
        $password = $this->faker->password(10);
        $this->actingAs($user)
            ->get(self::PASSWORD_RESET.'/'.$token)
            ->assertStatus(200);
        $this->actingAs($user)
            ->post(self::PASSWORD_RESET, [
                'email' => $email,
                'token' => $token,
                'password' => $password,
                'password_confirmation' => $password,
            ])->assertRedirect('/auth/login');

        $this->assertDatabaseMissing('password_resets', [
            'email' => $email,
        ]);
    }

    public function testPasswordResetFail()
    {
        $email = $this->faker->email;
        $user = factory(User::class)->create(
            ['email' => $email]
        );
        $this->actingAs($user)
            ->post(self::PASSWORD_EMAIL, [
                'email' => $email,
            ]);

        $this->assertDatabaseHas('password_resets', [
            'email' => $email,
        ]);
        $token = 'WRONG';
        $password = $this->faker->password(10);
        //back with error
        $this->actingAs($user)
            ->post(self::PASSWORD_RESET, [
                'email' => $email,
                'token' => $token,
                'password' => $password,
                'password_confirmation' => $password,
            ])->assertSessionHasErrors('email');

        $this->assertDatabaseHas('password_resets', [
            'email' => $email,
        ]);
    }
}
