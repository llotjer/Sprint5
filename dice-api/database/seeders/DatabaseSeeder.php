<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {

        User::create(
        [
            'role' => 'admin',
            'name' => 'Xavi',
            'email' => 'xrb@xrb.cat',
            'email_verified_at' => now(),
            'password' => '12345678',
            'remember_token' => Str::random(10),
        ]);

        User::factory(9)->create();
        
    }
}
