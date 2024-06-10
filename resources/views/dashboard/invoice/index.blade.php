@extends('layouts.master')
@section('title')
    @lang('My Invoices')
@endsection

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('assets/libs/swiper/swiper.min.css') }}">
@endsection

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between mb-3">
        <h2>Invoices</h2>
        <a href="{{ route('invoice.create') }}" class="btn btn-primary mb-3">Create New Invoice</a>
    </div>
    <div class="table table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th class="whitespace-nowrap">Customer Name</th>
                    <th class="whitespace-nowrap">Customer Email</th>
                    <th>Total</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($invoices as $k => $invoice)
                    <tr>
                        <td>{{ $k + 1 }}</td>
                        <td>{{ $invoice->customer_name }}</td>
                        <td>{{ $invoice->customer_email }}</td>
                        <td>${{ number_format($invoice->total, 2) }}</td>
                        <td>
                            <a href="{{ route('invoice.show', $invoice) }}" class="btn btn-info btn-sm">View</a>
                            <form action="{{ route('invoice.destroy', $invoice) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm delete-button">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No Invoice found. Please create one to get started</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>



<script>
    document.querySelectorAll('.delete-button').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            Swal.fire({
                title: "Are you sure?",
                text: "Are you sure you want to delete this invoice?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    button.closest('form').submit();
                }
            });
        });
    });
</script>
@endsection