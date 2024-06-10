@extends('layouts.master')
@section('title') @lang('translation.wallet') @endsection
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
        @lang('translation.digital-assets')
    @endslot
    @slot('title')
        @lang('translation.balance')
    @endslot
@endcomponent

<!-- Session Messages -->
@include('partials.session')

    <!-- Digital Assets Balance -->
    <div class="row">
        <!-- Doller -->
        <div class="col-xxl-3 col-md-6">
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex mb-4">
                        <div class="flex-grow-1">
                            <img style="width:80px;height:80px" src="{{ asset('assets/digital_assets/wallet.png') }}">
                        </div>
                    </div>
                    <h3 class="mb-4">$ <span class="counter-value" data-target="{{auth()->user()->balance}}">0</span></h3>
                    <h6 class="text-muted mb-0">Total Available</h6>
                </div>
            </div>
        </div>
        <!-- Deposit -->
        <div class="col-xxl-3 col-md-6">
            <div class="card card-animate">
                <div class="card-body">
                    <form action="{{route('deposit')}}" method="post">
                        @csrf
                        <div class="d-flex mb-1">
                            <div class="flex-grow-1">
                                <h3>Deposit now</h3>
                            </div>
                        </div>
                        <input type="number" name="amount" class="form-control" placeholder="Amount" required>
                        <select name="payment_type" name="payment_type" class="form-control mt-2" required id="payment_type">
                            <option value="" selected disabled>Select Payment Type</option>
                            <option value="crypto">Crypto</option>
                        </select>
                        <button type="submit" class="btn btn-primary mt-2">Deposit</button>                        
                    </form>
                </div>
            </div>
        </div>
    </div>

<!-- Datatable Start -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h1 class="card-title mb-0" style="width:50%;float:left">Latest Deposits</h1>
            </div>
            <div class="card-body">
                <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                    <thead>
                        <tr>
                             <th class="text-center">UID</th>
                            <th class="text-center">TRX</th>
                            <th class="text-center">Amount</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $serial => $transaction)
                            <tr>
                                <td class="text-center">{{ $transaction->id }}</td>
                                <td class="text-center">{{ $transaction->trx }}</td>
                                <td class="text-center">{{ (float)$transaction->amount }}</td>
                                <td class="text-center">
                                @if($transaction->status == 0)
                                    Initiated
                                @elseif($transaction->status == 1)
                                    Succeed
                                @endif
                                </td>
                                <td class="text-center">{{ $transaction->details }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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
<script src="{{ URL::asset('assets/js/pages/datatables.init.js') }}"></script>
<!-- App JS -->
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
<script>
$('#example').DataTable({order:[[1,"desc"]]});
</script>
<!-- Custom JS -->

@endsection