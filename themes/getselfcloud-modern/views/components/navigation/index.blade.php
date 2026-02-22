<nav class="fixed inset-x-0 top-0 z-30 px-3 pt-3 lg:px-8">
    <div
        x-data="{
            slideOverOpen: false,
            hasAside: !!document.getElementById('main-aside')
        }"
        x-init="$watch('slideOverOpen', value => { document.documentElement.style.overflow = value ? 'hidden' : '' })"
        class="relative">
        <div
            class="gsc-nav-shell flex h-16 items-center justify-between px-3 md:px-5"
            :class="hasAside ? 'w-full' : 'container'">
            <div class="flex min-w-0 items-center gap-3 md:gap-4">
                <a href="{{ route('home') }}" class="flex shrink-0 items-center gap-2" wire:navigate>
                    <x-logo class="h-9" />
                </a>

                <div class="hidden items-center gap-1 overflow-visible md:flex">
                    @foreach (\App\Classes\Navigation::getLinks() as $nav)
                    @if (isset($nav['children']) && count($nav['children']) > 0)
                    <x-dropdown :showArrow="false" :width="$nav['dropdown_width'] ?? 'w-56'">
                        <x-slot:trigger>
                            <span class="gsc-nav-link inline-flex cursor-pointer items-center gap-1 whitespace-nowrap">
                                {{ $nav['name'] }}
                                <x-ri-arrow-down-s-line class="size-4" />
                            </span>
                        </x-slot:trigger>
                        <x-slot:content>
                            <div class="{{ (($nav['dropdown_columns'] ?? 1) > 1) ? 'grid grid-cols-2 gap-1.5' : 'grid gap-1' }}">
                                @foreach ($nav['children'] as $child)
                                <a
                                    href="{{ $child['url'] }}"
                                    class="gsc-nav-child"
                                    @if(isset($child['spa']) ? $child['spa'] : true) wire:navigate @endif
                                >
                                    <span class="gsc-nav-child-title">{{ $child['name'] }}</span>
                                    @if (!empty($child['description']))
                                    <span class="gsc-nav-child-description">{{ $child['description'] }}</span>
                                    @endif
                                </a>
                                @endforeach
                            </div>
                        </x-slot:content>
                    </x-dropdown>
                    @else
                    <x-navigation.link
                        :href="$nav['url']"
                        :spa="isset($nav['spa']) ? $nav['spa'] : true"
                        class="gsc-nav-link !p-2">
                        {{ $nav['name'] }}
                    </x-navigation.link>
                    @endif
                    @endforeach
                </div>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('pages.platform') }}" class="hidden xl:inline-flex gsc-nav-cta" wire:navigate>
                    Explore Platform
                </a>

                <livewire:components.cart />

                <div class="hidden items-center gap-1 rounded-full border border-neutral/60 bg-background/70 px-1 py-1 md:flex">
                    <livewire:components.locale-switch />
                    <x-theme-toggle />
                </div>

                @if(auth()->check())
                <livewire:components.notifications />
                <div class="hidden lg:flex">
                    <x-dropdown align="right" :showArrow="false">
                        <x-slot:trigger>
                            <img src="{{ auth()->user()->avatar }}" class="size-9 rounded-full border border-neutral bg-background" alt="avatar" />
                        </x-slot:trigger>
                        <x-slot:content>
                            <div class="flex flex-col p-2">
                                <span class="break-words text-sm text-base">{{ auth()->user()->name }}</span>
                                <span class="break-words text-sm text-base">{{ auth()->user()->email }}</span>
                            </div>
                            @foreach (\App\Classes\Navigation::getAccountDropdownLinks() as $nav)
                            <x-navigation.link :href="$nav['url']" :spa="isset($nav['spa']) ? $nav['spa'] : true">
                                {{ $nav['name'] }}
                            </x-navigation.link>
                            @endforeach
                            <livewire:auth.logout />
                        </x-slot:content>
                    </x-dropdown>
                </div>
                @else
                <div class="hidden items-center gap-2 lg:flex">
                    <a href="{{ route('login') }}" wire:navigate>
                        <x-button.secondary class="!w-auto !px-4">
                            {{ __('navigation.login') }}
                        </x-button.secondary>
                    </a>
                    @if(!config('settings.registration_disabled', false))
                    <a href="{{ route('register') }}" wire:navigate>
                        <x-button.primary class="!w-auto !px-4">
                            {{ __('navigation.register') }}
                        </x-button.primary>
                    </a>
                    @endif
                </div>
                @endif

                <button
                    @click="slideOverOpen = !slideOverOpen"
                    class="relative flex size-10 items-center justify-center rounded-lg border border-neutral/70 bg-background/70 transition hover:border-primary/40 lg:hidden"
                    aria-label="Toggle Menu">
                    <span
                        x-show="!slideOverOpen"
                        x-transition:enter="transition duration-300"
                        x-transition:enter-start="opacity-0 -rotate-90 scale-75"
                        x-transition:enter-end="opacity-100 rotate-0 scale-100"
                        x-transition:leave="transition duration-150"
                        x-transition:leave-start="opacity-100 rotate-0 scale-100"
                        x-transition:leave-end="opacity-0 rotate-90 scale-75"
                        class="absolute inset-0 flex items-center justify-center"
                        aria-hidden="true">
                        <x-ri-menu-fill class="size-5" />
                    </span>

                    <span
                        x-show="slideOverOpen"
                        x-transition:enter="transition duration-300"
                        x-transition:enter-start="opacity-0 rotate-90 scale-75"
                        x-transition:enter-end="opacity-100 rotate-0 scale-100"
                        x-transition:leave="transition duration-150"
                        x-transition:leave-start="opacity-100 rotate-0 scale-100"
                        x-transition:leave-end="opacity-0 -rotate-90 scale-75"
                        class="absolute inset-0 flex items-center justify-center"
                        aria-hidden="true">
                        <x-ri-close-fill class="size-5" />
                    </span>
                </button>
            </div>
        </div>

        <template x-teleport="body">
            <div
                x-show="slideOverOpen"
                @keydown.window.escape="slideOverOpen = false"
                x-cloak
                class="fixed inset-0 z-[90]"
                aria-modal="true"
                tabindex="-1">
                <div
                    x-show="slideOverOpen"
                    x-transition.opacity.duration.250ms
                    @click="slideOverOpen = false"
                    class="absolute inset-0 bg-background/60 backdrop-blur-sm"></div>

                <div
                    x-show="slideOverOpen"
                    x-transition:enter="transition duration-250"
                    x-transition:enter-start="opacity-0 -translate-y-4"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 -translate-y-4"
                    class="absolute inset-x-3 top-20 max-h-[calc(100dvh-6rem)] overflow-y-auto rounded-2xl border border-neutral/70 bg-background-secondary p-4 shadow-2xl">
                    <div class="flex flex-col gap-2">
                        <x-navigation.sidebar-links />
                    </div>

                    <div class="mt-6 border-t border-neutral/70 pt-4">
                        @if(auth()->check())
                        <div class="mb-4 flex items-center gap-3">
                            <img src="{{ auth()->user()->avatar }}" class="size-11 rounded-full border border-neutral bg-background" alt="avatar" />
                            <div class="flex flex-col gap-0.5">
                                <span class="font-semibold">{{ auth()->user()->name }}</span>
                                <span class="text-sm text-base/70">{{ auth()->user()->email }}</span>
                            </div>
                        </div>
                        <div class="flex flex-col gap-2">
                            @foreach (\App\Classes\Navigation::getAccountDropdownLinks() as $nav)
                            <x-navigation.link :href="$nav['url']" :spa="isset($nav['spa']) ? $nav['spa'] : true">
                                {{ $nav['name'] }}
                            </x-navigation.link>
                            @endforeach
                            <livewire:auth.logout />
                        </div>
                        @else
                        <div class="flex flex-col gap-2">
                            @if(!config('settings.registration_disabled', false))
                            <a href="{{ route('register') }}" wire:navigate>
                                <x-button.primary>
                                    {{ __('navigation.register') }}
                                </x-button.primary>
                            </a>
                            @endif
                            <a href="{{ route('login') }}" wire:navigate>
                                <x-button.secondary>
                                    {{ __('navigation.login') }}
                                </x-button.secondary>
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </template>
    </div>
</nav>
