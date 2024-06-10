@extends('layouts.master-without-nav')

@section('title')
    @lang('translation.Error_403')
@endsection

@section('body')
<body>
@endsection
@section('content')

    <!-- auth-page wrapper -->
    <div class="auth-page-wrapper py-5 d-flex justify-content-center align-items-center min-vh-100">

        <!-- auth-page content -->
        <div class="auth-page-content overflow-hidden p-0">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-xl-4 text-center">
                        <div class="error-500 position-relative">
                            <img src="{{ URL::asset('assets/images/error500.png') }}" alt="" class="img-fluid error-500-img error-img" />
                            <h1 class="title text-muted">403</h1>
                        </div>
                        <div>
                            <h4>THIS ACTION IS UNAUTHORIZED!</h4>
                            <p class="text-muted w-75 mx-auto">Sorry, you don't have permission to view this page!</p>
                            <a href="{{url('/')}}" class="btn btn-success"><i class="mdi mdi-home me-1"></i>Back to home</a>
                        </div>
                    </div><!-- end col-->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end auth-page content -->
    </div>
    <!-- end auth-page-wrapper -->
@endsection