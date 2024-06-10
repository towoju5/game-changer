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

<!-- Items Showcase -->
<div class="row row-cols-xxl-5 row-cols-xl-4 row-cols-lg-3 row-cols-md-2 row-cols-1">

    @foreach ($assets as $asset)
        <div class="col list-element">
            <div class="card explore-box card-animate ribbon-box right">
                <div class="explore-place-bid-img">
                    <div class="ribbon-two ribbon-two-danger"><span><i class="ri-fire-fill align-bottom"></i> Hot</span></div>
                    <img src="{{ asset($asset->image) }}" alt="{{ $asset->name }}" class="card-img-top explore-img" />
                    <div class="bg-overlay"></div>
                    <div class="place-bid-btn">
                        <a href="{{ url('/market-place/asset/'.encrypt($asset->id).'/checkout') }}" class="btn btn-success">Buy Now!</a>
                    </div>
                </div>
                <div class="card-body">
                    <h5 class="mb-1"><a href="apps-nft-item-details">{{ $asset->name }}</a></h5>
                    <p class="text-muted mb-0">Quantity: {{ $asset->quantity }}</p>
                </div>
                <div class="card-footer border-top border-top-dashed">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 fs-14">
                            <i class="ri-price-tag-3-fill text-warning align-bottom me-1"></i> Price: <span class="fw-medium">${{ $asset->price }}</span>
                        </div>
                        <h5 class="flex-shrink-0 fs-14 text-primary mb-0">Free {{ $asset->free_rubies }} Rubies</h5>
                    </div>
                </div>
            </div>
        </div>        
    @endforeach

</div>
@endsection

@section('script')
<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<!-- App JS -->
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection