@props(['labelText', 'name'])

<label for="{{ $name }}" class="block text-sm font-medium leading-5 text-gray-700">{{ $labelText }}</label>
<div class="mt-1 relative rounded-md shadow-sm">
    <input id="{{ $name }}" name="{{ $name }}" {{ $attributes->merge(['class' => 'form-input block w-full sm:text-sm sm:leading-5']) }}/>
</div>
