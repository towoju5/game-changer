<?php
use Khomeriki\BitgoWallet\Facades\Wallet;

Route::get('t', function () {
    // echo "This is TTT";
    $wallet = Wallet::init(coin: 'tbtc', id: 'your-wallet-id')

        ->generateAddress(label: 'address label');


    return $wallet->address;
});