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

<!-- Quick Stats using Component -->
<div class="row mb-4">
    <div class="col-md-4 mb-3">
        <x-stats-card
            icon="fa-books"
            color="success"
            :count="$books->where('stock', '>', 0)->count()"
            label="Books Available" />
    </div>
    <div class="col-md-4 mb-3">
        <x-stats-card
            icon="fa-times-circle"
            color="danger"
            :count="$books->where('stock', 0)->count()"
            label="Out of Stock" />
    </div>
    <div class="col-md-4 mb-3">
        <x-stats-card
            icon="fa-users"
            color="primary"
            :count="$users->count()"
            label="Total Members" />
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
                <td><strong>{{ $book->title }}</strong></td>
                <td>{{ $book->author }}</td>
                <td><span class="badge bg-info">{{ $book->category->name }}</span></td>
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

                    {{-- Use Borrow Modal Component --}}
                    <x-borrow-modal :book="$book" :users="$users" />
                    @else
                    <button class="btn btn-secondary btn-sm" disabled>
                        <i class="fas fa-ban"></i> Out of Stock
                    </button>
                    @endif
                </td>
            </tr>
            @empty
            <x-empty-state
                icon="fa-book-open"
                message="No books available"
                submessage="Add books to your library first!"
                :colspan="6"
                :actionUrl="route('books.create')"
                actionText="Add Books" />
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