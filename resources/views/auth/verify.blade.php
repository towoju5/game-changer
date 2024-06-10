@extends('layouts.master-without-nav')
@section('title')
@lang('translation.verify-email')
@endsection

@section('content')
    <!-- auth-page wrapper -->
    <div class="auth-page-wrapper auth-bg-cover py-5 d-flex justify-content-center align-items-center min-vh-100">
        <div class="bg-overlay"></div>
        <!-- auth-page content -->
        <div class="auth-page-content overflow-hidden pt-lg-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card overflow-hidden">
                            <div class="row justify-content-center g-0">
                                <div class="col-lg-6">
                                    <div class="p-lg-5 p-4 auth-one-bg h-100">
                                        <div class="bg-overlay"></div>
                                    </div>
                                </div>
                                <!-- end col -->

                                <div class="col-lg-6">
                                    <div class="p-lg-5 p-4">
                                        <div class="mb-4">
                                            <div class="avatar-lg mx-auto">
                                                <div class="avatar-title bg-light text-success display-5 rounded-circle">
                                                    <i class="ri-mail-line"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="text-muted text-center mx-lg-3">
                                            <h4 class="mb-3">Verify Your Email</h4>
                                            <p>To proceed, click on the verification link sent to <span class="fw-semibold">{{ Auth::user()->email }}</span></p>
                                        </div>

                                        <div class="mt-4">
                                            <form action="{{ url('/email/resend') }}" method="POST">
                                                @csrf
                                                <div class="row"></div>
                                                <div class="mt-3">
                                                    <button type="submit" class="btn btn-success w-100">Resend</button>
                                                </div>
                                            </form>
                                        </div>

                                        <div class="mt-4 text-center">
                                            <p class="mb-0">Didn't receive an email? </p>
                                        </div>
                                    </div>
                                </div>
                                <!-- end col -->
                            </div>
                            <!-- end row -->
                        </div>
                        <!-- end card -->
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end auth page content -->

        <!-- footer -->
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <p class="mb-0">&copy;
                                <script>
                                    document.write(new Date().getFullYear())
                                </script> GC7 Cafe. Powered <i class="mdi mdi-lightning-bolt text-warning"></i> by <a class="text-light" href="{{ url('https://nerdflow.tech') }}" target="_blank">Nerd Flow</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- end Footer -->
    </div>
@endsection

@section('script')
    <script src="{{ URL::asset('assets/js/pages/two-step-verification.init.js') }}"></script>
@endsection