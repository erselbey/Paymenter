<button 
    {{ $attributes->merge(['class' => 'inline-flex w-full items-center justify-center gap-2 rounded-xl border border-neutral/70 bg-background/70 px-4.5 py-2.5 text-sm font-semibold text-base dark:text-white transition duration-300 hover:border-primary/45 hover:bg-background-secondary/95 hover:text-primary disabled:cursor-not-allowed disabled:opacity-50']) }}>
    @if (isset($type) && $type === 'submit')
        <div role="status" wire:loading>
            <x-ri-loader-5-fill aria-hidden="true" class="size-6 me-2 fill-base animate-spin" />
            <span class="sr-only">Loading...</span>
        </div>
        <div wire:loading.remove>
            {{ $slot }}
        </div>
    @else
        {{ $slot }}
    @endif
</button>
