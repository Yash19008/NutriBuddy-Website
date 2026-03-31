@extends('layout.layout')
@php
    $title = 'Contact Leads';
    $subTitle = 'Ecommerce / Contact Leads';
@endphp

@section('content')
    @include('admin.ecommerce._messages')

    <div class="card">
        <div class="card-header"><h5 class="card-title mb-0">Lead Inbox</h5></div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table bordered-table mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Subject</th>
                            <th>Status</th>
                            <th>Assignee</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($leads as $lead)
                            <tr>
                                <td>{{ $lead->id }}</td>
                                <td>{{ $lead->name }}</td>
                                <td>{{ $lead->email }}</td>
                                <td>{{ $lead->phone ?? '—' }}</td>
                                <td>{{ $lead->subject ?? '—' }}</td>
                                <td>{{ str_replace('_', ' ', ucfirst($lead->status)) }}</td>
                                <td>{{ $lead->assignee?->name ?? 'Unassigned' }}</td>
                                <td class="text-end">
                                    <form method="POST" action="{{ route('admin.ecommerce.contact-leads.update', $lead) }}" class="d-inline-flex gap-8 align-items-center me-8">
                                        @csrf
                                        @method('PUT')
                                        <select name="status" class="form-select form-select-sm" style="width: 130px">
                                            <option value="new" {{ $lead->status === 'new' ? 'selected' : '' }}>New</option>
                                            <option value="in_progress" {{ $lead->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                            <option value="closed" {{ $lead->status === 'closed' ? 'selected' : '' }}>Closed</option>
                                        </select>
                                        <select name="assigned_to" class="form-select form-select-sm" style="width: 140px">
                                            <option value="">Unassigned</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}" {{ (string) $lead->assigned_to === (string) $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                        <input type="text" name="admin_note" value="{{ $lead->admin_note }}" class="form-control form-control-sm" style="width: 200px" placeholder="Admin note">
                                        <button type="submit" class="btn btn-sm btn-success">Save</button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.ecommerce.contact-leads.destroy', $lead) }}" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this lead?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No leads found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-16">{{ $leads->links() }}</div>
        </div>
    </div>
@endsection
