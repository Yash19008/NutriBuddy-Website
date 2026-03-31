@extends('layout.layout')
@php
    $title = 'Support Tickets';
    $subTitle = 'Ecommerce / Support Tickets';
@endphp

@section('content')
    @include('admin.ecommerce._messages')

    <div class="card mb-24">
        <div class="card-header"><h5 class="card-title mb-0">Create Support Ticket</h5></div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.ecommerce.support-tickets.store') }}" class="row g-3">
                @csrf
                <div class="col-md-3">
                    <label class="form-label">Customer User</label>
                    <select name="user_id" class="form-select">
                        <option value="">Select User</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Subject</label>
                    <input type="text" name="subject" class="form-control" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select" required>
                        <option value="open">Open</option>
                        <option value="in_progress">In Progress</option>
                        <option value="resolved">Resolved</option>
                        <option value="closed">Closed</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Priority</label>
                    <select name="priority" class="form-select" required>
                        <option value="low">Low</option>
                        <option value="medium" selected>Medium</option>
                        <option value="high">High</option>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label">Message</label>
                    <textarea name="message" class="form-control" rows="3" required></textarea>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Create Ticket</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header"><h5 class="card-title mb-0">Ticket List</h5></div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table bordered-table mb-0">
                    <thead>
                        <tr>
                            <th>Ticket</th>
                            <th>User</th>
                            <th>Subject</th>
                            <th>Status</th>
                            <th>Priority</th>
                            <th>Last Reply</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tickets as $ticket)
                            <tr>
                                <td>{{ $ticket->ticket_number }}</td>
                                <td>{{ $ticket->user?->name ?? 'Guest' }}</td>
                                <td>{{ $ticket->subject }}</td>
                                <td>{{ str_replace('_', ' ', ucfirst($ticket->status)) }}</td>
                                <td>{{ ucfirst($ticket->priority) }}</td>
                                <td>{{ $ticket->last_replied_at?->format('d M Y H:i') ?? '—' }}</td>
                                <td class="text-end">
                                    <form method="POST" action="{{ route('admin.ecommerce.support-tickets.update', $ticket) }}" class="d-inline-flex gap-8 align-items-center me-8">
                                        @csrf
                                        @method('PUT')
                                        <select name="status" class="form-select form-select-sm" style="width: 130px">
                                            <option value="open" {{ $ticket->status === 'open' ? 'selected' : '' }}>Open</option>
                                            <option value="in_progress" {{ $ticket->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                            <option value="resolved" {{ $ticket->status === 'resolved' ? 'selected' : '' }}>Resolved</option>
                                            <option value="closed" {{ $ticket->status === 'closed' ? 'selected' : '' }}>Closed</option>
                                        </select>
                                        <select name="priority" class="form-select form-select-sm" style="width: 110px">
                                            <option value="low" {{ $ticket->priority === 'low' ? 'selected' : '' }}>Low</option>
                                            <option value="medium" {{ $ticket->priority === 'medium' ? 'selected' : '' }}>Medium</option>
                                            <option value="high" {{ $ticket->priority === 'high' ? 'selected' : '' }}>High</option>
                                        </select>
                                        <input type="text" name="admin_note" value="{{ $ticket->admin_note }}" class="form-control form-control-sm" style="width: 200px" placeholder="Admin note">
                                        <button type="submit" class="btn btn-sm btn-success">Save</button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.ecommerce.support-tickets.destroy', $ticket) }}" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this ticket?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No tickets found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-16">{{ $tickets->links() }}</div>
        </div>
    </div>
@endsection
