@extends('layouts.master')
@section('title') @lang('translation.notifications') @endsection

@section('css')
<!-- Select2 css-->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<!-- Breadcrumb Trail -->
@component('components.breadcrumb')
@slot('li_1')
    @lang('translation.notifications')
@endslot
@slot('title')
    @lang('translation.edit')
@endslot
@endcomponent

<!-- Session Messages -->
@include('partials.session')

<!-- Add Form -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h1 class="card-title mb-0">Edit Template</h1>
            </div>
            <div class="card-body">
                <div class="row">
                    <form method="POST" action="{{ url('/marketing/templates/update/'.$template->id) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="Name" class="form-label">Subject</label>
                                <input required type="text" class="form-control" name="subject" value="{{$template->subject}}" placeholder="Email Subject">
                            </div>

                            <div class="col-md-12 form-group mb-3">
                                <label for="Description" class="form-label">Body</label>
                                <textarea name="email_body" class="form-control nicEdit"  rows="10" placeholder="Email Body">{{$template->body}}</textarea>
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
</script>

@endsection