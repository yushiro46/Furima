<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'name' => '山田太郎',
            'email' => 'yamada.soccer@icloud.com',
            'password' => Hash::make('pas123'),
        ]);

        User::factory()->create([
            'name' => '佐藤二郎',
            'email' => 'sato.food@icloud.com',
            'password' => Hash::make('pas456'),
        ]);

        User::factory()->create([
            'name' => '斉藤裕子',
            'email' => 'saito.min@docomo.com',
            'password' => Hash::make('pas789'),
        ]);

        User::factory()->count(3)->create();
    }
}
