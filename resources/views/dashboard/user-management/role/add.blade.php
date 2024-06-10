@extends('layouts.master')
@section('title') @lang('translation.roles') @endsection

@section('css')
<!-- Select2 css-->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<!-- Breadcrumb Trail -->
@component('components.breadcrumb')
@slot('li_1')
    @lang('translation.roles')
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
                <h1 class="card-title mb-0">Add Role</h1>
            </div>
            <div class="card-body">
                <div class="row">
                    <form method="POST" action="{{ url('/role/store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="Name" class="form-label">Name</label>
                                <input required type="text" class="form-control" name="name" placeholder="Manager">
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="Permissions" class="form-label">Permissions</label>
                                <select class="js-example-basic-multiple" name="permissions[]" multiple="multiple">                          
                                    @foreach ($permissions as $permission)
                                        <option>{{ $permission->name }}</option>    
                                    @endforeach                                          
                                </select>
                            </div>

                            <div class="col-md-12 form-group mb-3">
                                <label for="Description" class="form-label">Description</label>
                                <textarea required class="form-control" name="description" rows="2" placeholder="This role is for Managers."></textarea>
                            </div>

                            <div class="col-md-12 form-group mb-2">
                                <a style="margin-right:3px;" href="{{ url('role/list') }}" class="btn btn-danger btn-sm">Cancel</a>
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