<?php

namespace App\Http\Controllers;

use App\Models\BulkPayout;
use Illuminate\Http\Request;

class BulkPayoutController extends Controller
{
    /**
     * Process a single crypto payout using BitGo Express SDK
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function processPayoutSingle(Request $request)
    {
        $bitgoExpressInstance = new \BitGoExpressSDK(...); // Initialize BitGo Express SDK

        $payoutData = [
            'address' => $request->input('address'),
            'amount' => $request->input('amount'),
            'walletId' => config('services.bitgo.wallet_id'),
            'walletPassphrase' => config('services.bitgo.wallet_passphrase'),
        ];

        try {
            $payoutResult = $bitgoExpressInstance->sendPayment($payoutData);
            return response()->json(['success' => true, 'data' => $payoutResult]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Process bulk crypto payouts using BitGo Express SDK
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function processPayoutBulk(Request $request)
    {
        $bitgoExpressInstance = new \BitGoExpressSDK(...); // Initialize BitGo Express SDK

        $payouts = $request->input('payouts', []);
        $walletId = config('services.bitgo.wallet_id');
        $walletPassphrase = config('services.bitgo.wallet_passphrase');

        $payoutData = array_map(function ($payout) use ($walletId, $walletPassphrase) {
            return [
                'address' => $payout['address'],
                'amount' => $payout['amount'],
                'walletId' => $walletId,
                'walletPassphrase' => $walletPassphrase,
            ];
        }, $payouts);

        try {
            $payoutResults = $bitgoExpressInstance->sendBatchPayment($payoutData);
            return response()->json(['success' => true, 'data' => $payoutResults]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }
}
