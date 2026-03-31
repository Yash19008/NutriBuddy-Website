@extends('layout.layout')
@php
    $title = 'Newsletter Subscribers';
    $subTitle = 'Ecommerce / Newsletter';
@endphp

@section('content')
    @include('admin.ecommerce._messages')

    <div class="card mb-24">
        <div class="card-header"><h5 class="card-title mb-0">Add Subscriber</h5></div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.ecommerce.newsletter.store') }}" class="row g-3">
                @csrf
                <div class="col-md-4">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Source</label>
                    <input type="text" name="source" class="form-control" placeholder="website, popup, campaign">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select" required>
                        <option value="subscribed">Subscribed</option>
                        <option value="unsubscribed">Unsubscribed</option>
                    </select>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Add Subscriber</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header"><h5 class="card-title mb-0">Subscriber List</h5></div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table bordered-table mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Email</th>
                            <th>Name</th>
                            <th>Source</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($subscribers as $subscriber)
                            <tr>
                                <td>{{ $subscriber->id }}</td>
                                <td>{{ $subscriber->email }}</td>
                                <td>{{ $subscriber->name ?? '—' }}</td>
                                <td>{{ $subscriber->source ?? '—' }}</td>
                                <td>{{ ucfirst($subscriber->status) }}</td>
                                <td class="text-end">
                                    <form method="POST" action="{{ route('admin.ecommerce.newsletter.update', $subscriber) }}" class="d-inline-flex gap-8 align-items-center me-8">
                                        @csrf
                                        @method('PUT')
                                        <input type="text" name="name" value="{{ $subscriber->name }}" class="form-control form-control-sm" style="width: 120px">
                                        <input type="text" name="source" value="{{ $subscriber->source }}" class="form-control form-control-sm" style="width: 140px">
                                        <select name="status" class="form-select form-select-sm" style="width: 130px">
                                            <option value="subscribed" {{ $subscriber->status === 'subscribed' ? 'selected' : '' }}>Subscribed</option>
                                            <option value="unsubscribed" {{ $subscriber->status === 'unsubscribed' ? 'selected' : '' }}>Unsubscribed</option>
                                        </select>
                                        <button type="submit" class="btn btn-sm btn-success">Save</button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.ecommerce.newsletter.destroy', $subscriber) }}" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this subscriber?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No subscribers found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-16">{{ $subscribers->links() }}</div>
        </div>
    </div>
@endsection
