@props(['href', 'spa' => true])
<a href="{{ $href }}" {{ $attributes->merge(['class' => 'flex flex-row items-center gap-2 rounded-xl p-3 text-sm font-semibold text-wrap transition ' . ($href === request()->url() ? 'bg-primary/12 text-primary' : 'text-base/90 hover:bg-background/70 hover:text-primary')]) }} @if($spa) wire:navigate @endif>
    {{ $slot }}
</a>
