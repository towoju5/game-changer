@extends('layouts.master')

@section('title', 'Crypto Checkout')

@section('css')
    <style>
        .checkout-card {
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .checkout-header {
            border-bottom: none;
        }
        .checkout-header h4 {
            margin-bottom: 0;
        }
        .wallet-address {
            font-family: 'Courier New', Courier, monospace;
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
        }
        .qr-code {
            margin-top: 20px;
        }
        .qr-code img {
            width: 100%;
            height: auto;
        }
    </style>
@endsection

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card checkout-card">
                <div class="card-header text-center bg-primary text-white checkout-header">
                    <h4>Crypto Checkout</h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="text-center mb-4">
                        <h5>Scan the QR code or use the wallet address below to make a payment</h5>
                        <div class="qr-code">{!! $qrCode !!}</div>
                        <p class="mt-3 wallet-address">{{ $walletAddress }}</p>
                        <p><strong>Amount:</strong> {{ $amount }} BTC ({{ $amountUsd }} USD)</p>
                    </div>
                    <form action="{{ route('crypto.checkout.process') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="transaction_id" class="form-label">Transaction ID</label>
                            <input type="text" class="form-control" id="transaction_id" name="transaction_id" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Confirm Payment</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
