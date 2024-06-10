@extends('layouts.master')
@section('title') @lang('translation.market-place') @endsection

@section('content')

<!-- Breadcrumb Trail -->
@component('components.breadcrumb')
@slot('li_1')
    @lang('translation.market-place')
@endslot
@slot('title')
    @lang('translation.digital-assets')
@endslot
@endcomponent

<!-- Session Messages -->
@include('partials.session')

    <!-- Checkout Form -->
    <div class="row">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-body checkout-tab">
                    <!-- Payment Form -->
                    <form action="{{ url('/market-place/'.encrypt($asset->id).'/confirm/checkout') }}" method="POST">
                        @csrf
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="pills-payment" role="tabpanel" aria-labelledby="pills-payment-tab">
                                <!-- Payment Text -->
                                <div>
                                    <h5 class="mb-1">Payment Selection</h5>
                                    <p class="text-muted mb-4">Please select and enter your billing information</p>
                                </div>

                                <!-- Payment Options -->
                                <div class="row g-4">
                                    <!-- Credit/Debit Card -->
                                    <div class="col-lg-4 col-sm-6">
                                        <div data-bs-toggle="collapse" data-bs-target="#paymentmethodCollapse"
                                            aria-expanded="true" aria-controls="paymentmethodCollapse">
                                            <div class="form-check card-radio">
                                                <input id="paymentMethod02" name="paymentMethod" type="radio" class="form-check-input" checked>
                                                <label class="form-check-label" for="paymentMethod02">
                                                    <span class="fs-16 text-muted me-2">
                                                        <i class="ri-bank-card-fill align-bottom"></i>
                                                    </span>
                                                    <span class="fs-14 text-wrap">Credit Card</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Crypto -->
                                    <div class="col-lg-4 col-sm-6">
                                        <div data-bs-toggle="collapse" data-bs-target="#paymentmethodCollapse.show" aria-expanded="false" aria-controls="paymentmethodCollapse">
                                            <div class="form-check card-radio">
                                                <input id="paymentMethod01" name="paymentMethod" type="radio" class="form-check-input">
                                                <label class="form-check-label" for="paymentMethod01">
                                                    <span class="fs-16 text-muted me-2">
                                                        <i class="ri-coins-fill align-bottom"></i>
                                                    </span>
                                                    <span class="fs-14 text-wrap">Crypto</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Card Details -->
                                <div class="collapse show" id="paymentmethodCollapse">
                                    <div class="card p-4 border shadow-none mb-0 mt-4">
                                        <div class="row gy-3">
                                            <div class="col-md-12">
                                                <label for="cc-name" class="form-label">Card Holder</label>
                                                <input type="text" class="form-control" name="cc-name" placeholder="John Doe">
                                            </div>

                                            <div class="col-md-6">
                                                <label for="cc-number" class="form-label">Card Number</label>
                                                <input type="text" class="form-control" name="cc-number" placeholder="xxxx xxxx xxxx xxxx">
                                            </div>

                                            <div class="col-md-3">
                                                <label for="cc-expiration" class="form-label">Expiry</label>
                                                <input type="text" class="form-control" name="cc-expiration" placeholder="MM/YY">
                                            </div>

                                            <div class="col-md-3">
                                                <label for="cc-cvv" class="form-label">CVC</label>
                                                <input type="text" class="form-control" name="cc-cvc" placeholder="xxx">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-muted mt-2 fst-italic">
                                        <i data-feather="lock" class="text-muted icon-xs"></i> Your
                                        transaction is secured with SSL encryption
                                    </div>
                                </div>

                                <!-- Pay Now Button -->
                                <div class="d-flex align-items-start gap-3 mt-4">
                                    <a href="{{ url('/market-place/assets') }}" class="btn btn-light btn-label">
                                        <i class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>
                                        Back to Marketplace
                                    </a>
                                    <button type="submit" class="btn btn-primary btn-label right ms-auto">
                                        <i class="ri-shopping-basket-line label-icon align-middle fs-16 ms-2"></i>    
                                        Pay Now
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="col-xl-4">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <h5 class="card-title mb-0">Order Summary</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive table-card">
                        <table class="table table-borderless align-middle mb-0">
                            <thead class="table-light text-muted">
                                <tr>
                                    <th style="width: 90px;" scope="col">Product</th>
                                    <th scope="col">Information</th>
                                    <th scope="col" class="text-end">Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Asset Details -->
                                <tr>
                                    <td>
                                        <div class="avatar-md rounded p-1">
                                            <img src="{{ asset($asset->image) }}" alt="{{ $asset->name }}" class="img-fluid d-block">
                                        </div>
                                    </td>
                                    <td>
                                        <h5 class="fs-14">
                                            <a href="#" class="text-dark">{{ $asset->name }}</a>
                                        </h5>
                                        <p class="text-muted mb-0">{{ $asset->quantity }} Pieces</p>
                                    </td>
                                    <td class="text-end">${{ $asset->price }}</td>
                                </tr>
                                <!-- Ruby Details -->
                                <tr>
                                    <td>
                                        <div class="avatar-md rounded p-1">
                                            <img src="{{ asset('/assets/digital_assets/ruby.jpg') }}" alt="Ruby" class="img-fluid d-block">
                                        </div>
                                    </td>
                                    <td>
                                        <h5 class="fs-14">
                                            <a href="#" class="text-dark">Rubies</a>
                                        </h5>
                                        <p class="text-muted mb-0">{{ $asset->free_rubies }} Pieces</p>
                                    </td>
                                    <td class="text-end">$0.00</td>
                                </tr>
                                <!-- Total USD -->
                                <tr class="table-active">
                                    <th colspan="2">Total (USD) :</th>
                                    <td class="text-end">
                                        <span class="fw-semibold">
                                            ${{$asset->price}}
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->
        </div>
    </div>
@endsection

@section('script')
<!-- Checkout Page -->
<script src="{{ URL::asset('assets/js/pages/ecommerce-product-checkout.init.js') }}"></script>
<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<!-- App JS -->
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection