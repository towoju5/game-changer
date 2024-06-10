@extends('layouts.master-without-nav')
@section('title')
    @lang('translation.reset-password')
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
                                        <h5 class="text-success">Create new password</h5>
                                        <p class="text-muted">Your new password must be different from previous used password.</p>

                                        <div class="p-2">
                                            <form action="{{ route('password.update') }}" method="POST">
                                                @csrf
                                                <!-- Password Reset Token -->
                                                <input type="hidden" name="token" value="{{ $token }}">
                                                <!-- Email -->
                                                <input type="hidden" name="email" value="{{ $email }}">
                                                <!-- Password -->
                                                <div class="mb-3">
                                                    <label class="form-label" for="password-input">Password</label>
                                                    <div class="position-relative auth-pass-inputgroup">
                                                        <input required type="password" class="form-control @error('password') is-invalid @enderror pe-5 password-input" name="password" onpaste="return false" placeholder="Enter password">
                                                        @error('password')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label" for="confirm-password-input">Confirm Password</label>
                                                    <div class="position-relative auth-pass-inputgroup mb-3">
                                                        <input required type="password" class="form-control pe-5 password-input" name="password_confirmation" onpaste="return false" placeholder="Confirm password">
                                                    </div>
                                                </div>

                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="" id="auth-remember-check">
                                                    <label class="form-check-label" for="auth-remember-check">Remember me</label>
                                                </div>

                                                <div class="mt-4">
                                                    <button class="btn btn-success w-100" type="submit">Reset Password</button>
                                                </div>

                                            </form>
                                        </div>

                                        <div class="mt-4 text-center">
                                            <p class="mb-0">Remember it? 
                                                <a href="{{ url('/login') }}" class="fw-semibold text-success text-decoration-underline">Login</a>
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

@section('script')
    <script src="{{ URL::asset('assets/js/pages/passowrd-create.init.js') }}"></script>
@endsection