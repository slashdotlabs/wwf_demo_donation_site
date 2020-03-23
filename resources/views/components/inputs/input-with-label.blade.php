<label for="{{ $name }}" class="block text-sm font-medium leading-5 text-gray-700">{{ $labelText }}</label>
<div class="mt-1 relative rounded-md shadow-sm">
    <input id="{{ $name }}" name="{{ $name }}" value="{{ old($getErrorBagName) }}" {{ $attributes->merge(['class' => $getDefaultClasses]) }}/>
</div>
@error($getErrorBagName)
<span class="inline-block ml-1 mt-2 text-red-600 text-xs" role="alert">
    {{ $message }}
</span>
@enderror
