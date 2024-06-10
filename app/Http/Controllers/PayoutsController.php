<?php

namespace App\Http\Controllers;

use App\Models\Payouts;
use Illuminate\Http\Request;
use Khomeriki\BitgoWallet\Data\Requests\TransferData;
use Khomeriki\BitgoWallet\Data\Requests\TransferRecipientData;
use Khomeriki\BitgoWallet\Facades\Wallet;



class PayoutsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return 
     */
    public function index()
    {
        try {
            $payouts = Payouts::whereUserId(auth()->user()->id)->paginate(per_page: 10);
            return view('payouts.users.index', compact('payouts'));
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function singlePayout(Request $request)
    {
        try {
            $request->validate([
                'coin' => 'required|string',
                'wallet_id' => 'required|string',
                'amount' => 'required|numeric',
                'address' => 'required|string',
                'memo' => 'required|string',
                'metadata' => 'required|string',
            ]);

            if (Payouts::create($request->all())) {
                $recipient = TransferRecipientData::fromArray([
                    'amount' => $request->amount,
                    'address' => $request->walletAddress
                ]);

                dd($recipient);
                exit;
                return back()->with('success', 'Payout initiated successfully');
            }
        } catch (\Throwable $th) {
            return get_error_response(['error' => $th->getMessage()]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payouts  $payouts
     * @return \Illuminate\Http\Response
     */
    public function show(Payouts $payouts)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Payouts  $payouts
     * @return \Illuminate\Http\Response
     */
    public function edit(Payouts $payouts)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payouts  $payouts
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payouts $payouts)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payouts  $payouts
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payouts $payouts)
    {
        //
    }
}
