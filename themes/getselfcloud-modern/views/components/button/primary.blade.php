<button 
    {{ $attributes->merge(['class' => 'inline-flex w-full items-center justify-center gap-2 rounded-xl border border-primary/30 bg-gradient-to-r from-primary to-secondary px-4.5 py-2.5 text-sm font-semibold text-white shadow-[0_14px_34px_-18px] shadow-primary/70 transition duration-300 hover:translate-y-[-1px] hover:shadow-[0_20px_38px_-18px] hover:shadow-primary/70 disabled:cursor-not-allowed disabled:opacity-50']) }}>
    @if (isset($type) && $type === 'submit')
        <div role="status" wire:loading>
            <x-ri-loader-5-fill aria-hidden="true" class="size-6 me-2 fill-white animate-spin" />
            <span class="sr-only">Loading...</span>
        </div>
        <div wire:loading.remove>
            {{ $slot }}
        </div>
    @else
        {{ $slot }}
    @endif
</button>
