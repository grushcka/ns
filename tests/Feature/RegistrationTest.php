<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Config;

class RegistrationTest extends BaseTest
{

    private const USER_REGISTER_URL = '/user/register';

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testRegPageOpen()
    {
        $this->get(self::USER_REGISTER_URL)->assertStatus(200);
    }


    /**
     * @return void
     */
    public function testRegisterPostRequestSave(): void
    {
        $password = $this->faker->password(8);
        $email = $this->faker->email;
        $data = [
            'login' => $this->faker->firstName,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $password,
        ];

        $this->post(self::USER_REGISTER_URL, $data);

        $this->assertDatabaseHas('users', [
            'email' => $email,
        ]);
    }

    /**
     * @return void
     */
    public function testRegisterPostRequestRedirect(): void
    {
        $password = $this->faker->password(8);
        $email = $this->faker->email;
        $data = [
            'login' => $this->faker->firstName,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $password,
        ];

        $this->post(self::USER_REGISTER_URL, $data)
            ->assertRedirect(Config::get('user.after_register_redirect'));
    }
}
