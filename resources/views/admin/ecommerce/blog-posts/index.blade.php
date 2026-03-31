@extends('layout.layout')
@php
    $title = 'Blog Posts';
    $subTitle = 'Ecommerce / Blog Posts';
@endphp

@section('content')
    @include('admin.ecommerce._messages')

    <div class="card mb-24">
        <div class="card-header">
            <h5 class="card-title mb-0">Create Blog Post</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.ecommerce.blog-posts.store') }}" class="row g-3">
                @csrf
                <div class="col-md-4">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Category</label>
                    <select name="blog_category_id" class="form-select">
                        <option value="">Select</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Author</label>
                    <select name="author_id" class="form-select">
                        <option value="">Select</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select" required>
                        <option value="draft">Draft</option>
                        <option value="published">Published</option>
                        <option value="archived">Archived</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <label class="form-label">Slug</label>
                    <input type="text" name="slug" class="form-control">
                </div>
                <div class="col-12">
                    <label class="form-label">Excerpt</label>
                    <textarea name="excerpt" class="form-control" rows="2"></textarea>
                </div>
                <div class="col-12">
                    <label class="form-label">Content</label>
                    <textarea name="content" class="form-control" rows="5" required></textarea>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Create Post</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header"><h5 class="card-title mb-0">Post List</h5></div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table bordered-table mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Author</th>
                            <th>Status</th>
                            <th>Published</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($posts as $post)
                            <tr>
                                <td>{{ $post->id }}</td>
                                <td>{{ $post->title }}</td>
                                <td>{{ $post->category?->name ?? '—' }}</td>
                                <td>{{ $post->author?->name ?? '—' }}</td>
                                <td>{{ ucfirst($post->status) }}</td>
                                <td>{{ $post->published_at?->format('d M Y') ?? '—' }}</td>
                                <td class="text-end">
                                    <form method="POST" action="{{ route('admin.ecommerce.blog-posts.update', $post) }}" class="d-inline-flex gap-8 align-items-center me-8">
                                        @csrf
                                        @method('PUT')
                                        <input type="text" name="title" value="{{ $post->title }}" class="form-control form-control-sm" style="width: 170px" required>
                                        <input type="hidden" name="slug" value="{{ $post->slug }}">
                                        <input type="hidden" name="excerpt" value="{{ $post->excerpt }}">
                                        <input type="hidden" name="content" value="{{ $post->content }}">
                                        <input type="hidden" name="blog_category_id" value="{{ $post->blog_category_id }}">
                                        <input type="hidden" name="author_id" value="{{ $post->author_id }}">
                                        <select name="status" class="form-select form-select-sm" style="width: 120px">
                                            <option value="draft" {{ $post->status === 'draft' ? 'selected' : '' }}>Draft</option>
                                            <option value="published" {{ $post->status === 'published' ? 'selected' : '' }}>Published</option>
                                            <option value="archived" {{ $post->status === 'archived' ? 'selected' : '' }}>Archived</option>
                                        </select>
                                        <button type="submit" class="btn btn-sm btn-success">Save</button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.ecommerce.blog-posts.destroy', $post) }}" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this post?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No blog posts found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-16">{{ $posts->links() }}</div>
        </div>
    </div>
@endsection
