<!-- Borrow Modal Component -->
<div class="modal fade" id="borrowModal{{ $book->id }}" tabindex="-1" aria-labelledby="borrowModalLabel{{ $book->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header gradient-primary text-white">
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
                        <select name="user_id" class="form-select" required>
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