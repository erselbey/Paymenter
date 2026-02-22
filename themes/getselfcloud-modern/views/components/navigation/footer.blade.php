<footer class="w-full px-4 pb-8 pt-20 md:pt-28">
    <div class="container">
        <div class="gsc-footer-shell p-6 md:p-9">
            <div class="gsc-footer-grid">
                <div class="flex flex-col gap-4">
                    <div class="flex items-center gap-2">
                        <x-logo class="h-10" />
                        @if(theme('logo_display', 'logo-and-name') != 'logo-only')
                        <span class="text-xl font-bold leading-none">{{ config('app.name') }}</span>
                        @endif
                    </div>
                    <p class="max-w-sm text-sm gsc-subtle">
                        Simple, modern cloud infrastructure for teams that want reliable performance, clear pricing, and production-ready deployment from day one.
                    </p>

                    <div class="gsc-footer-badges">
                        <span>99.99% SLA Target</span>
                        <span>24/7 Support Desk</span>
                        <span>EU + US Regions</span>
                    </div>

                    <div class="gsc-footer-contact">
                        <a href="mailto:sales@getselfcloud.com">
                            <x-ri-mail-line class="size-4" />
                            sales@getselfcloud.com
                        </a>
                        <a href="mailto:support@getselfcloud.com">
                            <x-ri-customer-service-2-line class="size-4" />
                            support@getselfcloud.com
                        </a>
                        <a href="{{ route('home') }}#service-categories">
                            <x-ri-stack-line class="size-4" />
                            Explore infrastructure catalog
                        </a>
                    </div>
                </div>

                <div class="gsc-footer-links">
                    <h4 class="text-sm font-semibold uppercase tracking-[0.14em] text-base/70">Platform</h4>
                    <a href="{{ route('home') }}#service-categories">KVM VPS and Compute</a>
                    <a href="{{ route('home') }}#service-categories">Managed VPN and Proxy</a>
                    <a href="{{ route('home') }}#service-categories">Managed Database Services</a>
                    <a href="{{ route('home') }}#service-categories">One-click App Stacks</a>
                </div>

                <div class="gsc-footer-links">
                    <h4 class="text-sm font-semibold uppercase tracking-[0.14em] text-base/70">Navigation</h4>
                    @foreach (\App\Classes\Navigation::getLinks() as $nav)
                    @if (isset($nav['children']) && count($nav['children']) > 0)
                    @foreach ($nav['children'] as $child)
                    <a href="{{ $child['url'] }}" @if(isset($child['spa']) ? $child['spa'] : true) wire:navigate @endif>{{ $child['name'] }}</a>
                    @endforeach
                    @else
                    <a href="{{ $nav['url'] }}" @if(isset($nav['spa']) ? $nav['spa'] : true) wire:navigate @endif>{{ $nav['name'] }}</a>
                    @endif
                    @endforeach
                </div>

                <div class="gsc-footer-links">
                    <h4 class="text-sm font-semibold uppercase tracking-[0.14em] text-base/70">Account and Legal</h4>
                    @auth
                    @foreach (\App\Classes\Navigation::getAccountDropdownLinks() as $nav)
                    <a href="{{ $nav['url'] }}" @if(isset($nav['spa']) ? $nav['spa'] : true) wire:navigate @endif>{{ $nav['name'] }}</a>
                    @endforeach
                    @else
                    <a href="{{ route('login') }}" wire:navigate>{{ __('navigation.login') }}</a>
                    @if(!config('settings.registration_disabled', false))
                    <a href="{{ route('register') }}" wire:navigate>{{ __('navigation.register') }}</a>
                    @endif
                    @endauth
                    @if (config('settings.tos'))
                    <a href="{{ config('settings.tos') }}" target="_blank" rel="noopener">Terms of Service</a>
                    @endif
                    <a href="https://status.getselfcloud.com" target="_blank" rel="noopener">Status Page</a>
                    <a href="https://docs.getselfcloud.com" target="_blank" rel="noopener">Documentation</a>
                </div>
            </div>

            <div class="gsc-footer-region-grid">
                <div class="gsc-footer-region-card">
                    <strong>Amsterdam</strong>
                    <span>Primary cloud region</span>
                </div>
                <div class="gsc-footer-region-card">
                    <strong>Frankfurt</strong>
                    <span>Low-latency EU core</span>
                </div>
                <div class="gsc-footer-region-card">
                    <strong>Virginia</strong>
                    <span>US East production</span>
                </div>
                <div class="gsc-footer-region-card">
                    <strong>Singapore</strong>
                    <span>APAC edge workloads</span>
                </div>
            </div>

            <div class="mt-8 flex flex-col gap-3 border-t border-neutral/60 pt-5 text-sm text-base/70 md:flex-row md:items-center md:justify-between">
                <p>{{ __(':year :app_name. All rights reserved.', ['year' => date('Y'), 'app_name' => config('app.name')]) }}</p>
                <a class="inline-flex items-center gap-1.5 rounded-lg border border-neutral/70 bg-background/60 px-3 py-1.5 transition hover:border-primary/35 hover:text-primary" href="https://paymenter.org" target="_blank" rel="noopener">
                    <span>{{ __('Powered by') }}</span>
                    <span class="font-semibold">GetSelfCloud</span>
                </a>
            </div>
        </div>
    </div>
</footer>
