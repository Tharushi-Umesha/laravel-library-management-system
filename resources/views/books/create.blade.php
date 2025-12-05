@extends('layouts.app')

@section('title', 'Add New Book')

@section('content')

<x-page-header
    icon="fa-plus-circle"
    title="Add New Book"
    subtitle="Add a new book to your library collection" />

<!-- Back Button -->
<div class="mb-4">
    <a href="{{ route('books.index') }}" class="btn btn-secondary btn-action">
        <i class="fas fa-arrow-left"></i> Back to Books
    </a>
</div>

<!-- Form Card -->
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="form-card">
            <form action="{{ route('books.store') }}" method="POST">
                @csrf

                <x-form-input
                    name="title"
                    label="Book Title"
                    icon="fa-book"
                    :required="true"
                    placeholder="Enter book title (e.g., The Great Gatsby)" />

                <x-form-input
                    name="author"
                    label="Author Name"
                    icon="fa-user-edit"
                    :required="true"
                    placeholder="Enter author name (e.g., F. Scott Fitzgerald)" />

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
                            placeholder="29.99" />
                    </div>
                    <div class="col-md-6">
                        <x-form-input
                            name="stock"
                            label="Stock Quantity"
                            icon="fa-boxes"
                            type="number"
                            :min="0"
                            :required="true"
                            placeholder="10" />
                    </div>
                </div>

                <x-form-select
                    name="book_category_id"
                    label="Book Category"
                    icon="fa-tag"
                    :options="$categories"
                    :required="true"
                    placeholder="-- Select a category --" />

                <!-- Required Fields Note -->
                <div class="alert alert-info" style="border-radius: 10px; border-left: 4px solid #0dcaf0;">
                    <i class="fas fa-info-circle"></i>
                    <strong>Note:</strong> All fields marked with * are required
                </div>

                <!-- Action Buttons -->
                <div class="d-flex justify-content-between gap-3 mt-4">
                    <a href="{{ route('books.index') }}" class="btn btn-secondary btn-action">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                    <button type="submit" class="btn btn-success-custom btn-action">
                        <i class="fas fa-save"></i> Add Book to Library
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection