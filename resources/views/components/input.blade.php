@props(['name', 'label', 'type' => 'text', 'bag' => 'default'])
@php
    $fieldError = $errors->getBag($bag)->first($name);
    $fieldId = $attributes->get('id', $name);
    $description = trim($attributes->get('aria-describedby', '').($fieldError ? ' '.$fieldId.'-error' : ''));
@endphp
<div class="field">
    <label for="{{ $fieldId }}">{{ $label }}</label>
    <input name="{{ $name }}" type="{{ $type }}" {{ $attributes->except('aria-describedby')->merge(['id' => $name]) }}
        @if ($fieldError) aria-invalid="true" @endif
        @if ($description) aria-describedby="{{ $description }}" @endif>
    @if ($fieldError)
        <small class="field-error" id="{{ $fieldId }}-error">{{ $fieldError }}</small>
    @endif
</div>
