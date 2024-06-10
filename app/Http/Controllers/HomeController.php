<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'under-review']);
    }

    public function root()
    {
        return view('dashboard.dashboard');
    }

    public function balance()
    {
        $transactions = Transaction::where('trx_type','Deposit')->where('user_id', Auth::user()->id)->orderBy('id','desc')->get();
        return view('dashboard.balance',compact('transactions'));
    }

    public function lang($locale)
    {
        if ($locale) {
            App::setLocale($locale);
            Session::put('lang', $locale);
            Session::save();
            return redirect()->back()->with('locale', $locale);
        } else {
            return redirect()->back();
        }
    }
}