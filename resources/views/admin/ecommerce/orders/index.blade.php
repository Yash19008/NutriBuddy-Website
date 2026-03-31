@extends('layout.layout')
@php
    $title = 'Orders';
    $subTitle = 'Ecommerce / Orders';
@endphp

@section('content')
    @include('admin.ecommerce._messages')

    <div class="card mb-24">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.ecommerce.orders.index') }}" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label">Filter by Status</label>
                    <select name="status" class="form-select">
                        <option value="">All</option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status }}" {{ $selectedStatus === $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary" type="submit">Apply</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Order List</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table bordered-table mb-0">
                    <thead>
                        <tr>
                            <th>Order</th>
                            <th>Customer</th>
                            <th>Placed</th>
                            <th>Status</th>
                            <th>Payment</th>
                            <th>Total</th>
                            <th>Items</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                            <tr>
                                <td>#{{ $order->order_number }}</td>
                                <td>
                                    <div>{{ $order->customer_name }}</div>
                                    <small>{{ $order->customer_phone }}</small>
                                </td>
                                <td>{{ optional($order->placed_at)->format('d M Y H:i') ?? $order->created_at->format('d M Y H:i') }}</td>
                                <td>{{ ucfirst($order->status) }}</td>
                                <td>{{ ucfirst($order->payment_status) }} ({{ strtoupper($order->payment_method) }})</td>
                                <td>INR {{ number_format((float) $order->grand_total, 2) }}</td>
                                <td>{{ $order->items_count }}</td>
                                <td class="text-end">
                                    <a href="{{ route('admin.ecommerce.orders.show', $order) }}" class="btn btn-sm btn-primary">View</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No orders found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-16">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
@endsection
