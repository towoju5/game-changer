<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UserWallet;

class UserWalletSeeder extends Seeder
{
    public function run()
    {
        UserWallet::create([
            'user_id' => '1',
            'diamonds' => '100000',
            'rubies' => '100000',
            'coins' => '100000',
            'rocks' => '100000',
            'teddy_bears' => '100000',
        ]);

        UserWallet::create([
            'user_id' => '2',
            'diamonds' => '100000',
            'rubies' => '100000',
            'coins' => '100000',
            'rocks' => '100000',
            'teddy_bears' => '100000',
        ]);

        UserWallet::create([
            'user_id' => '3',
            'diamonds' => '100000',
            'rubies' => '100000',
            'coins' => '100000',
            'rocks' => '100000',
            'teddy_bears' => '100000',
        ]);
    }
}
