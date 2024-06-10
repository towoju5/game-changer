@extends('layouts.master-without-nav')

@section('title')
    @lang('translation.signin')
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
                            <div class="row g-0">
                                <div class="col-lg-6">
                                    <div class="p-lg-5 p-4 auth-one-bg h-100">
                                        <div class="bg-overlay"></div>
                                    </div>
                                </div>
                                <!-- end col -->

                                <div class="col-lg-6">
                                    <div class="p-lg-5 p-4">
                                        <div>
                                            <h5 class="text-success">Welcome Back !</h5>
                                            <p class="text-muted">Sign In to continue to GC7 Cafe.</p>
                                        </div>

                                        <div class="mt-4">
                                            <form action="{{ route('login') }}" method="POST">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="Email" class="form-label">Email</label>
                                                    <input required type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" id="email" name="email" placeholder="Enter email">
                                                    <!-- Validation Error -->
                                                    @error('email')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>These credentials doesn't match our records.</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label" for="password-input">Password</label>
                                                    <div class="position-relative auth-pass-inputgroup mb-3">
                                                        <input required type="password" class="form-control pe-5 @error('password') is-invalid @enderror password-input" placeholder="Enter password" id="password-input" name="password">
                                                    </div>
                                                    <!-- Validation Error -->
                                                    @error('password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>These credentials doesn't match our records.</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="" id="auth-remember-check">
                                                    <label class="form-check-label" for="auth-remember-check">Remember me</label>
                                                    <div class="float-end">
                                                        <a href="{{ url('/password/reset') }}" class="text-muted">Forgot password?</a>
                                                    </div>
                                                </div>

                                                <div class="mt-4">
                                                    <button class="btn btn-success w-100" type="submit">Login</button>
                                                </div>
                                            </form>
                                        </div>

                                        <div class="mt-4 text-center">
                                            <p class="mb-0">Don't have an account? <a href="{{ route('register') }}" class="fw-semibold text-success text-decoration-underline">Register</a></p>
                                            <p class="mt-3 mb-0">
                                                <a target="_blank" href="{{ url('/user/agreement') }}" class="fw-semibold text-muted text-decoration-underline">User Agreement</a>
                                                <span class="text-muted">|</span>

                                                <a target="_blank" href="{{ url('/community/convention') }}" class="fw-semibold text-muted text-decoration-underline">Community Convention</a>
                                                <span class="text-muted">|</span>

                                                <a target="_blank" href="{{ url('/account/deletion') }}" class="fw-semibold text-muted text-decoration-underline">Account Deletion</a>
                                            </p>
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
    <!-- end auth-page-wrapper -->
@endsection