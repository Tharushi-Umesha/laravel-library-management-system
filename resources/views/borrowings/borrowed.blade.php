@extends('layouts.app')

@section('title', 'Borrowed Books')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h1>
        <i class="fas fa-list-check"></i>
        Currently Borrowed Books
    </h1>
    <p class="mb-0 mt-2">Track and manage all borrowed books</p>
</div>

<!-- Quick Stats using Component -->
<div class="row mb-4">
    <div class="col-md-6 mb-3">
        <x-stats-card
            icon="fa-book-open"
            color="warning"
            :count="$borrowings->count()"
            label="Books Currently Borrowed" />
    </div>
    <div class="col-md-6 mb-3">
        <x-stats-card
            icon="fa-clock"
            color="info"
            :count="$borrowings->where('created_at', '>=', now()->subDays(7))->count()"
            label="Borrowed This Week" />
    </div>
</div>

<!-- Borrowed Books Table -->
<div class="table-container">
    <div class="p-3" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; border-radius: 15px 15px 0 0;">
        <h5 class="mb-0">
            <i class="fas fa-clipboard-list"></i> Active Borrowings
        </h5>
    </div>

    <table class="table table-hover mb-0">
        <thead style="background: #f8f9fa;">
            <tr>
                <th><i class="fas fa-hashtag"></i> ID</th>
                <th><i class="fas fa-book"></i> Book Title</th>
                <th><i class="fas fa-user"></i> Borrowed By</th>
                <th><i class="fas fa-tag"></i> Category</th>
                <th><i class="fas fa-calendar-alt"></i> Borrowed Date</th>
                <th><i class="fas fa-hourglass-half"></i> Duration</th>
                <th><i class="fas fa-undo"></i> Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($borrowings as $borrowing)
            <tr>
                <td><strong>#{{ $borrowing->id }}</strong></td>
                <td>
                    <strong>{{ $borrowing->book->title }}</strong>
                    <br>
                    <small class="text-muted">by {{ $borrowing->book->author }}</small>
                </td>
                <td>
                    <i class="fas fa-user-circle text-primary"></i>
                    <strong>{{ $borrowing->user->name }}</strong>
                    <br>
                    <small class="text-muted">{{ $borrowing->user->email }}</small>
                </td>
                <td>
                    <span class="badge bg-info">{{ $borrowing->book->category->name }}</span>
                </td>
                <td>
                    <i class="fas fa-calendar"></i> {{ $borrowing->borrowed_at->format('M d, Y') }}
                    <br>
                    <small class="text-muted">
                        <i class="fas fa-clock"></i> {{ $borrowing->borrowed_at->format('h:i A') }}
                    </small>
                </td>
                <td>
                    @php
                    $days = $borrowing->borrowed_at->diffInDays(now());
                    $badgeClass = $days > 14 ? 'bg-danger' : ($days > 7 ? 'bg-warning' : 'bg-success');
                    @endphp
                    <span class="badge {{ $badgeClass }}">
                        <i class="fas fa-calendar-day"></i> {{ $days }} day{{ $days != 1 ? 's' : '' }}
                    </span>
                    @if($days > 14)
                    <br><small class="text-danger"><i class="fas fa-exclamation-triangle"></i> Overdue!</small>
                    @endif
                </td>
                <td>
                    <button type="button" class="btn btn-success-custom btn-sm btn-action"
                        data-bs-toggle="modal"
                        data-bs-target="#returnModal{{ $borrowing->id }}">
                        <i class="fas fa-check-circle"></i> Return Book
                    </button>

                    {{-- Use Return Modal Component --}}
                    <x-return-modal :borrowing="$borrowing" />
                </td>
            </tr>
            @empty
            <x-empty-state
                icon="fa-clipboard-check"
                message="No books currently borrowed"
                submessage="All books have been returned or no borrowings yet!"
                :colspan="7"
                :actionUrl="route('borrowings.index')"
                actionText="Borrow Books" />
            @endforelse
        </tbody>
    </table>
</div>

<!-- Instructions Card -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card border-0" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 15px;">
            <div class="card-body text-white">
                <div class="row">
                    <div class="col-md-6">
                        <h5><i class="fas fa-info-circle"></i> Duration Color Guide</h5>
                        <ul class="mb-0">
                            <li><span class="badge bg-success">Green</span> - 0-7 days (On time)</li>
                            <li><span class="badge bg-warning text-dark">Yellow</span> - 8-14 days (Due soon)</li>
                            <li><span class="badge bg-danger">Red</span> - 15+ days (Overdue)</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h5><i class="fas fa-clipboard-check"></i> Return Process</h5>
                        <ul class="mb-0">
                            <li>Click "Return Book" button</li>
                            <li>Confirm the return details</li>
                            <li>Stock will automatically increase</li>
                            <li>Borrowing record will be archived</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection