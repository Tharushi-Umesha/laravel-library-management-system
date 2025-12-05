{{-- Stats Card Component - Compact Horizontal Layout --}}
{{-- Usage: <x-stats-card icon="fa-book-open" :count="10" label="Books Available" /> --}}

@props(['icon', 'count', 'label'])

<div class="stats-card-wrapper">
    <div class="stats-card">
        <div class="stats-card-header">
            <i class="fas {{ $icon }} stats-card-icon"></i>
            <span class="stats-card-label">{{ $label }}</span>
        </div>
        <div class="stats-card-count">{{ $count }}</div>
    </div>
</div>