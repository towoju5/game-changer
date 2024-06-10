@extends('layouts.master')

@section('title')
    @lang('translation.edit_profile')
@endsection

@section('content')
    @php
    if (Auth::user()->first_name || Auth::user()->last_name) {
        $full_name = Auth::user()->first_name.' '.Auth::user()->last_name;
    }else{
        $full_name = 'N/A';
    }
    @endphp

    <div class="position-relative mx-n4 mt-n4">
        <div class="profile-wid-bg profile-setting-img">
            <img src="" alt="" class="profile-wid-img" />
        </div>
    </div>

    <div class="row">
        <div class="col-xxl-3">
            <div class="card mt-n5">
                <div class="card-body p-4">
                    <!-- Session Messages -->
                    @include('partials.session')
                    @php $user = Auth::user(); @endphp

                    <!-- Profile Completion Notice -->
                    @if ($user->first_name == null || $user->last_name == null || $user->username == null)
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Notice:</strong> Fill your personal details to proceed with the account verification!
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>    
                    @endif
                    
                    <div class="text-center">
                        <div class="profile-user position-relative d-inline-block mx-auto mb-4">
                            <img src="@if (Auth::user()->profile_picture != 'avatar-1.jpg') {{ URL::asset(Auth::user()->profile_picture) }} @else {{ URL::asset('images/avatar-1.jpg') }} @endif" class="rounded-circle avatar-xl img-thumbnail user-profile-image">
                        </div>
                        <h5 class="fs-16 mb-1">{{ $full_name }}</h5>
                        <p class="text-muted mb-0">{{ Auth::user()->username ?? 'N/A'}}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xxl-9">
            <div class="card mt-xxl-n5">
                <!-- Tabs Start -->
                <div class="card-header">
                    <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#personalDetails" role="tab">
                                Personal Details
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#changePassword" role="tab">
                                Change Password
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#changeAvatar" role="tab">
                                Change Avatar
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body p-4">
                    <div class="tab-content">
                        <!-- Personal Details Tab -->
                        <div class="tab-pane active" id="personalDetails" role="tabpanel">
                            <form method="POST" action="{{ url('/profile/update') }}">
                                @csrf
                                <div class="row">
                                    <!-- First Name -->
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="First Name" class="form-label">First Name</label>
                                            <input required type="text" class="form-control" name="first_name" placeholder="John" value="{{ Auth::user()->first_name }}">
                                        </div>
                                    </div>
                                    <!-- Last Name -->
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="Last Name" class="form-label">Last Name</label>
                                            <input required type="text" class="form-control" name="last_name" placeholder="Doe" value="{{ Auth::user()->last_name }}">
                                        </div>
                                    </div>
                                    <!-- Username -->
                                    <div class="col-lg-6 form-group">
                                        <div class="mb-3">
                                            <label for="Username" class="form-label">Username</label>
                                            <div class="form-icon">
                                                <input required type="text" class="form-control form-control-icon" name="username" id="iconInput" placeholder="johndoe7" value="{{ Auth::user()->username }}">
                                                <i class="ri-user-line"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Email Address -->
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="Email Address" class="form-label">Email Address</label>
                                            <input disabled type="email" class="form-control" placeholder="johndoe7@gmail.com" value="{{ Auth::user()->email }}">
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="hstack gap-2 justify-content-end">
                                            <button type="submit" class="btn btn-primary">Update Profile</button>
                                            <a href="{{ url('/profile') }}" class="btn btn-danger">Cancel</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Change Password Tab -->
                        <div class="tab-pane" id="changePassword" role="tabpanel">
                            <form action="{{ url('/profile/update/password') }}" method="POST">
                                @csrf
                                <div class="row g-2">
                                    <!--New Password -->
                                    <div class="col-lg-6">
                                        <div>
                                            <label for="New Password" class="form-label">New Password</label>
                                            <input required type="password" class="form-control" name="password" placeholder="Enter new password">
                                        </div>
                                    </div>
                                    <!-- Password Confirmation -->
                                    <div class="col-lg-6">
                                        <div>
                                            <label for="Confirm Password" class="form-label">Confirm Password</label>
                                            <input required type="password" class="form-control" name="password_confirmation" placeholder="Confirm password">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="text-end mt-2">
                                            <button type="submit" class="btn btn-primary">Update Password</button>
                                            <a href="{{ url('/profile') }}" class="btn btn-danger">Cancel</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Change Avatar Tab -->
                        <div class="tab-pane" id="changeAvatar" role="tabpanel">
                            <form action="{{ url('/profile/update/avatar') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row g-2">
                                    <!-- Avatar -->
                                    <div class="col-lg-12">
                                        <label for="Avatar" class="form-label">Avatar</label>
                                        <input required type="file" class="form-control" name="file" accept="image/*">
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="text-end mt-2">
                                            <button type="submit" class="btn btn-primary">Update Avatar</button>
                                            <a href="{{ url('/profile') }}" class="btn btn-danger">Cancel</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script src="{{ URL::asset('assets/js/pages/profile-setting.init.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <!-- Input Mask -->
    <script src="{{ URL::asset('assets/libs/cleave.js/cleave.js.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/form-masks.init.js') }}"></script>
@endsection
