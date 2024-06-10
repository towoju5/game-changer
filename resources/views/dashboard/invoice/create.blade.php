@extends('layouts.master')
@section('title')
    @lang('Create Invoice')
@endsection

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('assets/libs/swiper/swiper.min.css') }}">
@endsection

@section('content')
<div class="container mt-5">
    <h2>Create Invoice</h2>
    <form action="{{ route('invoice.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="customer_name" class="form-label">Customer Name</label>
            <input type="text" class="form-control" id="customer_name" name="customer_name" required>
        </div>
        <div class="mb-3">
            <label for="customer_email" class="form-label">Customer Email</label>
            <input type="email" class="form-control" id="customer_email" name="customer_email" required>
        </div>
        <h4>Items</h4>
        <div id="items">
            <div class="item mb-3">
                <div class="row">
                    <div class="col">
                        <input type="text" class="form-control" name="items[0][description]" placeholder="Description" required>
                    </div>
                    <div class="col">
                        <input type="number" class="form-control" name="items[0][quantity]" placeholder="Quantity" required>
                    </div>
                    <div class="col">
                        <input type="number" class="form-control" name="items[0][price]" placeholder="Price" step="0.01" required>
                    </div>
                </div>
            </div>
        </div>
        <button type="button" id="addItem" class="btn btn-secondary">Add Item</button>
        <button type="submit" class="btn btn-primary">Create Invoice</button>
    </form>
</div>


<script>
    let itemCount = 1;
    $('#addItem').click(function () {
        $('#items').append(`
            <div class="item mb-3">
                <div class="row">
                    <div class="col">
                        <input type="text" class="form-control" name="items[${itemCount}][description]" placeholder="Description" required>
                    </div>
                    <div class="col">
                        <input type="number" class="form-control" name="items[${itemCount}][quantity]" placeholder="Quantity" required>
                    </div>
                    <div class="col">
                        <input type="number" class="form-control" name="items[${itemCount}][price]" placeholder="Price" step="0.01" required>
                    </div>
                </div>
            </div>
        `);
        itemCount++;
    });
</script>
@endsection