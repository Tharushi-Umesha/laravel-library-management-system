{{-- Page Header Component --}}
{{-- Usage: <x-page-header icon="fa-book" title="Book Management" subtitle="Manage your library" /> --}}

@props(['icon', 'title', 'subtitle' => ''])

<div class="page-header">
    <h1>
        <i class="fas {{ $icon }}"></i>
        {{ $title }}
    </h1>
    @if($subtitle)
    <p class="mb-0 mt-2">{{ $subtitle }}</p>
    @endif
</div>