{{-- Form Input Component --}}
{{-- Usage: <x-form-input name="title" label="Book Title" icon="fa-book" type="text" :required="true" /> --}}

@props([
'name',
'label',
'icon' => null,
'type' => 'text',
'required' => false,
'value' => '',
'placeholder' => '',
'step' => null,
'min' => null
])

<div class="mb-4">
    <label class="form-label">
        @if($icon)
        <i class="fas {{ $icon }} text-primary"></i>
        @endif
        {{ $label }} @if($required)<span class="text-danger">*</span>@endif
    </label>

    <input
        type="{{ $type }}"
        name="{{ $name }}"
        class="form-control @error($name) is-invalid @enderror"
        value="{{ old($name, $value) }}"
        placeholder="{{ $placeholder }}"
        @if($required) required @endif
        @if($step) step="{{ $step }}" @endif
        @if($min !==null) min="{{ $min }}" @endif>

    @error($name)
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>