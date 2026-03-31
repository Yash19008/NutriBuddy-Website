@extends('layout.layout')
@php
    $title = 'Coupons';
    $subTitle = 'Ecommerce / Coupons';
@endphp

@section('content')
    @include('admin.ecommerce._messages')

    <div class="card mb-24">
        <div class="card-header">
            <h5 class="card-title mb-0">Create Coupon</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.ecommerce.coupons.store') }}" class="row g-3">
                @csrf
                <div class="col-md-2">
                    <label class="form-label">Code</label>
                    <input type="text" name="code" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Type</label>
                    <select name="discount_type" class="form-select" required>
                        <option value="percentage">Percentage</option>
                        <option value="flat">Flat</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Value</label>
                    <input type="number" step="0.01" min="0" name="discount_value" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Min Order Amount</label>
                    <input type="number" step="0.01" min="0" name="min_order_amount" class="form-control">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Max Discount</label>
                    <input type="number" step="0.01" min="0" name="max_discount_amount" class="form-control">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Usage Limit</label>
                    <input type="number" min="1" name="usage_limit" class="form-control">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Per User Limit</label>
                    <input type="number" min="1" name="usage_limit_per_user" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Starts At</label>
                    <input type="datetime-local" name="starts_at" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Ends At</label>
                    <input type="datetime-local" name="ends_at" class="form-control">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" value="1" name="is_active" checked>
                        <label class="form-check-label">Active</label>
                    </div>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Create Coupon</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Coupon List</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table bordered-table mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Code</th>
                            <th>Type</th>
                            <th>Value</th>
                            <th>Usage</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($coupons as $coupon)
                            <tr>
                                <td>{{ $coupon->id }}</td>
                                <td>{{ $coupon->code }}</td>
                                <td>{{ ucfirst($coupon->discount_type) }}</td>
                                <td>{{ $coupon->discount_value }}</td>
                                <td>{{ $coupon->used_count }} / {{ $coupon->usage_limit ?? '∞' }}</td>
                                <td>{{ $coupon->is_active ? 'Active' : 'Inactive' }}</td>
                                <td class="text-end">
                                    <form method="POST" action="{{ route('admin.ecommerce.coupons.update', $coupon) }}" class="d-inline-flex gap-8 align-items-center me-8">
                                        @csrf
                                        @method('PUT')
                                        <input type="text" name="code" value="{{ $coupon->code }}" class="form-control form-control-sm" style="width: 110px" required>
                                        <select name="discount_type" class="form-select form-select-sm" style="width: 120px" required>
                                            <option value="percentage" {{ $coupon->discount_type === 'percentage' ? 'selected' : '' }}>Percentage</option>
                                            <option value="flat" {{ $coupon->discount_type === 'flat' ? 'selected' : '' }}>Flat</option>
                                        </select>
                                        <input type="number" step="0.01" min="0" name="discount_value" value="{{ $coupon->discount_value }}" class="form-control form-control-sm" style="width: 100px" required>
                                        <input type="hidden" name="is_active" value="0">
                                        <input type="checkbox" name="is_active" value="1" {{ $coupon->is_active ? 'checked' : '' }}>
                                        <button type="submit" class="btn btn-sm btn-success">Save</button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.ecommerce.coupons.destroy', $coupon) }}" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this coupon?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No coupons found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-16">
                {{ $coupons->links() }}
            </div>
        </div>
    </div>
@endsection
