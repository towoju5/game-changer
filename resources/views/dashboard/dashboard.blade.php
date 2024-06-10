@extends('layouts.master')

@section('title')
    @lang('translation.dashboard')
@endsection

@section('content')
    <!-- Opening Note & Filter -->
    <div class="row mb-3 pb-1">
        <div class="col-12">
            <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-16 mb-1">Good Morning, {{ Auth::user()->first_name }}!</h4>
                    <p class="text-muted mb-0">Here's what's happening with GC7 Cafe today.</p>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="text-center">
                <img class="img-fluid col-md-6" src="{{ asset('assets/images/gc7-dashboard.png') }}">
            </div>
        </div>
    </div>
@endsection

@section('script')
<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<!-- Apex Charts -->
<script src="{{ URL::asset('/assets/libs/apexcharts/apexcharts.min.js') }}"></script>
<!-- Dashboard CRM -->
<script src="{{ URL::asset('/assets/js/pages/dashboard-crm.init.js') }}"></script>
<!-- App JS -->
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection