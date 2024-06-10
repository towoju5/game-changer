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
    @lang('translation.preview')
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
                        
                        <div class="row">
                            <form action="" class="notify-form">
                            
                                @csrf
                                <div class="col-md-12 mb-3">
                                    <label for="Name" class="form-label" >Subject</label>
                                    <input required type="text" class="form-control" disabled name="subject" value="{{$template->subject}}" placeholder="Email Subject">
                                </div>

                                <div class="col-md-12 form-group mb-3">
                                    <label for="Description" class="form-label">Body</label>
                                    <textarea name="email_body" disabled class="form-control nicEdit"  rows="10" placeholder="Email Body">{{$template->body}}</textarea>
                                </div>
                                <div class="col-md-12 form-group mb-2">
                                    <button class="sendnow btn btn-success btn-sm">Send Now</button>
                                </div>                                
                          </form>

                        </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" data-bs-backdrop="static" id="notificationSending">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Notification Sending')</h5>
            </div>
            <div class="modal-body">
                <h4 class="text--danger text-center">@lang('Don\'t close or refresh the window till finish')</h4>
                <div class="mail-wrapper">
                    <div class= "mail-icon world-icon"><i class="las la-globe"></i></div>
                    <div class='mailsent'>
                        <div class='envelope'>
                            <i class='line line1'></i>
                            <i class='line line2'></i>
                            <i class='line line3'></i>
                            <i class="icon ri-mail-line"></i>
                        </div>
                    </div>
                    <div class= "mail-icon mail-icon"><i class="las la-envelope-open-text"></i></div>
                </div>
                <div class="mt-3">
                    <div class="progress">
                        <div class="progress-bar" style="width: 0%"></div>
                    </div>
                    <p>@lang('Email sent') <span class="sent">0</span> @lang('users out of') {{ $users->count() }} @lang('users')</p>
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
jQuery('.nicEdit-main').attr('contenteditable','false');
jQuery('.nicEdit-panel').hide();
</script>
<script>
    (function($){
        
        $.ajaxSetup({
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        $('.notify-form').on('submit',function(e){
            if({{ $users->count() }} <= 0){
                notify('error','Users not found');
                return false;
            }
            e.preventDefault();
            $('.progress-bar').css('width', `0%`);
            $('.progress-bar').text(`0%`);
            $('.sent').text(0);
            $('#notificationSending').modal('show');
            postMail($(this),0);
        });

        function postMail(form,skip){

            var _token = form.find('[name=_token]').val();
            var subject = form.find('[name=subject]').val();
            var message = form.find('[name=email_body]').html();

            $.post("{{ route('send.notification.toall') }}", {
                "skip":skip,
                "template_id": {{$template->id}},
            },function (response) {
                if(response.error){
                    response.error.forEach(error => {
                        notify('error',error)
                        $('.sent').text(response.total_sent);
                    });
                }else{
                   
                    var rest =  {{ $users->count() }} - response.total_sent;
                    var sentPercent = response.total_sent / {{ $users->count() }} * 100;
                    if (sentPercent > 100) {
                        sentPercent = 100;
                    }
                    sentPercent = sentPercent.toFixed(0)
                     
                    $('.progress-bar').css('width', `${sentPercent}%`);
                    $('.progress-bar').text(`${sentPercent}%`);
                    $('.sent').text(response.total_sent);
                    if(rest == 0){
                        setTimeout(() => {
                            $('#notificationSending').modal('hide');
                            // form.find('[name=subject]').val('');
                            // form.find('.nicEdit-main').html('<span></span>');
                            notify('success','Mail sent to all users successfully')
                        }, 3000);
                        return false;
                    }
                    setTimeout(()=>{
                        postMail(form,response.total_sent);
                    },1000);
                }
            });
        }

    })(jQuery);
</script>
@endsection