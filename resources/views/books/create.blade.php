@extends('layouts.app')

@section('title', 'Add New Book')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h1>
        <i class="fas fa-plus-circle"></i>
        Add New Book
    </h1>
    <p class="mb-0 mt-2">Add a new book to your library collection</p>
</div>

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

                <!-- Title Field -->
                <div class="mb-4">
                    <label class="form-label">
                        <i class="fas fa-book text-primary"></i> Book Title *
                    </label>
                    <input
                        type="text"
                        name="title"
                        class="form-control @error('title') is-invalid @enderror"
                        value="{{ old('title') }}"
                        placeholder="Enter book title (e.g., The Great Gatsby)"
                        required>
                    @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Author Field -->
                <div class="mb-4">
                    <label class="form-label">
                        <i class="fas fa-user-edit text-info"></i> Author Name *
                    </label>
                    <input
                        type="text"
                        name="author"
                        class="form-control @error('author') is-invalid @enderror"
                        value="{{ old('author') }}"
                        placeholder="Enter author name (e.g., F. Scott Fitzgerald)"
                        required>
                    @error('author')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Price and Stock Row -->
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label class="form-label">
                            <i class="fas fa-dollar-sign text-success"></i> Price (USD) *
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input
                                type="number"
                                step="0.01"
                                name="price"
                                class="form-control @error('price') is-invalid @enderror"
                                value="{{ old('price') }}"
                                placeholder="29.99"
                                min="0"
                                required>
                            @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <small class="text-muted">Enter price in dollars (e.g., 29.99)</small>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label class="form-label">
                            <i class="fas fa-boxes text-warning"></i> Stock Quantity *
                        </label>
                        <input
                            type="number"
                            name="stock"
                            class="form-control @error('stock') is-invalid @enderror"
                            value="{{ old('stock') }}"
                            placeholder="10"
                            min="0"
                            required>
                        @error('stock')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Number of copies available</small>
                    </div>
                </div>

                <!-- Category Field -->
                <div class="mb-4">
                    <label class="form-label">
                        <i class="fas fa-tag text-danger"></i> Book Category *
                    </label>
                    <select
                        name="book_category_id"
                        class="form-select @error('book_category_id') is-invalid @enderror"
                        required>
                        <option value="">-- Select a category --</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('book_category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('book_category_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

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

<!-- Preview Card (Optional Enhancement) -->
<div class="row justify-content-center mt-4">
    <div class="col-lg-8">
        <div class="card border-0" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 15px;">
            <div class="card-body text-white text-center py-4">
                <i class="fas fa-lightbulb fa-2x mb-3"></i>
                <h5>Quick Tips</h5>
                <ul class="text-start" style="max-width: 500px; margin: 0 auto;">
                    <li>Use descriptive titles that are easy to search</li>
                    <li>Include the full author name for better organization</li>
                    <li>Set realistic stock numbers based on available copies</li>
                    <li>Choose the most appropriate category for easy filtering</li>
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Auto-format price input
    document.querySelector('input[name="price"]').addEventListener('blur', function() {
        if (this.value) {
            this.value = parseFloat(this.value).toFixed(2);
        }
    });
</script>
@endpush