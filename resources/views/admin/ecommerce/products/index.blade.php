@extends('layout.layout')
@php
    $title = 'Products';
    $subTitle = 'Ecommerce / Products';
@endphp

@section('content')
    @include('admin.ecommerce._messages')

    <div class="card mb-24">
        <div class="card-header">
            <h5 class="card-title mb-0">Create Product</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.ecommerce.products.store') }}" class="row g-3">
                @csrf
                <div class="col-md-4">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">SKU</label>
                    <input type="text" name="sku" class="form-control" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Type</label>
                    <select name="product_type" class="form-select" required>
                        <option value="simple">Simple</option>
                        <option value="variable">Variable</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Base Price (INR)</label>
                    <input type="number" step="0.01" min="0" name="base_price" class="form-control" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Brand</label>
                    <input type="text" name="brand" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Category</label>
                    <select name="category_id" class="form-select">
                        <option value="">Select</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tax Rate</label>
                    <select name="tax_rate_id" class="form-select">
                        <option value="">Select</option>
                        @foreach ($taxRates as $taxRate)
                            <option value="{{ $taxRate->id }}">{{ $taxRate->name }} ({{ $taxRate->rate }}%)</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">HSN Code</label>
                    <input type="text" name="hsn_code" class="form-control">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Slug (optional)</label>
                    <input type="text" name="slug" class="form-control">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <div class="form-check me-3">
                        <input class="form-check-input" type="checkbox" value="1" name="is_variant_enabled">
                        <label class="form-check-label">Variants Enabled</label>
                    </div>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <div class="form-check me-3">
                        <input class="form-check-input" type="checkbox" value="1" name="is_featured">
                        <label class="form-check-label">Featured</label>
                    </div>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <div class="form-check mb-0">
                        <input class="form-check-input" type="checkbox" value="1" name="is_active" checked>
                        <label class="form-check-label">Active</label>
                    </div>
                </div>
                <div class="col-12">
                    <label class="form-label">Short Description</label>
                    <textarea name="short_description" class="form-control" rows="2"></textarea>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Create Product</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Product List</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table bordered-table mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>SKU</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Variants</th>
                            <th>Inventory</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->sku }}</td>
                                <td>{{ $product->category?->name ?? '—' }}</td>
                                <td>INR {{ number_format((float) $product->base_price, 2) }}</td>
                                <td>{{ $product->is_variant_enabled ? 'Enabled' : 'Disabled' }} ({{ $product->variants->count() }})</td>
                                <td>{{ $product->inventory?->stock_qty ?? 0 }}</td>
                                <td>{{ $product->is_active ? 'Active' : 'Inactive' }}</td>
                                <td class="text-end">
                                    <form method="POST" action="{{ route('admin.ecommerce.products.update', $product) }}" class="d-inline-flex gap-8 align-items-center me-8">
                                        @csrf
                                        @method('PUT')
                                        <input type="text" name="name" value="{{ $product->name }}" class="form-control form-control-sm" style="width: 150px" required>
                                        <input type="text" name="sku" value="{{ $product->sku }}" class="form-control form-control-sm" style="width: 120px" required>
                                        <input type="number" step="0.01" min="0" name="base_price" value="{{ $product->base_price }}" class="form-control form-control-sm" style="width: 110px" required>
                                        <input type="hidden" name="slug" value="{{ $product->slug }}">
                                        <input type="hidden" name="product_type" value="{{ $product->product_type }}">
                                        <input type="hidden" name="category_id" value="{{ $product->category_id }}">
                                        <input type="hidden" name="tax_rate_id" value="{{ $product->tax_rate_id }}">
                                        <input type="hidden" name="is_variant_enabled" value="0">
                                        <input type="checkbox" name="is_variant_enabled" value="1" {{ $product->is_variant_enabled ? 'checked' : '' }}>
                                        <input type="hidden" name="is_active" value="0">
                                        <input type="checkbox" name="is_active" value="1" {{ $product->is_active ? 'checked' : '' }}>
                                        <button type="submit" class="btn btn-sm btn-success">Save</button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.ecommerce.products.inventory.update', $product) }}" class="d-inline-flex gap-8 align-items-center me-8">
                                        @csrf
                                        @method('PATCH')
                                        <input type="number" name="stock_qty" value="{{ $product->inventory?->stock_qty ?? 0 }}" class="form-control form-control-sm" style="width: 90px" min="0" required>
                                        <input type="hidden" name="reserved_qty" value="{{ $product->inventory?->reserved_qty ?? 0 }}">
                                        <input type="hidden" name="low_stock_threshold" value="{{ $product->inventory?->low_stock_threshold ?? 5 }}">
                                        <input type="hidden" name="track_stock" value="0">
                                        <input type="checkbox" name="track_stock" value="1" {{ ($product->inventory?->track_stock ?? true) ? 'checked' : '' }}>
                                        <input type="hidden" name="is_in_stock" value="0">
                                        <input type="checkbox" name="is_in_stock" value="1" {{ ($product->inventory?->is_in_stock ?? true) ? 'checked' : '' }}>
                                        <button type="submit" class="btn btn-sm btn-primary">Stock</button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.ecommerce.products.destroy', $product) }}" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this product?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">No products found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-16">
                {{ $products->links() }}
            </div>
        </div>
    </div>
@endsection
