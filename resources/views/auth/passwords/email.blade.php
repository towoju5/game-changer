@extends('layouts.master-without-nav')
@section('title')
    @lang('translation.forgot-password')
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
                                        <h5 class="text-success">Forgot Password?</h5>
                                        <p class="text-muted">Reset password with GC7 Cafe</p>
                                        <!-- Displaying Success Message -->
                                        @if (session('status'))
                                            <div class="mt-2 text-center">
                                                <lord-icon src="https://cdn.lordicon.com/rhvddzym.json" trigger="loop"
                                                    colors="primary:#0ab39c" class="avatar-xl">
                                                </lord-icon>
                                            </div>

                                            <div class="alert alert-borderless alert-success text-center mb-2 mx-2" role="alert">
                                                We have emailed your password reset link!
                                            </div>
                                        @endif

                                        <div class="p-2"> 
                                            <form action="{{ route('password.email') }}" method="POST">
                                                @csrf
                                                <div class="mb-4">
                                                    <label class="form-label">Email</label>
                                                    <input required type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Enter email address" value="{{ old('email') }}">
                                                    @error('email')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>We can't find a user with that email address.</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                <div class="text-center mt-4">
                                                    <button class="btn btn-success w-100" type="submit">Send Reset Link</button>
                                                </div>
                                            </form>
                                        </div>

                                        <div class="mt-5 text-center">
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
    </div>
    <!-- end auth-page-wrapper -->
@endsection

@section('script')
@endsection