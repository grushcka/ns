<?php

namespace Tests\Feature;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;
use NS\User\Models\User;

class VerificationTest extends BaseTest
{
    private const USER_EMAIL_VERIFY = 'user/email/verify';
    private const USER_EMAIL_RESEND = 'user/email/resend';
    private const AUTH_LOGIN = '/auth/login';

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testVerifiPage()
    {
        $this->get(self::USER_EMAIL_VERIFY)
            ->assertRedirect(self::AUTH_LOGIN);
    }


    public function testAfterRegisterVerifiPage()
    {
        $user = factory(User::class)->create([
            'email_verified_at' => null,
        ]);
        $this->actingAs($user)
            ->get(self::USER_EMAIL_VERIFY)
            ->assertStatus(200);
    }

    public function testAfterVerificatedVerifiPage()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user)
            ->get(self::USER_EMAIL_VERIFY)
            ->assertRedirect('user/profile');
    }

    public function testVerifiEmailRequest()
    {
        $user = factory(User::class)->create([
            'email_verified_at' => null,
        ]);
        $this->actingAs($user)
            ->get(self::USER_EMAIL_VERIFY)
            ->assertStatus(200);
    }

    public function testVerifiEmail()
    {
        $user = factory(User::class)->create([
            'email_verified_at' => null,
        ]);
        $url = URL::temporarySignedRoute(
            'user.verification.verify',
            Carbon::now()->addMinutes(Config::get('user::verification.expire', 60)),
            [
                'id' => $user->getKey(),
                'hash' => sha1($user->getEmailForVerification()),
            ]
        );
        $this->assertNull($user->email_verified_at);
        $this->actingAs($user)
            ->get($url)
            ->assertStatus(302);
        $this->assertNotNull($user->email_verified_at);
    }

    public function testVerifiEmailResend()
    {
        $user = factory(User::class)->create([
            'email_verified_at' => null,
        ]);

        $this->actingAs($user)
            ->post(self::USER_EMAIL_RESEND)
            ->assertStatus(302);
    }

    public function testMustVerify()
    {
        $user = factory(User::class)->create([
            'email_verified_at' => null,
        ]);

        $this->actingAs($user)
            ->get('user/profile')
            ->assertRedirect('user/email/verify');
    }

    public function testVerified()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->get('user/profile')
            ->assertStatus(200);
    }
}
