@extends('layouts.master')
@section('title') @lang('translation.notifications') @endsection

@section('css')
<!-- Select2 css-->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="{{ URL::asset('/assets/css/datepicker.min.css') }}">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
@endsection

@section('content')
<!-- Breadcrumb Trail -->
@component('components.breadcrumb')
@slot('li_1')
    @lang('translation.notifications')
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
                <h1 class="card-title mb-0">Add Notification</h1>
            </div>
            <div class="card-body">
                <div class="row">
                    <form method="POST" action="{{ url('/marketing/bell-notifications/store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">

                            <div class="col-md-12 form-group mb-3">
                                <label for="notification-body" class="form-label">Notification Body</label>
                                <textarea name="message_body" class="form-control"  rows="6" id="notification-body" placeholder="Notification Body"></textarea>
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="duration" class="form-label">Duration Day</label>
                                <input type="text" class="form-control datepicker-here" name="duration_day" id="myDatePicker">
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="myTimePicker" class="form-label">Duration Time</label>
                                <input type="text" class="form-control timepicker" name="duration_time" id="myTimePicker">
                            </div>
                            <div class="col-md-12 form-group mb-2">
                                <a style="margin-right:3px;" href="{{ url('marketing/templates/list') }}" class="btn btn-danger btn-sm">Cancel</a>
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
<script src="{{ URL::asset('/assets/js/nicEdit.js') }}"></script>
<script src="{{ URL::asset('/assets/js/datepicker.min.js') }}"></script>
<script src="{{ URL::asset('/assets/js/datepicker.en.js') }}"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
<script>
// bkLib.onDomLoaded(function() {
    $( ".nicEdit" ).each(function( index ) {
        $(this).attr("id","nicEditor"+index);
        new nicEditor({fullPanel : true}).panelInstance('nicEditor'+index,{hasPanel : true});
    });
// });
(function($){
    $( document ).on('mouseover ', '.nicEdit-main,.nicEdit-panelContain',function(){
        $('.nicEdit-main').focus();
    });
})(jQuery);

$(document).ready(function(){

    if(!$('.datepicker-here').val()){
            $('.datepicker-here').datepicker();
        }

});

$('.timepicker').timepicker({
    timeFormat: 'h:mm p',
    interval: 30,
    dynamic: false,
    dropdown: true,
    scrollbar: false
});
</script>

@endsection