@extends('layouts.master')
@section('title')
    @lang("Invoice #$invoice->id")
@endsection

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('assets/libs/swiper/swiper.min.css') }}">
@endsection

@section('content')
<div class="container mt-5">
    <h2>Invoice #{{ $invoice->id }}</h2>
    <p><strong>Customer Name:</strong> {{ $invoice->customer_name }}</p>
    <p><strong>Customer Email:</strong> {{ $invoice->customer_email }}</p>
    <table class="table">
        <thead>
            <tr>
                <th>Description</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice->items as $item)
                <tr>
                    <td>{{ $item->description }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>${{ number_format($item->price, 2) }}</td>
                    <td>${{ number_format($item->quantity * $item->price, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" class="text-end">Total</th>
                <th>${{ number_format($invoice->total, 2) }}</th>
            </tr>
        </tfoot>
    </table>
    <div class="d-flex">
        <a href="#" class="btn btn-secondary me-2">Share Invoice</a>
        <a href="#" class="btn btn-primary">Pay</a>
    </div>
</div>
@endsection