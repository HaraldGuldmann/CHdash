@if($label ?? null)
    <label class="block text-sm font-medium leading-5 text-gray-700" for="{{ $name }}">
        {{ $label }}
    </label>
@endif
<input
    autocomplete="off"
    type="{{ $type ?? 'text' }}"
    name="{{ $name }}"
    id="{{ $name }}"
    class="mt-1 form-input block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5"
    placeholder="{{ $placeholder ?? '' }}"
    value="{{ old($name, $value ?? '') }}"
    {{ ($required ?? false) ? 'required' : '' }}
>
@error($name)
    <div class="rounded-md bg-red-50 p-4 mt-5">
        <div class="text-sm text-red-700">
            {{ $message }}
        </div>
    </div>
@enderror
