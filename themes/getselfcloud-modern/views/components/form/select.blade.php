@props([
'name',
'label' => null,
'options' => [],
'selected' => null,
'multiple' => false,
'required' => false,
'divClass' => null,
'hideRequiredIndicator' => false,
])
<fieldset class="flex flex-col w-full {{ $divClass ?? '' }}">
    @if ($label)
    <label for="{{ $name }}" class="mb-1 text-sm font-medium text-base/85">
        {{ $label }}
        @if ($required && !$hideRequiredIndicator)
        <span class="text-red-500">*</span>
        @endif
    </label>
    @endif

    <select id="{{ $id ?? $name }}" {{ $multiple ? 'multiple' : '' }} {{ $attributes->except(['options', 'id', 'name', 'multiple'])->merge(['class' => 'block w-full rounded-lg border border-neutral bg-background px-3 py-2.5 text-sm text-base shadow-sm outline-none transition-all duration-200 ease-in-out form-select focus:border-primary focus:ring-2 focus:ring-primary/20 disabled:cursor-not-allowed disabled:bg-background-secondary/60']) }} name="{{ $name }}{{ $multiple ? '[]' : '' }}">
        @if (count($options) == 0 && $slot)
        {{ $slot }}
        @else
        @foreach ($options as $key => $option)
        <option class="bg-background text-base" value="{{ gettype($options) == 'array' ? $option : $key }}" {{ ($multiple && $selected ? in_array($key,
            $selected) : $selected==$option) ? 'selected' : '' }}>
            {{ $option }}</option>
        @endforeach
        @endif
    </select>
    @if ($multiple)
    <p class="text-xs text-base">
        {{ __('Pro tip: Hold down the Ctrl (Windows) / Command (Mac) button to select multiple options.') }}</p>
    @endif

    @error($name)
    <p class="text-red-500 text-xs">{{ $message }}</p>
    @enderror
</fieldset>
