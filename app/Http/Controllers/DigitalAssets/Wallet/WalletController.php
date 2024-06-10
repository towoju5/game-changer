<?php

namespace App\Http\Controllers\DigitalAssets\Wallet;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WalletController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'under-review']);
    }

    public function index()
    {
        $user = \Auth::user()->wallet;
        return view('dashboard.digital-assets.wallet.view', compact('user'));
    }
}