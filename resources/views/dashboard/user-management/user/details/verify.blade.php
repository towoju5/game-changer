@extends('layouts.master')
@section('title') @lang('translation.verify-user') @endsection

@section('css')
<!-- Select2 css-->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<!-- Breadcrumb Trail -->
@component('components.breadcrumb')
@slot('li_1')
    @lang('translation.user')
@endslot
@slot('title')
    @lang('translation.verify')
@endslot
@endcomponent

<!-- Session Messages -->
@include('partials.session')

<!-- Personal Information -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h1 class="card-title mb-0">Personal Information</h1>
            </div>
            <div class="card-body">                    
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="First Name" class="form-label">First Name</label>
                        <input disabled type="text" class="form-control" name="first_name" placeholder="John" value="{{ $user->first_name }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="Last Name" class="form-label">Last Name</label>
                        <input disabled type="text" class="form-control" name="last_name" placeholder="Doe" value="{{ $user->last_name }}">
                    </div>

                    <div class="col-md-6 mb-3 form-group">
                        <label for="Username" class="form-label">Username</label>
                        <div class="form-icon">
                            <input disabled type="text" class="form-control form-control-icon" name="username" id="iconInput" placeholder="johndoe7" value="{{ $user->username }}">
                            <i class="ri-user-line"></i>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3 form-group">
                        <label for="iconInput" class="form-label">Email</label>
                        <div class="form-icon">
                            <input disabled type="email" class="form-control form-control-icon" name="email" id="iconInput" placeholder="johndoe@gmail.com" value="{{ $user->email }}">
                            <i class="ri-mail-unread-line"></i>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="iconInput" class="form-label">Welcome Notes</label>
                        <div class="form-icon">
                            <select name="welcome_note" id="welcome_note" class="form-control form-control-icon">
                                @foreach ($welcome_notes as $welcome_note)
                                    <option value="{{$welcome_note->note}}" @selected($welcome_note->note == get_settings('default_welcome_note'))>{{mb_strimwidth($welcome_note->note, 0, 50, "...")}}</option>
                                @endforeach
                            </select>
                            <i class="ri-article-fill"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{--<form action="{{ url('/user/verify/account/suspend/'.encrypt($user->id)) }}" method="POST" enctype="multipart/form-data"> --}}
<!-- Verification Documents -->
<div class="row">
    <div class="col-xxl-3">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h5 class="card-title">Verification Documents</h5>
                    </div>
                    <div class="col-md-6">
                        <!-- Suspend Button -->
                        <a style="float: right;margin-left:5px;" type="button" data-bs-toggle="modal" data-bs-target="#suspendModal" class="btn btn-danger btn-sm">Suspend</a>
                        <!-- Approve Button -->
                        <a style="float: right;" type="button" data-bs-toggle="modal" data-bs-target="#approveModal" class="btn btn-success btn-sm">Approve</a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered mb-2">
                        <tbody>
                            <tr>
                                <th class="ps-0" scope="row">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Selfie :</th>
                                <td class="text-muted text-center"><a href="{{ url('/user/verify/account/download/selfie/'.encrypt($user->id)) }}">Preview</a></td>
                            </tr>
                            <tr>
                                <th class="ps-0" scope="row">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ID Card (Front) :</th>
                                <td class="text-muted text-center"><a href="{{ url('/user/verify/account/download/idCardFront/'.encrypt($user->id)) }}">Preview</a></td>
                            </tr>
                            <tr>
                                <th class="ps-0" scope="row">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ID Card (Back) :</th>
                                <td class="text-muted text-center"><a href="{{ url('/user/verify/account/download/idCardBack/'.encrypt($user->id)) }}">Preview</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- Approve Modal -->
                <div class="modal fade" id="approveModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-body text-center p-5">
                                <lord-icon
                                    src="https://cdn.lordicon.com/lupuorrc.json"
                                    trigger="loop"
                                    colors="primary:#121331,secondary:#08a88a"
                                    style="width:120px;height:120px">
                                </lord-icon>
                                
                                <div class="mt-4">
                                    <h4 class="mb-3">Approve Account</h4>
                                    <p class="text-muted mb-4">Are you sure you want to approve this account?</p>
                                    <div class="hstack gap-2 justify-content-center">
                                        <form action="{{ url('/user/verify/account/approve/'.encrypt($user->id)) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" id="welcome_note_input" name="welcome_note" value="">
                                            <a href="javascript:void(0);" class="btn btn-light" data-bs-dismiss="modal">Close</a>
                                            <input type="submit"class="btn btn-success" value="Approve" onclick="$(this).parents('form').submit()" id="approvebtn">
                                            
                                        </form>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Suspend Modal -->
                <div id="suspendModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="myModalLabel">Suspend Account</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
                            </div>
                            <form action="{{ url('/user/verify/account/suspend/'.encrypt($user->id)) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <textarea required class="form-control" name="suspension_reason" cols="30" rows="3" placeholder="Enter the reason why user account got suspended."></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-danger">Suspend</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- </form> --}}
@endsection

@section('script')
<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<!-- Modal JS -->
<script src="{{ URL::asset('assets/js/pages/modal.init.js') }}"></script>
<!-- App JS -->
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
<script>

$('#welcome_note_input').val($('#welcome_note').val());


    $('#welcome_note').change(function(){
    $('#welcome_note_input').val($(this).val());
})
</script>
@endsection