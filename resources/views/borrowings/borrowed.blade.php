@extends('layouts.app')

@section('title', 'Borrowed Books')

@section('content')

<div class="page-header">
    <h1>
        Currently Borrowed Books
    </h1>
    <p class="mb-0 mt-2">Track and manage all borrowed books</p>
</div>


<div class="row mb-4 g-3">
    <div class="col-md-6">
        <x-stats-card
            icon="fa-book-open"
            :count="$borrowings->count()"
            label="Books Currently Borrowed" />
    </div>
    <div class="col-md-6">
        <x-stats-card
            icon="fa-clock"
            :count="$borrowings->where('created_at', '>=', now()->subDays(7))->count()"
            label="Borrowed This Week" />
    </div>
</div>

<!--Table-->
<div class="table-container">
    <table class="table table-hover mb-0">
        <thead style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
            <tr>
                <th><i class="fas fa-hashtag"></i> ID</th>
                <th><i class="fas fa-book"></i> Book Title</th>
                <th><i class="fas fa-user"></i> Borrowed By</th>
                <th><i class="fas fa-tag"></i> Category</th>
                <th><i class="fas fa-calendar-alt"></i> Borrowed Date</th>
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
                    <span class="badge" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); font-size: 0.875rem; padding: 6px 12px;">
                        {{ $borrowing->book->category->name }}
                    </span>
                </td>
                <td>
                    <i class="fas fa-calendar"></i> {{ $borrowing->borrowed_at->format('M d, Y') }}
                    <br>
                    <small class="text-muted">
                        <i class="fas fa-clock"></i> {{ $borrowing->borrowed_at->format('h:i A') }}
                    </small>
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
                :colspan="6"
                actionText="Borrow Books" />
            @endforelse
        </tbody>
    </table>
</div>


<div class="row mt-4">
    <div class="col-12">
        <div class="card border-0" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); border-radius: 15px;">
            <div class="card-body text-white">
                <h5><i class="fas fa-clipboard-check"></i> How to Return a Book</h5>
                <ol class="mb-0">
                    <li>Find the borrowing record in the list above</li>
                    <li>Click the "Return Book" button</li>
                    <li>Confirm the return details in the popup</li>
                    <li>The book stock will automatically increase by 1</li>
                    <li>The borrowing record will be marked as returned</li>
                </ol>
            </div>
        </div>
    </div>
</div>

@endsection