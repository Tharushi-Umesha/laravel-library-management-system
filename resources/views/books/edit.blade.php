@extends('layouts.app')

@section('title', 'Edit Book')

@section('content')

<x-page-header
    icon="fa-edit"
    title="Edit Book Details"
    :subtitle="'Update information for: ' . $book->title" />


<div class="mb-4">
    <a href="{{ route('books.index') }}" class="btn btn-secondary btn-action">
        <i class="fas fa-arrow-left"></i> Back to Books
    </a>
</div>


<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="form-card">

            <div class="alert alert-primary" style="border-radius: 10px; border-left: 4px solid #0d6efd;">
                <i class="fas fa-info-circle"></i>
                <strong>Editing Book ID:</strong> #{{ $book->id }} |
                <strong>Current Stock:</strong> {{ $book->stock }}
            </div>

            <form action="{{ route('books.update', $book) }}" method="POST">
                @csrf
                @method('PUT')

                <x-form-input
                    name="title"
                    label="Book Title"
                    icon="fa-book"
                    :required="true"
                    :value="$book->title" />

                <x-form-input
                    name="author"
                    label="Author Name"
                    icon="fa-user-edit"
                    :required="true"
                    :value="$book->author" />

                <div class="row">
                    <div class="col-md-6">
                        <x-form-input
                            name="price"
                            label="Price (USD)"
                            icon="fa-dollar-sign"
                            type="number"
                            step="0.01"
                            :min="0"
                            :required="true"
                            :value="$book->price" />
                        <small class="text-muted">
                            <i class="fas fa-history"></i> Previous: ${{ number_format($book->price, 2) }}
                        </small>
                    </div>
                    <div class="col-md-6">
                        <x-form-input
                            name="stock"
                            label="Stock Quantity"
                            icon="fa-boxes"
                            type="number"
                            :min="0"
                            :required="true"
                            :value="$book->stock" />
                        <small class="text-muted">
                            <i class="fas fa-history"></i> Previous: {{ $book->stock }} copies
                        </small>
                    </div>
                </div>

                <x-form-select
                    name="book_category_id"
                    label="Book Category"
                    icon="fa-tag"
                    :options="$categories"
                    :selected="$book->book_category_id"
                    :required="true"
                    placeholder="-- Select a category --" />
                <small class="text-muted mb-3 d-block">
                    <i class="fas fa-history"></i> Previous: {{ $book->category->name }}
                </small>


                @if($book->stock == 0)
                <div class="alert alert-warning" style="border-radius: 10px; border-left: 4px solid #ffc107;">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>Warning:</strong> This book is currently OUT OF STOCK. Consider adding more copies.
                </div>
                @endif


                <div class="d-flex justify-content-between gap-3 mt-4">
                    <a href="{{ route('books.index') }}" class="btn btn-secondary btn-action">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                    <button type="submit" class="btn btn-warning-custom btn-action">
                        <i class="fas fa-save"></i> Update Book
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection