@extends('layout.layout')
@php
    $title = 'Tax Rates';
    $subTitle = 'Ecommerce / Tax Rates';
@endphp

@section('content')
    @include('admin.ecommerce._messages')

    <div class="card mb-24">
        <div class="card-header">
            <h5 class="card-title mb-0">Create Tax Rate</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.ecommerce.tax-rates.store') }}" class="row g-3">
                @csrf
                <div class="col-md-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Code</label>
                    <input type="text" name="code" class="form-control" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Rate (%)</label>
                    <input type="number" step="0.01" min="0" max="100" name="rate" class="form-control" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Sort Order</label>
                    <input type="number" min="0" name="sort_order" value="0" class="form-control">
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" value="1" name="is_active" checked>
                        <label class="form-check-label">Active</label>
                    </div>
                </div>
                <div class="col-12">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="2"></textarea>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Create Tax Rate</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Tax Rate List</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table bordered-table mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Code</th>
                            <th>Rate</th>
                            <th>Sort</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($taxRates as $taxRate)
                            <tr>
                                <td>{{ $taxRate->id }}</td>
                                <td>{{ $taxRate->name }}</td>
                                <td>{{ $taxRate->code }}</td>
                                <td>{{ $taxRate->rate }}%</td>
                                <td>{{ $taxRate->sort_order }}</td>
                                <td>{{ $taxRate->is_active ? 'Active' : 'Inactive' }}</td>
                                <td class="text-end">
                                    <form method="POST" action="{{ route('admin.ecommerce.tax-rates.update', $taxRate) }}" class="d-inline-flex gap-8 align-items-center me-8">
                                        @csrf
                                        @method('PUT')
                                        <input type="text" name="name" value="{{ $taxRate->name }}" class="form-control form-control-sm" style="width: 140px" required>
                                        <input type="text" name="code" value="{{ $taxRate->code }}" class="form-control form-control-sm" style="width: 90px" required>
                                        <input type="number" step="0.01" min="0" max="100" name="rate" value="{{ $taxRate->rate }}" class="form-control form-control-sm" style="width: 90px" required>
                                        <input type="number" min="0" name="sort_order" value="{{ $taxRate->sort_order }}" class="form-control form-control-sm" style="width: 80px">
                                        <input type="hidden" name="is_active" value="0">
                                        <input type="checkbox" name="is_active" value="1" {{ $taxRate->is_active ? 'checked' : '' }}>
                                        <button type="submit" class="btn btn-sm btn-success">Save</button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.ecommerce.tax-rates.destroy', $taxRate) }}" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this tax rate?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No tax rates found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-16">
                {{ $taxRates->links() }}
            </div>
        </div>
    </div>
@endsection
