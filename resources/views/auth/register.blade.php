@extends('layouts.master-without-nav')

@section('title')
@lang('translation.signup')
@endsection

<!-- Webcam Shit -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>

@section('content')
    <!-- auth-page wrapper -->
    <div class="auth-page-wrapper auth-bg-cover py-5 d-flex justify-content-center align-items-center min-vh-100">
        <div class="bg-overlay"></div>
        <!-- auth-page content -->
        <div class="auth-page-content overflow-hidden pt-lg-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card overflow-hidden m-0">
                            <div class="row justify-content-center g-0">
                                <div class="col-lg-6">
                                    <div class="p-lg-5 p-4 auth-one-bg h-100">
                                        <div class="bg-overlay"></div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="p-lg-5 p-4">
                                        <div>
                                            <h5 class="text-success">Register Account</h5>
                                            <p class="text-muted">Get your Free Game Changer account now.</p>
                                        </div>

                                        <div class="mt-4">
                                            <form class="needs-validation" novalidate method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                                                @csrf
                                                <!-- Email -->
                                                <div class="mb-3">
                                                    <label for="Email" class="form-label">Email</label>
                                                    <input required type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Enter email" value="{{ old('email') }}">
                                                    <!-- Validation Error -->
                                                    @error('email')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                <!-- Password -->
                                                <div class="mb-3">
                                                    <label class="form-label" for="password-input">Password</label>
                                                    <div class="position-relative auth-pass-inputgroup">
                                                        <input required type="password" class="form-control @error('password') is-invalid @enderror pe-5 password-input" onpaste="return false" placeholder="Enter password" id="password-input" name="password">
                                                        <!-- Validation Error -->
                                                        @error('password')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <!-- Selfie Image -->
                                                <div class="mb-3">
                                                    <label for="Selfie" class="form-label">Selfie</label><br>
                                                    <!-- Inline Radios - Selfie -->
                                                    <div class="form-check form-check-inline">
                                                        <input required class="form-check-input disableOnMobileScreen" type="radio" name="selfie_radio" value="selfie_take_picture">
                                                        <label class="form-check-label">Take Picture</label>
                                                    </div>
                                                    <div class="form-check form-check-inline mb-2">
                                                        <input required class="form-check-input" type="radio" name="selfie_radio" value="selfie_upload_file">
                                                        <label class="form-check-label">Upload File</label>
                                                    </div>
                                                    <!-- Selfie Input Field -->
                                                    <input style="display:none;" type="file" accept="image/*" capture="camera" class="form-control" id="selfie_input_field" name="selfie_input_field">
                                                    <!-- Selfie Camera Div -->
                                                    <div id="selfie_camera_capture" style="display:none;" class="row">
                                                        <div class="col-md-6">
                                                            <!-- Selfie Camera Div -->
                                                            <div class="selfieCameraClass" id="camera"></div><br/>
                                                            <!-- Selfie Camera Capture Button -->
                                                            <input class="btn btn-success selfieCameraClass" type="button" value="Capture" onclick="capture_selfie()">
                                                            <!-- Selfie Camera Hidden Input -->
                                                            <input type="hidden" name="selfie_input_hidden" class="selfie-image">
                                                        </div>
                                                        <!-- Captured Selfie Image -->
                                                        <div class="col-md-12">
                                                            <div id="capturedSelfieImage"></div>
                                                        </div>
                                                        <!-- Retake Selfie Camera Capture Button -->
                                                        <div class="col-md-6">
                                                            <input id="retakeSelfieBtn" style="display: none;" class="btn btn-success mt-3" type="button" value="Retake" onclick="retake_selfie()">
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- ID Card -->
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label for="ID Card (Front)" class="form-label">ID Card (Front)</label>
                                                        <input required type="file" accept="image/*" class="form-control @error('id_card_front') is-invalid @enderror" name="id_card_front">
                                                        <!-- Validation Error -->
                                                        @error('id_card_front')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>

                                                    <div class="col-md-6 mb-3">
                                                        <label for="ID Card (Back)" class="form-label">ID Card (Back)</label>
                                                        <input required type="file" accept="image/*" class="form-control @error('id_card_back') is-invalid @enderror" name="id_card_back">
                                                        <!-- Validation Error -->
                                                        @error('id_card_back')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <!-- Terms & Condition -->
                                                <div class="mb-4">
                                                    <p class="mb-0 fs-12 text-muted fst-italic">By registering you confirm that you are 18+ and agree to all &nbsp;<a href="#" class="text-success text-decoration-underline fst-normal fw-medium">Terms and Policies.</a></p>
                                                </div>

                                                <!-- Register Button -->
                                                <div class="mt-4">
                                                    <button class="btn btn-success w-100" type="submit">Register</button>
                                                </div>
                                            </form>
                                        </div>

                                        <div class="mt-5 text-center">
                                            <p class="mb-0">Already have an account? <a href="{{ route('login') }}" class="fw-semibold text-success text-decoration-underline"> Login</a> </p>
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
                            </div>
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
    <script src="{{ URL::asset('assets/js/pages/form-validation.init.js') }}"></script>
    <!-- Disable Take Selfie on Mobile -->
    <script>
        $(document).ready(function() {
          // Function to check screen width and disable radio box
          function checkScreenWidth() {
            if ($(window).width() <= 800) {
              // Disable the radio box
              $('.disableOnMobileScreen').prop('disabled', true);
            } else {
              // Enable the radio box
              $('.disableOnMobileScreen').prop('disabled', false);
            }
          }
    
          // Initial check on page load
          checkScreenWidth();
    
          // Check screen width on window resize
          $(window).resize(function() {
            checkScreenWidth();
          });
        });
    </script>

    <!-- Selfie Custom JS -->
    <script>
        //Triggered Event for Selfie Radio Box
        $('input[type=radio][name=selfie_radio]').change(function() {
            if (this.value == 'selfie_take_picture') {
                //Asking for Camera Permission
                Webcam.set({
                    width: 490,
                    height: 350,
                    image_format: 'jpeg',
                    jpeg_quality: 100
                });
                Webcam.attach('#camera');

                //Front End Logic Starts Here
                $('#selfie_input_field').hide();
                $('#selfie_input_field').val('');
                $('#selfie_input_field').removeAttr('required');
                $('#selfie_camera_capture').show();
                $('.selfieCameraClass').show();
                $(".selfie-image").val('');
                document.getElementById('capturedSelfieImage').innerHTML = '';
                $('#retakeSelfieBtn').hide();

            }else if (this.value == 'selfie_upload_file') {
                $('#selfie_input_field').attr('required', 'required');
                $('#selfie_input_field').show();
                $(".selfie-image").val('');
                document.getElementById('capturedSelfieImage').innerHTML = '';
                $('#selfie_camera_capture').hide();
            }
        });

        //Capture Selfie Function
        function capture_selfie() {
            Webcam.snap(function(data_uri) {
                $(".selfie-image").val(data_uri);
                document.getElementById('capturedSelfieImage').innerHTML = '<img src="'+data_uri+'"/>';
                $('.selfieCameraClass').hide();
                $('#retakeSelfieBtn').show();
            });
        }

        //Retake Selfie Function
        function retake_selfie() {
            $(".selfie-image").val('');
            document.getElementById('capturedSelfieImage').innerHTML = '';
            $('.selfieCameraClass').show();
            $('#retakeSelfieBtn').hide();
        }
    </script>
@endsection
