@extends('layout.layout')
@php
    $title = 'Blog Categories';
    $subTitle = 'Ecommerce / Blog Categories';
@endphp

@section('content')
    @include('admin.ecommerce._messages')

    <div class="card mb-24">
        <div class="card-header">
            <h5 class="card-title mb-0">Create Blog Category</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.ecommerce.blog-categories.store') }}" class="row g-3">
                @csrf
                <div class="col-md-4">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Slug (optional)</label>
                    <input type="text" name="slug" class="form-control">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" name="is_active" checked>
                        <label class="form-check-label">Active</label>
                    </div>
                </div>
                <div class="col-12">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="2"></textarea>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Create Category</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Category List</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table bordered-table mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Posts</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories as $category)
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->slug }}</td>
                                <td>{{ $category->posts_count }}</td>
                                <td>{{ $category->is_active ? 'Active' : 'Inactive' }}</td>
                                <td class="text-end">
                                    <form method="POST" action="{{ route('admin.ecommerce.blog-categories.update', $category) }}" class="d-inline-flex gap-8 align-items-center me-8">
                                        @csrf
                                        @method('PUT')
                                        <input type="text" name="name" value="{{ $category->name }}" class="form-control form-control-sm" style="width: 160px" required>
                                        <input type="text" name="slug" value="{{ $category->slug }}" class="form-control form-control-sm" style="width: 160px">
                                        <input type="hidden" name="is_active" value="0">
                                        <input type="checkbox" name="is_active" value="1" {{ $category->is_active ? 'checked' : '' }}>
                                        <button type="submit" class="btn btn-sm btn-success">Save</button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.ecommerce.blog-categories.destroy', $category) }}" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this category?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No blog categories found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-16">{{ $categories->links() }}</div>
        </div>
    </div>
@endsection
