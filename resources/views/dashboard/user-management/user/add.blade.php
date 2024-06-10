@extends('layouts.master')
@section('title') @lang('translation.users') @endsection

@section('css')
<!-- Select2 css-->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<!-- Breadcrumb Trail -->
@component('components.breadcrumb')
@slot('li_1')
    @lang('translation.users')
@endslot
@slot('title')
    @lang('translation.add')
@endslot
@endcomponent

<!-- Session Messages -->
@include('partials.session')

<!-- Add Form -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h1 class="card-title mb-0">Add User</h1>
            </div>
            <div class="card-body">
                <div class="row">
                    <form method="POST" action="{{ url('/user/store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="First Name" class="form-label">First Name</label>
                                <input required type="text" class="form-control" name="first_name" placeholder="John">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="Last Name" class="form-label">Last Name</label>
                                <input required type="text" class="form-control" name="last_name" placeholder="Doe">
                            </div>

                            <div class="col-md-4 mb-3 form-group">
                                <label for="Username" class="form-label">Username</label>
                                <div class="form-icon">
                                    <input required type="text" class="form-control form-control-icon" name="username" id="iconInput" placeholder="johndoe7">
                                    <i class="ri-user-line"></i>
                                </div>
                            </div>

                            <div class="col-md-4 mb-3 form-group">
                                <label for="iconInput" class="form-label">Email</label>
                                <div class="form-icon">
                                    <input required type="email" class="form-control form-control-icon" name="email" id="iconInput" placeholder="johndoe@gmail.com">
                                    <i class="ri-mail-unread-line"></i>
                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="Password" class="form-label">Password</label>
                                <input required type="password" class="form-control" name="password" placeholder="********">
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="Role" class="form-label">Role</label>
                                <select required class="js-example-basic-single" name="role">
                                    @foreach ($roles as $role)
                                        <option>{{ $role->name }}</option>    
                                    @endforeach                                          
                                </select>
                            </div>

                            <div class="col-md-12 form-group mb-2">
                                <a style="margin-right:3px;" href="{{ url('user/list') }}" class="btn btn-danger btn-sm">Cancel</a>
                                <input type="submit" class="btn btn-success btn-sm">
                            </div>
                        </div>
                    </form>        
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<!-- Select2 cdn -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ URL::asset('assets/js/pages/select2.init.js') }}"></script>
<!-- Input Mask -->
<script src="{{ URL::asset('assets/libs/cleave.js/cleave.js.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/pages/form-masks.init.js') }}"></script>
<!-- App JS -->
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection