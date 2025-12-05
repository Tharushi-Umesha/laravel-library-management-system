{{-- Form Select Component --}}
{{-- Usage: <x-form-select name="category" label="Category" icon="fa-tag" :options="$categories" :selected="$book->category_id ?? ''" /> --}}

@props([
'name',
'label',
'icon' => null,
'options' => [],
'selected' => '',
'required' => false,
'placeholder' => '-- Select --'
])

<div class="mb-4">
    <label class="form-label">
        @if($icon)
        <i class="fas {{ $icon }} text-danger"></i>
        @endif
        {{ $label }} @if($required)<span class="text-danger">*</span>@endif
    </label>

    <select
        name="{{ $name }}"
        class="form-select @error($name) is-invalid @enderror"
        @if($required) required @endif>
        <option value="">{{ $placeholder }}</option>
        @foreach($options as $option)
        <option value="{{ $option->id }}" {{ old($name, $selected) == $option->id ? 'selected' : '' }}>
            {{ $option->name }}
        </option>
        @endforeach
    </select>

    @error($name)
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>