@extends('layouts.master')
@section('title')
    @lang('translation.profile')
@endsection

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('assets/libs/swiper/swiper.min.css') }}">
@endsection

@section('content')
    @php
        if (Auth::user()->first_name || Auth::user()->last_name) {
            $full_name = Auth::user()->first_name.' '.Auth::user()->last_name;
        }else{
            $full_name = 'N/A';
        }
    @endphp

    <div class="profile-foreground position-relative mx-n4 mt-n4">
        <div class="profile-wid-bg" style="background: url(/assets/images/waiting.gif); background-repeat: no-repeat; background-size:100% 100%">
            {{-- <img src="" class="profile-wid-img" /> --}}
        </div>
    </div>

    <div class="pt-4 mb-4 mb-lg-3 pb-lg-4">
        <div class="row g-4">
            <div class="col-auto">
                <div class="">
                    <img src="@if (Auth::user()->profile_picture != 'avatar-1.jpg') {{ URL::asset(Auth::user()->profile_picture) }} @else {{ URL::asset('images/avatar-1.jpg') }} @endif" alt="user-img" class="rounded-circle avatar-xl img-thumbnail user-profile-image" />
                </div>
            </div>

            <div class="col">
                <div class="p-2">
                    <h3 class="text-white mb-1">{{ $full_name }}</h3>
                    <p class="text-white-75">{{ Auth::user()->username ?? 'N/A'}}</p>
                    <div class="hstack text-white-50 gap-1">
                        <div class="me-2"><i
                                class="ri-map-pin-user-line me-1 text-white-75 fs-16 align-middle"></i>United States</div>
                        <div><i class="ri-building-line me-1 text-white-75 fs-16 align-middle"></i>GC7 Cafe
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div>
                <div class="d-flex">
                    <!-- Tabs Start -->
                    <ul class="nav nav-pills animation-nav profile-nav gap-2 gap-lg-3 flex-grow-1" role="tablist">
                        <!-- Overview Tab -->
                        <li class="nav-item">
                            <a class="nav-link fs-14 active" data-bs-toggle="tab" href="#overview-tab" role="tab">
                                <i class="ri-user-3-fill d-inline-block d-md-none"></i> 
                                <span class="d-none d-md-inline-block">Overview</span>
                            </a>
                        </li>
                        <!-- Documents Tab -->
                        @if (Auth::user()->account_verification == 'Suspended')
                            <li class="nav-item">
                                <a class="nav-link fs-14" data-bs-toggle="tab" href="#documents-tab" role="tab">
                                    <i class="ri-folder-2-fill d-inline-block d-md-none"></i> 
                                    <span class="d-none d-md-inline-block">Documents</span>
                                </a>
                            </li>
                        @endif
                    </ul>

                    <div class="flex-shrink-0">
                        <a href="{{ url('/profile/edit') }}" class="btn btn-light">
                            <i class="ri-edit-box-line align-bottom"></i> Edit Profile</a>
                    </div>
                </div>
                <!-- Tab panes -->
                <div class="tab-content pt-4 text-muted">
                    <!-- Overview Tab Content -->
                    <div class="tab-pane active" id="overview-tab" role="tabpanel">
                        <div class="row">
                            <div class="col-xxl-3">
                                <div class="card">
                                    <div class="card-body">
                                        <!-- Session Messages -->
                                        @include('partials.session')
                                        @php $user = Auth::user(); @endphp

                                        <!-- Profile Under Review Notice -->
                                        @if ($user->first_name != null && $user->last_name != null && $user->username != null && $user->account_verification == 'Under Review')
                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Notice:</strong> Your account is under review. You'll hear from us via email within 1-2 business days.
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>    
                                        @endif

                                        <!-- Profile Suspended Notice -->
                                        @if ($user->first_name != null && $user->last_name != null && $user->username != null && $user->account_verification == 'Suspended')
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <strong>Notice:</strong> Your account is suspended. We've emailed you the reason why it got suspended. Kindly check your inbox, and follow the instructions to get it reactivated.
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>    
                                        @endif

                                        <h5 class="card-title mb-3">Personal Information</h5>
                                        <div class="table-responsive">
                                            <table class="table table-bordered mb-1">
                                                <tbody>
                                                    <tr>
                                                        <th class="ps-0" scope="row">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Full Name :</th>
                                                        <td class="text-muted">{{ $full_name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="ps-0" scope="row">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Username :</th>
                                                        <td class="text-muted">{{ Auth::user()->username ?? 'N/A'}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="ps-0" scope="row">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Email :</th>
                                                        <td class="text-muted">{{ Auth::user()->email }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="ps-0" scope="row">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Account :</th>
                                                        <td class="text-muted">{{ Auth::user()->account_verification }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="ps-0" scope="row">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Joining Date :</th>
                                                        <td class="text-muted">{{ Auth::user()->created_at->format('d F, Y') }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Documents Tab Content -->
                    @if (Auth::user()->account_verification == 'Suspended')
                        <div class="tab-pane" id="documents-tab" role="tabpanel">
                            <div class="row">
                                <div class="col-xxl-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title mb-3">Verification Documents</h5>
                                            <div class="table-responsive">
                                                <form action="{{ url('/profile/update/documents') }}" method="POST" enctype="multipart/form-data">
                                                    @csrf                                            
                                                    <table class="table table-bordered mb-1">
                                                        <tbody>
                                                            <tr>
                                                                <th style="width:40%;" class="ps-0" scope="row">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Selfie :</th>
                                                                <td class="text-muted">
                                                                    <input required type="file" accept="image/*" capture="camera" class="form-control" name="selfie">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th style="width:40%;" class="ps-0" scope="row">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ID Card (Front) :</th>
                                                                <td class="text-muted">
                                                                    <input required type="file" accept="image/*" class="form-control" name="idCardFront">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th style="width:40%;" class="ps-0" scope="row">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ID Card (Back) :</th>
                                                                <td class="text-muted">
                                                                    <input required type="file" accept="image/*" class="form-control" name="idCardBack">
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <button type="submit" class="btn btn-primary mt-2">Submit</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
@endsection
@section('script')
    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="{{ URL::asset('assets/libs/swiper/swiper.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/profile.init.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
