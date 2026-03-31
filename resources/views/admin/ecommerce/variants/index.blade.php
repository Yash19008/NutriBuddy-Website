@extends('layout.layout')
@php
    $title = 'Product Variants';
    $subTitle = 'Ecommerce / Variants';
@endphp

@section('content')
    @include('admin.ecommerce._messages')

    <div class="card mb-24">
        <div class="card-header">
            <h5 class="card-title mb-0">Create Variant</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.ecommerce.variants.store') }}" class="row g-3">
                @csrf
                <div class="col-md-3">
                    <label class="form-label">Product</label>
                    <select name="product_id" class="form-select" required>
                        <option value="">Select Product</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Variant Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">SKU</label>
                    <input type="text" name="sku" class="form-control" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Price (INR)</label>
                    <input type="number" name="price" class="form-control" min="0" step="0.01" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Attributes (JSON)</label>
                    <input type="text" name="attributes" class="form-control" placeholder='{"flavor":"Mango","pack":"30"}'>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Stock Qty</label>
                    <input type="number" name="stock_qty" class="form-control" min="0" value="0">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <div class="form-check me-3">
                        <input class="form-check-input" type="checkbox" value="1" name="is_default">
                        <label class="form-check-label">Default</label>
                    </div>
                    <div class="form-check me-3">
                        <input class="form-check-input" type="checkbox" value="1" name="is_active" checked>
                        <label class="form-check-label">Active</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" name="is_in_stock" checked>
                        <label class="form-check-label">In Stock</label>
                    </div>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Create Variant</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Variant List</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table bordered-table mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Product</th>
                            <th>Variant</th>
                            <th>SKU</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($variants as $variant)
                            <tr>
                                <td>{{ $variant->id }}</td>
                                <td>{{ $variant->product?->name ?? '—' }}</td>
                                <td>{{ $variant->name }}</td>
                                <td>{{ $variant->sku }}</td>
                                <td>INR {{ number_format((float) $variant->price, 2) }}</td>
                                <td>{{ $variant->inventory?->stock_qty ?? 0 }}</td>
                                <td>
                                    {{ $variant->is_active ? 'Active' : 'Inactive' }}
                                    @if ($variant->is_default)
                                        / Default
                                    @endif
                                </td>
                                <td class="text-end">
                                    <form method="POST" action="{{ route('admin.ecommerce.variants.update', $variant) }}" class="d-inline-flex gap-8 align-items-center me-8">
                                        @csrf
                                        @method('PUT')
                                        <input type="text" name="name" value="{{ $variant->name }}" class="form-control form-control-sm" style="width: 130px" required>
                                        <input type="text" name="sku" value="{{ $variant->sku }}" class="form-control form-control-sm" style="width: 120px" required>
                                        <input type="number" step="0.01" min="0" name="price" value="{{ $variant->price }}" class="form-control form-control-sm" style="width: 90px" required>
                                        <input type="text" name="attributes" value="{{ $variant->attributes ? json_encode($variant->attributes) : '' }}" class="form-control form-control-sm" style="width: 160px">
                                        <input type="hidden" name="is_default" value="0">
                                        <input type="checkbox" name="is_default" value="1" {{ $variant->is_default ? 'checked' : '' }}>
                                        <input type="hidden" name="is_active" value="0">
                                        <input type="checkbox" name="is_active" value="1" {{ $variant->is_active ? 'checked' : '' }}>
                                        <button type="submit" class="btn btn-sm btn-success">Save</button>
                                    </form>

                                    <form method="POST" action="{{ route('admin.ecommerce.variants.inventory.update', $variant) }}" class="d-inline-flex gap-8 align-items-center me-8">
                                        @csrf
                                        @method('PATCH')
                                        <input type="number" name="stock_qty" value="{{ $variant->inventory?->stock_qty ?? 0 }}" class="form-control form-control-sm" style="width: 90px" min="0" required>
                                        <input type="number" name="reserved_qty" value="{{ $variant->inventory?->reserved_qty ?? 0 }}" class="form-control form-control-sm" style="width: 90px" min="0">
                                        <input type="number" name="low_stock_threshold" value="{{ $variant->inventory?->low_stock_threshold ?? 5 }}" class="form-control form-control-sm" style="width: 90px" min="0">
                                        <input type="hidden" name="track_stock" value="0">
                                        <input type="checkbox" name="track_stock" value="1" {{ ($variant->inventory?->track_stock ?? true) ? 'checked' : '' }}>
                                        <input type="hidden" name="is_in_stock" value="0">
                                        <input type="checkbox" name="is_in_stock" value="1" {{ ($variant->inventory?->is_in_stock ?? true) ? 'checked' : '' }}>
                                        <button type="submit" class="btn btn-sm btn-primary">Stock</button>
                                    </form>

                                    <form method="POST" action="{{ route('admin.ecommerce.variants.destroy', $variant) }}" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this variant?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No variants found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-16">
                {{ $variants->links() }}
            </div>
        </div>
    </div>
@endsection
