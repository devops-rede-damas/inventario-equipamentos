<?php

use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin TI',
            'email' => 'admin@admin.com',
            'email_verified_at' => now(),
            'password' => password_hash('admin', PASSWORD_BCRYPT),
        ]);
    }
}
