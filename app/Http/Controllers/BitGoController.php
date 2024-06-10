<?php

namespace App\Http\Controllers;

use App\Models\BitGo;
use Illuminate\Http\Request;
use Khomeriki\BitgoWallet\Data\Requests\TransferData;
use Khomeriki\BitgoWallet\Data\Requests\TransferRecipientData;
use Khomeriki\BitgoWallet\Facades\Wallet;

class BitGoController extends Controller
{
    public function createWallet(Request $request)
    {}

    public function getWallet(Request $request)
    {}

    public function generateAddressOnWallet(Request $request)
    {}

    public function getWalletTransactions(Request $request)
    {}

    public function getTransferById(Request $request)
    {}

    public function sendFromWallet(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'address' =>'required|string',
            'coin' =>'required|string',
        ]);

        $walletId = getWalletId($request->coin, $request->wallet_id);

        $recipientOne = TransferRecipientData::fromArray([
            'amount' => $request->amount, 
            'address' => $request->address,
        ]);

        $transferData = TransferData::fromArray([        
            'walletPassphrase' => 'test',        
            'recipients' => [$recipientOne]        
        ]);
        
        
        $result = Wallet::init($request->coin ?? 'tbtc', $walletId)->sendTransfer($transferData);
        
        
        // return $result;

        // $transferData = [
        //     'amount' => $request->amount,
        //     'address' => $request->address,
        //     'walletPassphrase' => BitGo::whereCoin($request->coin)->first()->wallet_passphrase,
        // ];

        return response()->json($result);
    }
}
