{{-- Return Modal Component --}}
{{-- Usage: <x-return-modal :borrowing="$borrowing" /> --}}

@props(['borrowing'])

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