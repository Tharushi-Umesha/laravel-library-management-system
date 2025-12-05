{{-- Stats Card Component - Alternative Method --}}
{{-- Usage: <x-stats-card icon="fa-books" color="success" :count="10" label="Books Available" /> --}}

@props(['icon', 'color' => 'primary', 'count', 'label'])

<div class="card border-0 text-white gradient-{{ $color }}" style="border-radius: 15px;">
    <div class="card-body text-center">
        <i class="fas {{ $icon }} fa-2x mb-2"></i>
        <h3 class="mb-0">{{ $count }}</h3>
        <small>{{ $label }}</small>
    </div>
</div>