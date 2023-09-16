<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory(10)->create();

        $team = Team::create([
           'name' => 'Dynamo Media'
        ]);

        User::create([
            'name' => 'Liam Seys',
            'email' => 'liam.seys@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'remember_token' => Str::random(10),
            'is_admin' => true,
            'payment_method' => 'paypal',
            'paypal_email' => 'test@test.com',
            'team_id' => $team->id
        ]);
    }
}
