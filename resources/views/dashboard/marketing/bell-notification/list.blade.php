@extends('layouts.master')
@section('title') @lang('translation.notifications') @endsection

@section('css')
<!--Datatable CSS-->
<link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
<!--Datatable Responsive CSS -->
<link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')

<!-- Breadcrumb Trail -->
@component('components.breadcrumb')
@slot('li_1')
    @lang('translation.notifications')
@endslot
@slot('title')
    @lang('translation.list')
@endslot
@endcomponent

<!-- Session Messages -->
@include('partials.session')

<!-- Datatable Start -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h1 class="card-title mb-0" style="width:50%;float:left">Notification List</h1>
                <!-- Add Button -->
                @can('Add Template')
                    <a href="{{ url('marketing/bell-notifications/add') }}" class="btn btn-primary btn-sm" style="float:right;">Add Notification</a>
                @endcan
            </div>
            <div class="card-body">
                <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center">Notification</th>
                            <th class="text-center">Duration</th>
                            <th class="text-center">Useage Count</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bellNotifications as $serial => $bellNotification)
                            <tr>
                                <td class="text-center">{{ $bellNotification->messages }}</td>
                                <td style="white-space: normal;" class="text-center">{{ $bellNotification->duration ? \Carbon\Carbon::parse($bellNotification->duration)->format('d-m-Y g:i A') : 'Not Used Yet' }}</td>
                                <td style="white-space: normal;" class="text-center">{{$bellNotification->useage_count}}</td>
                                <!-- Action Button -->
                                <td style="white-space: normal !important;" class="text-center">
                                        @canany(['Edit Template', 'Delete Template', 'Preview Template'])
                                            <div class="dropdown d-inline-block">
                                                <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ri-more-fill align-middle"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    @can('Preview Template')
                                                    <li>
                                                        <a href="{{ url('/marketing/bell-notifications/preview/'.$bellNotification->id) }}" class="dropdown-item edit-item-btn preview"><i class="ri-eye-fill align-bottom me-2 text-muted"></i> Preview</a>
                                                    </li>
                                                    @endcan
                                                    <!-- Edit Button -->
                                                    @can('Edit Template')
                                                        <li>
                                                            <a href="{{ url('/marketing/bell-notifications/edit/'.$bellNotification->id) }}" class="dropdown-item edit-item-btn"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a>
                                                        </li>
                                                    @endcan
                                                    <!-- Delete Button -->
                                                    @can('Delete Template')
                                                        <li>
                                                             <a type="button" class="dropdown-item remove-item-btn" onclick="ShowDeleteModal('{{$bellNotification->id}}')"><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete</a>
                                                        </li>
                                                    @endcan
                                                </ul>
                                            </div>
                                        @endcanany
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- Delete Modal -->
                <div id="DeleteModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-body text-center p-5">
                                <lord-icon src="https://cdn.lordicon.com/hrqwmuhr.json" trigger="loop"
                                    colors="primary:#121331,secondary:#08a88a" style="width:120px;height:120px">
                                </lord-icon>
                                <div class="mt-4">
                                    <h4 class="mb-3">Confirm your action!</h4>
                                    <p class="text-muted mb-4"><strong>Are you sure you want to delete this Template?</strong></p>
                                    <div class="hstack gap-2 justify-content-center">
                                        <button type="button" class="btn btn-light"
                                            data-bs-dismiss="modal">Close</button>
                                        <a id="DeleteModalHref" href="{{ url('https://google.com') }}" class="btn btn-danger">Confirm</a>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<!-- Data Table JS -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="{{ URL::asset('assets/js/pages/datatables.init.js') }}"></script>
<!-- Modal JS -->
<script src="{{ URL::asset('assets/js/pages/modal.init.js') }}"></script>
<!-- App JS -->
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
<!-- Custom JS -->
<script>
    function ShowDeleteModal(id){
        $('#DeleteModalHref').attr('href', '/marketing/bell-notifications/delete/'+id);
        $('#DeleteModal').modal('show');
    }
</script>
@endsection