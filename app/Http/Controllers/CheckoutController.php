<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class CheckoutController extends Controller
{
    public function showCheckoutPage(Request $request)
    {
        if($request->has('cmd') && $request->cmd == 'invoice'):
            return $this->generateInvoice();
        // Dummy data for the wallet address and payment details
        $walletAddress = '1A1zP1eP5QGefi2DMPTfTL5SLmv7DivfNa'; // Bitcoin address example
        $amount = 0.01; // Amount in BTC
        $amountUsd = 500; // Equivalent amount in USD

        // Generate QR code for the wallet address
        $qrCode = QrCode::size(250)->generate($walletAddress);

        return view('checkout.pay', compact('walletAddress', 'amount', 'amountUsd', 'qrCode'));
    }

    public function handlePayment(Request $request)
    {
        // Here you would add logic to handle the payment, e.g., verifying the payment on the blockchain
        return redirect()->route('crypto.checkout')->with('success', 'Payment processed successfully!');
    }

}
