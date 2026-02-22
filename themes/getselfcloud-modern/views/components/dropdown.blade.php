@props([
    'width' => null,
    'content' => null,
    'trigger' => null,
    'showArrow' => true,
    'align' => 'left',
])
@php
$alignmentClasses = $align === 'right'
    ? 'right-0 origin-top-right'
    : 'left-0 origin-top-left';
@endphp
<div
    class="relative"
    x-data="{
        open: false,
        id: $id('dropdown'),
        toggle() {
            this.open = !this.open;
            if (this.open) {
                this.$dispatch('gsc-dropdown-opened', { id: this.id });
            }
        },
        close() {
            this.open = false;
        },
    }"
    x-on:gsc-dropdown-opened.window="if ($event.detail.id !== id) close()"
    x-on:focusin.window="if (open && !$refs.dropdown.contains($event.target) && !$refs.trigger.contains($event.target)) close()"
>

    <button
        type="button"
        x-ref="trigger"
        class="flex flex-row items-center px-2 py-1 text-sm font-semibold whitespace-nowrap text-base hover:text-base/80"
        x-on:click.stop.prevent="toggle()"
        x-on:keydown.escape.stop.prevent="close()"
        x-bind:aria-expanded="open.toString()"
        aria-haspopup="true">
        {{ $trigger }}
        @if($showArrow)
        <x-ri-arrow-down-s-line x-bind:class="{ '-rotate-180' : open }"
            class="md:block hidden size-4 text-base ease-out duration-300" />
        @endif
    </button>

    <div x-ref="dropdown"
        class="absolute mt-2 {{ $alignmentClasses }} {{ $width ?? "w-48" }} px-2 py-1 bg-background-secondary rounded-md shadow-lg z-[90] border border-neutral"
        x-show="open"
        x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 scale-90"
        x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90"
        x-on:click.outside="close()"
        x-on:keydown.escape.stop.prevent="close()"
        x-cloak>
        {{ $content }}
    </div>
</div>
