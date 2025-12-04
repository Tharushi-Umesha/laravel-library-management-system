@extends('layouts.app')

@section('title', 'Edit Book')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h1>
        <i class="fas fa-edit"></i>
        Edit Book Details
    </h1>
    <p class="mb-0 mt-2">Update information for: <strong>{{ $book->title }}</strong></p>
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
            <!-- Book Info Badge -->
            <div class="alert alert-primary" style="border-radius: 10px; border-left: 4px solid #0d6efd;">
                <i class="fas fa-info-circle"></i>
                <strong>Editing Book ID:</strong> #{{ $book->id }} |
                <strong>Current Stock:</strong> {{ $book->stock }}
            </div>

            <form action="{{ route('books.update', $book) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Title Field -->
                <div class="mb-4">
                    <label class="form-label">
                        <i class="fas fa-book text-primary"></i> Book Title *
                    </label>
                    <input
                        type="text"
                        name="title"
                        class="form-control @error('title') is-invalid @enderror"
                        value="{{ old('title', $book->title) }}"
                        placeholder="Enter book title"
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
                        value="{{ old('author', $book->author) }}"
                        placeholder="Enter author name"
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
                                value="{{ old('price', $book->price) }}"
                                placeholder="29.99"
                                min="0"
                                required>
                            @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <small class="text-muted">
                            <i class="fas fa-history"></i> Previous: ${{ number_format($book->price, 2) }}
                        </small>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label class="form-label">
                            <i class="fas fa-boxes text-warning"></i> Stock Quantity *
                        </label>
                        <input
                            type="number"
                            name="stock"
                            class="form-control @error('stock') is-invalid @enderror"
                            value="{{ old('stock', $book->stock) }}"
                            placeholder="10"
                            min="0"
                            required>
                        @error('stock')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">
                            <i class="fas fa-history"></i> Previous: {{ $book->stock }} copies
                        </small>
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
                        <option value="{{ $category->id }}"
                            {{ old('book_category_id', $book->book_category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('book_category_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">
                        <i class="fas fa-history"></i> Previous: {{ $book->category->name }}
                    </small>
                </div>

                <!-- Warning if stock is 0 -->
                @if($book->stock == 0)
                <div class="alert alert-warning" style="border-radius: 10px; border-left: 4px solid #ffc107;">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>Warning:</strong> This book is currently OUT OF STOCK. Consider adding more copies.
                </div>
                @endif

                <!-- Action Buttons -->
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

<!-- Change History Info (Optional Enhancement) -->
<div class="row justify-content-center mt-4">
    <div class="col-lg-8">
        <div class="card border-0" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border-radius: 15px;">
            <div class="card-body text-white py-3">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <small><i class="fas fa-clock"></i> <strong>Created:</strong> {{ $book->created_at->format('M d, Y') }}</small>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <small><i class="fas fa-sync"></i> <strong>Last Updated:</strong> {{ $book->updated_at->format('M d, Y h:i A') }}</small>
                    </div>
                </div>
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

    // Highlight changed fields
    const form = document.querySelector('form');
    const inputs = form.querySelectorAll('input, select');

    inputs.forEach(input => {
        const originalValue = input.value;
        input.addEventListener('change', function() {
            if (this.value !== originalValue) {
                this.style.borderColor = '#f093fb';
                this.style.borderWidth = '2px';
            }
        });
    });
</script>
@endpush