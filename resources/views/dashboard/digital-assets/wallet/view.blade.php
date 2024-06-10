@extends('layouts.master')
@section('title') @lang('translation.wallet') @endsection

@section('content')

<!-- Breadcrumb Trail -->
@component('components.breadcrumb')
    @slot('li_1')
        @lang('translation.digital-assets')
    @endslot
    @slot('title')
        @lang('translation.wallet')
    @endslot
@endcomponent

<!-- Session Messages -->
@include('partials.session')

    <!-- Digital Assets Balance -->
    <div class="row">
        <!-- Diamonds -->
        <div class="col-xxl-3 col-md-4">
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex mb-3">
                        <div class="flex-grow-1">
                            <img style="width:95px;height:95px" src="{{ asset('assets/digital_assets/diamond.jpg') }}">
                        </div>
                    </div>
                    <h3 class="mb-2"><span class="counter-value" data-target="{{ $user->diamonds }}">0</span> Diamonds</h3>
                    <h6 class="text-muted mb-0">Total Available</h6>
                </div>
            </div>
        </div>

        <!-- Rubies -->
        <div class="col-xxl-3 col-md-4">
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex mb-3">
                        <div class="flex-grow-1">
                            <img style="width:95px;height:95px" src="{{ asset('assets/digital_assets/ruby.jpg') }}">
                        </div>
                    </div>
                    <h3 class="mb-2"><span class="counter-value" data-target="{{ $user->rubies }}">0</span> Rubies</h3>
                    <h6 class="text-muted mb-0">Total Available</h6>
                </div>
            </div>
        </div>

        <!-- Rocks -->
        <div class="col-xxl-3 col-md-4">
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex mb-3">
                        <div class="flex-grow-1">
                            <img style="width:95px;height:95px" src="{{ asset('assets/digital_assets/rock.jpg') }}">
                        </div>
                    </div>
                    <h3 class="mb-2"><span class="counter-value" data-target="{{ $user->rocks }}">0</span> Rocks</h3>
                    <h6 class="text-muted mb-0">Total Available</h6>
                </div>
            </div>
        </div>

        <!-- Teddy Bears -->
        <div class="col-xxl-3 col-md-6">
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex mb-3">
                        <div class="flex-grow-1">
                            <img style="width:95px;height:95px" src="{{ asset('assets/digital_assets/teddy_bear.png') }}">
                        </div>
                    </div>
                    <h3 class="mb-2"><span class="counter-value" data-target="{{ $user->teddy_bears }}">0</span> Teddy Bears</h3>
                    <h6 class="text-muted mb-0">Total Available</h6>
                </div>
            </div>
        </div>

        <!-- Coins -->
        <div class="col-xxl-3 col-md-6">
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex mb-3">
                        <div class="flex-grow-1">
                            <img style="width:95px;height:95px" src="{{ asset('assets/digital_assets/coin.jpg') }}">
                        </div>
                    </div>
                    <h3 class="mb-2"><span class="counter-value" data-target="{{ $user->coins }}">0</span> Coins</h3>
                    <h6 class="text-muted mb-0">Total Available</h6>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
