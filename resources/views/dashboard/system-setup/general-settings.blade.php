@extends('layouts.master')
@section('title') @lang('translation.general-settings') @endsection

@section('css')
<!-- Select2 css-->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<!-- Breadcrumb Trail -->
@component('components.breadcrumb')
@slot('li_1')
    @lang('translation.general-settings')
@endslot
@slot('title')
    @lang('translation.general-settings')
@endslot
@endcomponent

<!-- Session Messages -->
@include('partials.session')

<!-- Add Form -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <form method="POST" action="{{ url('/system-setup/general-settings/store') }}" enctype="multipart/form-data">
                        @csrf
                        
                            <div class="col-md-6 form-group mb-3">
                                <label for="Description" class="form-label">Default Welcome Note</label>
                                <select name="default_welcome_note" class="form-control">
                                    @foreach($welcome_notes as $welcome_note)
                                        <option value="{{$welcome_note->note}}" @selected($welcome_note->note == get_settings('default_welcome_note'))>{{ mb_strimwidth($welcome_note->note, 0, 50, "...") }}</option>
                                    @endforeach
                                    
                                </select>
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label for="Description" class="form-label">Nowpayments API Key</label>
                                <input type="text" class="form-control" name="nowpayments_api_key" value="{{get_settings('nowpayments_api_key')}}">
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <img src="/{{get_settings('chat_background_image')}}" alt="Chat Background" srcset="" height="200px" width="200px">
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="Description" class="form-label">Chat Background</label>
                                <input type="file" class="form-control" name="chat_background">
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group mb-3">
                                    <label for="Description" class="form-label">Email Body For User Account Verification</label>
                                    <textarea name="email_for_account_verification" class="form-control nicEdit" id="email_for_account_verification" cols="30" rows="7">{{get_settings('email_for_account_verification')}}</textarea>
                                </div>
                                <div class="col-md-6 form-group mb-3">
                                    <label for="Description" class="form-label">Email Body For new Incomming Message</label>
                                    <textarea name="email_for_new_incomming_message" class="form-control nicEdit" id="email_for_new_incomming_message" cols="30" rows="7">{{get_settings('email_for_new_incomming_message')}}</textarea>
                                </div>    
                            </div>

                            <div class="col-md-12 form-group mb-2">
                                <input type="submit" class="btn btn-success btn-sm">
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