{{-- Empty State Component --}}
{{-- Usage: <x-empty-state icon="fa-book-open" message="No books found" :colspan="6" /> --}}

@props(['icon', 'message', 'submessage' => '', 'colspan' => 6, 'actionUrl' => null, 'actionText' => null])

<tr>
    <td colspan="{{ $colspan }}" class="text-center py-5">
        <i class="fas {{ $icon }} fa-3x text-muted mb-3 d-block"></i>
        <h5 class="text-muted">{{ $message }}</h5>

        @if($submessage)
        <p class="text-muted">{{ $submessage }}</p>
        @endif

        @if($actionUrl && $actionText)
        <a href="{{ $actionUrl }}" class="btn btn-success-custom btn-action mt-3">
            <i class="fas fa-plus-circle"></i> {{ $actionText }}
        </a>
        @endif
    </td>
</tr>