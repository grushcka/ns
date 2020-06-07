<?php

use Illuminate\Database\Seeder;
use NS\User\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        factory(User::class, 20)->create()->each(static function ($user) {
            echo "{$user->email}\n";
        });
    }
}
