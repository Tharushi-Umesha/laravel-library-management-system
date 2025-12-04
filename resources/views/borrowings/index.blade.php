@extends('layouts.app')

@section('title', 'Borrow Books')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h1>
        <i class="fas fa-book-reader"></i>
        Borrow Books
    </h1>
    <p class="mb-0 mt-2">Issue books to library members</p>
</div>

<!-- Quick Stats -->
<div class="row mb-4">
    <div class="col-md-4 mb-3">
        <div class="card border-0 text-white" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); border-radius: 15px;">
            <div class="card-body text-center">
                <i class="fas fa-books fa-2x mb-2"></i>
                <h3 class="mb-0">{{ $books->where('stock', '>', 0)->count() }}</h3>
                <small>Books Available</small>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card border-0 text-white" style="background: linear-gradient(135deg, #eb3349 0%, #f45c43 100%); border-radius: 15px;">
            <div class="card-body text-center">
                <i class="fas fa-times-circle fa-2x mb-2"></i>
                <h3 class="mb-0">{{ $books->where('stock', 0)->count() }}</h3>
                <small>Out of Stock</small>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card border-0 text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 15px;">
            <div class="card-body text-center">
                <i class="fas fa-users fa-2x mb-2"></i>
                <h3 class="mb-0">{{ $users->count() }}</h3>
                <small>Total Members</small>
            </div>
        </div>
    </div>
</div>

<!-- Books Table -->
<div class="table-container">
    <div class="p-3" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 15px 15px 0 0;">
        <h5 class="mb-0">
            <i class="fas fa-list"></i> Available Books for Borrowing
        </h5>
    </div>

    <table class="table table-hover mb-0">
        <thead style="background: #f8f9fa;">
            <tr>
                <th><i class="fas fa-hashtag"></i> ID</th>
                <th><i class="fas fa-book"></i> Title</th>
                <th><i class="fas fa-user-edit"></i> Author</th>
                <th><i class="fas fa-tag"></i> Category</th>
                <th><i class="fas fa-boxes"></i> Stock</th>
                <th><i class="fas fa-hand-holding"></i> Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($books as $book)
            <tr>
                <td><strong>#{{ $book->id }}</strong></td>
                <td>
                    <strong>{{ $book->title }}</strong>
                </td>
                <td>{{ $book->author }}</td>
                <td>
                    <span class="badge bg-info">{{ $book->category->name }}</span>
                </td>
                <td>
                    @if($book->stock > 0)
                    <span class="stock-badge badge-in-stock">
                        <i class="fas fa-check-circle"></i> {{ $book->stock }} Available
                    </span>
                    @else
                    <span class="stock-badge badge-out-stock">
                        <i class="fas fa-times-circle"></i> OUT OF STOCK
                    </span>
                    @endif
                </td>
                <td>
                    @if($book->stock > 0)
                    <button type="button" class="btn btn-primary-custom btn-sm btn-action"
                        data-bs-toggle="modal"
                        data-bs-target="#borrowModal{{ $book->id }}">
                        <i class="fas fa-hand-holding-heart"></i> Borrow Now
                    </button>

                    <!-- Borrow Modal -->
                    <div class="modal fade" id="borrowModal{{ $book->id }}" tabindex="-1" aria-labelledby="borrowModalLabel{{ $book->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content" style="border-radius: 15px; border: none;">
                                <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 15px 15px 0 0;">
                                    <h5 class="modal-title" id="borrowModalLabel{{ $book->id }}">
                                        <i class="fas fa-book-reader"></i> Borrow Book
                                    </h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>

                                <form action="{{ route('borrowings.borrow') }}" method="POST">
                                    @csrf
                                    <div class="modal-body p-4">
                                        <input type="hidden" name="book_id" value="{{ $book->id }}">

                                        <!-- Book Info -->
                                        <div class="alert alert-info" style="border-radius: 10px; border-left: 4px solid #0dcaf0;">
                                            <h6 class="mb-2"><i class="fas fa-book"></i> Book Details:</h6>
                                            <p class="mb-1"><strong>Title:</strong> {{ $book->title }}</p>
                                            <p class="mb-1"><strong>Author:</strong> {{ $book->author }}</p>
                                            <p class="mb-0"><strong>Available Stock:</strong> {{ $book->stock }} copies</p>
                                        </div>

                                        <!-- User Selection -->
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">
                                                <i class="fas fa-user text-primary"></i> Select Member/User *
                                            </label>
                                            <select name="user_id" class="form-select" required style="border: 2px solid #e9ecef; border-radius: 10px; padding: 12px;">
                                                <option value="">-- Choose a member --</option>
                                                @foreach($users as $user)
                                                <option value="{{ $user->id }}">
                                                    {{ $user->name }} ({{ $user->email }})
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Info Note -->
                                        <div class="alert alert-warning" style="border-radius: 10px; border-left: 4px solid #ffc107;">
                                            <i class="fas fa-exclamation-triangle"></i>
                                            <small><strong>Note:</strong> Stock will automatically decrease by 1 after borrowing.</small>
                                        </div>
                                    </div>

                                    <div class="modal-footer" style="border-top: 2px solid #f8f9fa;">
                                        <button type="button" class="btn btn-secondary btn-action" data-bs-dismiss="modal">
                                            <i class="fas fa-times"></i> Cancel
                                        </button>
                                        <button type="submit" class="btn btn-success-custom btn-action">
                                            <i class="fas fa-check-circle"></i> Confirm Borrow
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @else
                    <button class="btn btn-secondary btn-sm" disabled>
                        <i class="fas fa-ban"></i> Out of Stock
                    </button>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center py-5">
                    <i class="fas fa-book-open fa-3x text-muted mb-3 d-block"></i>
                    <h5 class="text-muted">No books available</h5>
                    <p class="text-muted">Add books to your library first!</p>
                    <a href="{{ route('books.create') }}" class="btn btn-success-custom btn-action mt-3">
                        <i class="fas fa-plus-circle"></i> Add Books
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
        <div class="card border-0" style="background: linear-gradient(135deg, #2193b0 0%, #6dd5ed 100%); border-radius: 15px;">
            <div class="card-body text-white">
                <h5><i class="fas fa-info-circle"></i> How to Borrow a Book</h5>
                <ol class="mb-0">
                    <li>Find the book you want to issue from the list above</li>
                    <li>Click the "Borrow Now" button</li>
                    <li>Select the member/user who wants to borrow the book</li>
                    <li>Click "Confirm Borrow" to complete the process</li>
                    <li>The stock will automatically decrease by 1</li>
                </ol>
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
</style>
@endpush