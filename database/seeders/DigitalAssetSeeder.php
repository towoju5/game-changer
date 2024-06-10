<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DigitalAsset;

class DigitalAssetSeeder extends Seeder
{
    public function run()
    {
        DigitalAsset::create([
            'name' => 'Diamonds',
            'image' => 'assets/digital_assets/diamond.jpg',
            'price' => '9.99',
            'quantity' => '10',
            'free_rubies' => '10'
        ]);

        DigitalAsset::create([
            'name' => 'Coins',
            'image' => 'assets/digital_assets/coin.jpg',
            'price' => '14.99',
            'quantity' => '30',
            'free_rubies' => '15'
        ]);

        DigitalAsset::create([
            'name' => 'Rocks',
            'image' => 'assets/digital_assets/rock.jpg',
            'price' => '24.99',
            'quantity' => '100',
            'free_rubies' => '25'
        ]);

        DigitalAsset::create([
            'name' => 'Teddy Bears',
            'image' => 'assets/digital_assets/teddy_bear.png',
            'price' => '49.99',
            'quantity' => '1',
            'free_rubies' => '50'
        ]);
    }
}