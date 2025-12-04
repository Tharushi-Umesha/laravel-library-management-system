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

<!-- Quick Stats -->
<div class="row mb-4">
    <div class="col-md-6 mb-3">
        <div class="card border-0 text-white" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border-radius: 15px;">
            <div class="card-body text-center">
                <i class="fas fa-book-open fa-2x mb-2"></i>
                <h3 class="mb-0">{{ $borrowings->count() }}</h3>
                <small>Books Currently Borrowed</small>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="card border-0 text-white" style="background: linear-gradient(135deg, #2193b0 0%, #6dd5ed 100%); border-radius: 15px;">
            <div class="card-body text-center">
                <i class="fas fa-clock fa-2x mb-2"></i>
                <h3 class="mb-0">{{ $borrowings->where('created_at', '>=', now()->subDays(7))->count() }}</h3>
                <small>Borrowed This Week</small>
            </div>
        </div>
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

                    <!-- Return Confirmation Modal -->
                    <div class="modal fade" id="returnModal{{ $borrowing->id }}" tabindex="-1" aria-labelledby="returnModalLabel{{ $borrowing->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content" style="border-radius: 15px; border: none;">
                                <div class="modal-header" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); color: white; border-radius: 15px 15px 0 0;">
                                    <h5 class="modal-title" id="returnModalLabel{{ $borrowing->id }}">
                                        <i class="fas fa-undo"></i> Confirm Book Return
                                    </h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>

                                <form action="{{ route('borrowings.return', $borrowing->id) }}" method="POST">
                                    @csrf
                                    <div class="modal-body p-4">
                                        <!-- Return Info -->
                                        <div class="alert alert-info" style="border-radius: 10px; border-left: 4px solid #0dcaf0;">
                                            <h6 class="mb-2"><i class="fas fa-info-circle"></i> Return Details:</h6>
                                            <p class="mb-1"><strong>Book:</strong> {{ $borrowing->book->title }}</p>
                                            <p class="mb-1"><strong>Borrowed By:</strong> {{ $borrowing->user->name }}</p>
                                            <p class="mb-1"><strong>Borrowed On:</strong> {{ $borrowing->borrowed_at->format('M d, Y h:i A') }}</p>
                                            <p class="mb-0"><strong>Duration:</strong> {{ $borrowing->borrowed_at->diffInDays(now()) }} days</p>
                                        </div>

                                        <!-- Success Note -->
                                        <div class="alert alert-success" style="border-radius: 10px; border-left: 4px solid #198754;">
                                            <i class="fas fa-check-circle"></i>
                                            <small><strong>Action:</strong> Stock will automatically increase by 1 after return.</small>
                                        </div>

                                        <p class="text-center mb-0">
                                            <i class="fas fa-question-circle fa-2x text-warning mb-2"></i>
                                            <br>
                                            Are you sure you want to mark this book as returned?
                                        </p>
                                    </div>

                                    <div class="modal-footer" style="border-top: 2px solid #f8f9fa;">
                                        <button type="button" class="btn btn-secondary btn-action" data-bs-dismiss="modal">
                                            <i class="fas fa-times"></i> Cancel
                                        </button>
                                        <button type="submit" class="btn btn-success-custom btn-action">
                                            <i class="fas fa-check-circle"></i> Confirm Return
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center py-5">
                    <i class="fas fa-clipboard-check fa-3x text-muted mb-3 d-block"></i>
                    <h5 class="text-muted">No books currently borrowed</h5>
                    <p class="text-muted">All books have been returned or no borrowings yet!</p>
                    <a href="{{ route('borrowings.index') }}" class="btn btn-primary-custom btn-action mt-3">
                        <i class="fas fa-book-reader"></i> Borrow Books
                    </a>
                </td>
            </tr>
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

@push('styles')
<style>
    .modal-content {
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
    }

    .modal-backdrop.show {
        opacity: 0.7;
    }

    /* Add animation to badges */
    .badge {
        animation: fadeIn 0.5s ease;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: scale(0.9);
        }

        to {
            opacity: 1;
            transform: scale(1);
        }
    }
</style>
@endpush