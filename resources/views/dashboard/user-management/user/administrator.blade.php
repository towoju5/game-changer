@extends('layouts.master')
@section('title') @lang('translation.admin-structure') @endsection

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
    @lang('translation.admin-structure')
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
                <h1 class="card-title mb-0" style="width:50%;float:left">Admin Structure</h1>
                <!-- Add Button -->
                @can('Add User')
                    {{-- <a href="{{ url('user/add') }}" class="btn btn-primary btn-sm" style="float:right;">Add User</a> --}}
                @endcan
            </div>
            <div class="card-body">
                <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center">ID</th>
                            <th class="text-center">Username</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Balance (USD)</th>
                            <th class="text-center">Register Date</th>
                            <th class="text-center">Last Login</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $serial => $user)
                            <tr>
                                <td class="text-center">{{ '110'.$user->id }}</td>
                                <td class="text-center">{{ $user->username ?? 'N/A' }}</td>
                                <td class="text-center">{{ $user->first_name.' '.$user->last_name }}</td>
                                <td class="text-center">{{ $user->balance != 0 ? (float)$user->balance : '0.00' }}</td>

                                <td class="text-center">{{ \Carbon\Carbon::parse($user->email_verified_at)->format('d-M-Y') }}</td>
                                <td class="text-center">{{ \Carbon\Carbon::parse($user->last_login)->format('d-M-Y h:i A') }}</td>
                                <td class="text-center">{{ $user->account_verification }}</td>

                                <!-- Action Button -->
                                <td style="white-space: normal !important;" class="text-center">
                                    <div class="dropdown d-inline-block">
                                        <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ri-more-fill align-middle"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <!-- Admin Recharge -->
                                            @can('Admin Balance')
                                                <li>
                                                    <a type="button" class="dropdown-item remove-item-btn" onclick="ShowBalanceModal({{@$user->virtualGoods()}})"><i class="ri-wallet-3-line align-bottom me-2 text-muted"></i> Balance</a>
                                                </li>
                                            @endcan
                                        </ul>
                                    </div> 
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- Delete Modal -->
                <div id="BalanceModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-body">
                                <form method="POST" action="{{ route('change.balance') }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-4"><h4 class="mb-3">Name</h4></div>
                                        <div class="col-4"><h4 class="mb-3">Balance</h4></div>
                                        <div class="col-4"><h4 class="mb-3">Add/Sub</h4></div>
                                    </div>

                                    @foreach($digitalAssets as $digitalAsset)
                                        <div class="row">
                                            <div class="col-3 p-1">{{$digitalAsset->name}}</div>
                                            <div class="col-4 p-1"><h4 style="color: orangered; text-align: center;" class="asset_balance asset_balance_{{$digitalAsset->id}}">1</h4> </div>
                                            <div class="col-4"><input type="number" class="form-control" name="{{$digitalAsset->name}}"> </div>
                                        </div>
                                    @endforeach
                                    <div class="hstack pt-4 gap-2 justify-content-end">
                                        <button type="button" class="btn btn-light"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" id="BalanceModalHref" class="btn btn-danger">Confirm</a>
                                    </div>
                                </form>
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
    function ShowBalanceModal(wallet){
        $('.asset_balance').text(0.00);

        wallet.forEach(element => {
            $('.asset_balance_'+element.asset_id).text(element.value);
        });
        
        // $('.asset_balance_'+wallet.asset_id).forEach(element => {
        //     element.text(wallet.value);
        // });
      //  $('#BalanceModalHref').attr('href', '/user/delete/'+id);
        $('#BalanceModal').modal('show');
    }
</script>
@endsection