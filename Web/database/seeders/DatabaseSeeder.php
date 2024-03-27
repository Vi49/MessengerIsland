<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Http\Services\Utils;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();

        //Default shit
        \App\Models\User::create([
            'user_id' => Utils::generate_user_id("h01oc0st225@gmail.com"),
            'username' => 'test1488',
            'first_name' => "Romka",
            'last_name' => "Rotshield",
            'email' => "h01oc0st225@gmail.com",
            'email_verified_at' => now(),
            'password' => Hash::make("h01oc0st225@gmail.com"),
            'role' => 'user',
            'bio' => "Go back",
            'is_afterreged' => true,
            'last_seen' => now(),
            'avatar' => NULL,
            'remember_token' => Str::random(10),
        ]);


    }
}
