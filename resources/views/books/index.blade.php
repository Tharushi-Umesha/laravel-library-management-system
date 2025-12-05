@extends('layouts.app')

@section('title', 'Book Management')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h1>
        Book Management System
    </h1>
    <p class="mb-0 mt-2">Manage your library collection efficiently</p>
</div>


<div class="row mb-4 align-items-center">
    <div class="col-md-6 mb-3 mb-md-0">
        <form method="GET" action="{{ route('books.index') }}" class="d-flex align-items-stretch gap-2">
            <select name="category" class="form-select" style="max-width: 250px;">
                <option value="">📚 All Categories</option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary-custom btn-action">
                <i class="fas fa-filter"></i> Filter
            </button>
            @if(request('category'))
            <a href="{{ route('books.index') }}" class="btn btn-secondary btn-action">
                <i class="fas fa-times"></i> Clear
            </a>
            @endif
        </form>
    </div>
    <div class="col-md-6 text-md-end">
        <a href="{{ route('books.create') }}" class="btn btn-success-custom btn-action">
            <i class="fas fa-plus-circle"></i> Add New Book
        </a>
    </div>
</div>

<!-- Books Table -->
<div class="table-container">
    <table class="table table-hover mb-0">
        <thead style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
            <tr>
                <th><i class="fas fa-hashtag"></i> ID</th>
                <th><i class="fas fa-book"></i> Title</th>
                <th><i class="fas fa-user-edit"></i> Author</th>
                <th><i class="fas fa-dollar-sign"></i> Price</th>
                <th><i class="fas fa-boxes"></i> Stock</th>
                <th><i class="fas fa-tag"></i> Category</th>
                <th><i class="fas fa-cog"></i> Actions</th>
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
                    <span class="text-success fw-bold">
                        ${{ number_format($book->price, 2) }}
                    </span>
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
                    <span class="badge" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); font-size: 0.875rem; padding: 6px 12px;">
                        {{ $book->category->name }}
                    </span>
                </td>
                <td>
                    <div class="d-flex gap-2">
                        <a href="{{ route('books.edit', $book) }}" class="btn btn-warning-custom btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('books.destroy', $book) }}" method="POST"
                            onsubmit="return confirm('⚠️ Are you sure you want to delete this book?\n\nTitle: {{ $book->title }}\nAuthor: {{ $book->author }}');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger-custom btn-sm">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center py-5">
                    <i class="fas fa-book-open fa-3x text-muted mb-3 d-block"></i>
                    <h5 class="text-muted">No books found</h5>
                    <p class="text-muted">Start by adding your first book to the library!</p>
                    <a href="{{ route('books.create') }}" class="btn btn-success-custom btn-action mt-3">
                        <i class="fas fa-plus-circle"></i> Add First Book
                    </a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>


@if($books->count() > 0)
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card border-0" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 15px;">
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-3">
                        <h3 class="mb-0"><i class="fas fa-book"></i> {{ $books->count() }}</h3>
                        <small>Total Books</small>
                    </div>
                    <div class="col-md-3">
                        <h3 class="mb-0"><i class="fas fa-boxes"></i> {{ $books->sum('stock') }}</h3>
                        <small>Total Stock</small>
                    </div>
                    <div class="col-md-3">
                        <h3 class="mb-0"><i class="fas fa-check-circle"></i> {{ $books->where('stock', '>', 0)->count() }}</h3>
                        <small>Available</small>
                    </div>
                    <div class="col-md-3">
                        <h3 class="mb-0"><i class="fas fa-times-circle"></i> {{ $books->where('stock', 0)->count() }}</h3>
                        <small>Out of Stock</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@endsection