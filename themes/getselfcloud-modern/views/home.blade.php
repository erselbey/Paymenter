<div class="container py-8 md:py-12">
    <section class="gsc-hero p-6 md:p-10">
        <div class="gsc-hero-grid">
            <div class="gsc-hero-copy flex flex-col gap-5">
                <span class="gsc-hero-eyebrow">
                    <x-ri-cloud-line class="size-4" />
                    Cloud Infrastructure Platform
                </span>

                <h1 class="gsc-hero-title">
                    Simple cloud hosting for production workloads
                </h1>

                <p class="gsc-hero-lead">
                    Launch KVM VPS, VPN gateways, PROF proxy clusters, and managed databases in minutes with transparent billing and predictable performance.
                </p>

                <article class="prose prose-sm max-w-none dark:prose-invert [&_p]:text-base/75 [&_p]:leading-relaxed">
                    {!! Str::markdown(theme('home_page_text', 'Welcome to Paymenter'), [
                    'allow_unsafe_links' => false,
                    'renderer' => [
                    'soft_break' => "<br>"
                    ]]) !!}
                </article>

                <div class="flex flex-wrap items-center gap-3">
                    <a href="#service-categories">
                        <x-button.primary class="!w-auto !px-5">
                            {{ __('common.button.view_all') }}
                            <x-ri-arrow-right-fill class="size-5" />
                        </x-button.primary>
                    </a>
                    @if ($categories->count() > 0)
                    <a href="{{ route('category.show', ['category' => $categories->first()->slug]) }}" wire:navigate>
                        <x-button.secondary class="!w-auto !px-5">
                            Explore {{ $categories->first()->name }}
                        </x-button.secondary>
                    </a>
                    @endif
                </div>

                <div class="gsc-stat-grid mt-1">
                    <div class="gsc-stat">
                        <strong>{{ $categories->count() }}</strong>
                        <span>Service categories</span>
                    </div>
                    <div class="gsc-stat">
                        <strong>24/7</strong>
                        <span>NOC and support coverage</span>
                    </div>
                    <div class="gsc-stat">
                        <strong>99.99%</strong>
                        <span>SLA target uptime</span>
                    </div>
                </div>
            </div>

            <div class="gsc-hero-panel">
                <div class="gsc-plan-snapshot p-5">
                    <div class="mb-3 flex items-center justify-between">
                        <h3 class="text-lg font-semibold">Popular deployment profiles</h3>
                        <span class="gsc-pill bg-primary/12 text-primary">from $9.99/mo</span>
                    </div>
                    <div class="gsc-plan-list">
                        <div class="gsc-plan-item">
                            <div>
                                <strong>KVM VPS Starter</strong>
                                <p>2 vCPU • 4 GB RAM • 80 GB NVMe</p>
                            </div>
                            <span>$9.99</span>
                        </div>
                        <div class="gsc-plan-item">
                            <div>
                                <strong>WireGuard Business VPN</strong>
                                <p>Private gateway • region failover</p>
                            </div>
                            <span>$19.99</span>
                        </div>
                        <div class="gsc-plan-item">
                            <div>
                                <strong>PostgreSQL Cluster HA</strong>
                                <p>Managed DB • backups • replicas</p>
                            </div>
                            <span>$39.00</span>
                        </div>
                    </div>
                </div>

                <div class="gsc-surface rounded-2xl p-5">
                    <h3 class="text-lg font-semibold">Platform capabilities included</h3>
                    <p class="mt-2 text-sm gsc-subtle">
                        A straightforward cloud control experience inspired by modern infrastructure platforms, designed for quick ordering and clean operations.
                    </p>
                    <div class="mt-4 grid grid-cols-2 gap-3 text-sm">
                        <div class="rounded-xl border border-neutral/70 bg-background/70 p-3">
                            <p class="font-semibold">1-click provisioning</p>
                            <span class="gsc-subtle">Auto-setup from ready templates</span>
                        </div>
                        <div class="rounded-xl border border-neutral/70 bg-background/70 p-3">
                            <p class="font-semibold">Global locations</p>
                            <span class="gsc-subtle">EU and US region availability</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="service-categories" class="mt-8 md:mt-12">
        @php
        $serviceMatrix = collect([
            [
                'name' => 'Cloud VPS Compute',
                'tier' => 'Core',
                'cpu' => '4-32 vCPU',
                'ram' => '8-128 GB DDR5',
                'disk' => '160 GB - 2 TB NVMe RAID10',
                'location' => 'Frankfurt, Amsterdam, Virginia',
                'best_for' => 'SaaS APIs, game backends, CI runners',
            ],
            [
                'name' => 'Managed VPN Gateway',
                'tier' => 'Secure Edge',
                'cpu' => '2-8 vCPU',
                'ram' => '4-32 GB RAM',
                'disk' => '80-320 GB NVMe',
                'location' => 'London, Warsaw, New York',
                'best_for' => 'WireGuard, OpenVPN, remote-office mesh',
            ],
            [
                'name' => 'PROF Proxy Cluster',
                'tier' => 'Traffic',
                'cpu' => '4-16 vCPU',
                'ram' => '8-64 GB RAM',
                'disk' => '120-480 GB NVMe',
                'location' => 'Singapore, Tokyo, Frankfurt',
                'best_for' => 'L7 reverse proxy, edge cache, filtering',
            ],
            [
                'name' => 'Managed Database (DBaaS)',
                'tier' => 'Data',
                'cpu' => '4-24 vCPU',
                'ram' => '16-192 GB RAM',
                'disk' => '500 GB - 8 TB NVMe',
                'location' => 'Amsterdam, Paris, Toronto',
                'best_for' => 'PostgreSQL, MySQL, MariaDB HA clusters',
            ],
            [
                'name' => 'Redis + Queue Nodes',
                'tier' => 'Performance',
                'cpu' => '2-12 vCPU',
                'ram' => '8-96 GB RAM',
                'disk' => '60-400 GB NVMe',
                'location' => 'Frankfurt, Stockholm, Dallas',
                'best_for' => 'Sessions, queues, pub/sub workloads',
            ],
            [
                'name' => 'Object Storage + Backup',
                'tier' => 'Continuity',
                'cpu' => 'Managed service',
                'ram' => 'Managed service',
                'disk' => '1 TB - 100 TB S3-compatible',
                'location' => 'Multi-region replication',
                'best_for' => 'Backups, media libraries, archives',
            ],
        ]);

        $repocloudInspiredApps = [
            'n8n',
            'Grafana',
            'PocketBase',
            'NocoDB',
            'Listmonk',
            'Mattermost',
            'Botpress',
            'ToolJet',
            'Typebot',
            'Coolify',
            'Chatwoot',
            'Directus',
        ];

        $mapNodes = [
            ['id' => 'ams', 'label' => 'Amsterdam', 'x' => 50, 'y' => 33],
            ['id' => 'fra', 'label' => 'Frankfurt', 'x' => 52, 'y' => 35],
            ['id' => 'vir', 'label' => 'Virginia', 'x' => 30, 'y' => 35],
            ['id' => 'sin', 'label' => 'Singapore', 'x' => 73, 'y' => 58],
            ['id' => 'tok', 'label' => 'Tokyo', 'x' => 79, 'y' => 42],
            ['id' => 'sao', 'label' => 'Sao Paulo', 'x' => 36, 'y' => 68],
        ];

        $globalRegions = [
            ['name' => 'Europe', 'detail' => 'Core nodes in Amsterdam and Frankfurt'],
            ['name' => 'Asia', 'detail' => 'Low-latency edge in Singapore and Tokyo'],
            ['name' => 'America', 'detail' => 'Production-ready footprint in Virginia and Sao Paulo'],
        ];

        $cloudPartners = [
            ['name' => 'Yandex Cloud', 'logo' => 'getselfcloud-modern/images/providers/yandex-cloud.svg'],
            ['name' => 'Alibaba Cloud', 'logo' => 'getselfcloud-modern/images/providers/alibaba-cloud.svg'],
            ['name' => 'HUAWEI CLOUD', 'logo' => 'getselfcloud-modern/images/providers/huawei-cloud.svg'],
            ['name' => 'Google Cloud', 'logo' => 'getselfcloud-modern/images/providers/google-cloud.svg'],
            ['name' => 'AWS', 'logo' => 'getselfcloud-modern/images/providers/aws.svg'],
        ];
        @endphp
        <div class="mb-4 flex flex-col gap-2">
            <span class="gsc-pill w-fit bg-primary/12 text-primary">Service Catalog</span>
            <h2 class="text-2xl font-semibold md:text-3xl">Find the right hosting service</h2>
            <p class="max-w-3xl text-sm md:text-base gsc-subtle">
                Compare services by compute profile and deployment region before checkout. Every tier is mapped by CPU, RAM, disk class, and location footprint so teams can size confidently for production from day one.
            </p>
        </div>

        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
            @foreach ($serviceMatrix as $service)
            <article class="gsc-surface rounded-2xl p-5 transition hover:-translate-y-1 hover:border-primary/35">
                <div class="flex items-center justify-between gap-3">
                    <h3 class="text-lg font-semibold">{{ $service['name'] }}</h3>
                    <span class="gsc-pill bg-secondary/15 text-secondary">{{ $service['tier'] }}</span>
                </div>

                <div class="mt-4 grid grid-cols-2 gap-2 text-xs text-base/80 md:text-sm">
                    <div class="rounded-xl border border-neutral/60 bg-background/70 px-3 py-2">
                        <p class="font-semibold">CPU</p>
                        <p>{{ $service['cpu'] }}</p>
                    </div>
                    <div class="rounded-xl border border-neutral/60 bg-background/70 px-3 py-2">
                        <p class="font-semibold">RAM</p>
                        <p>{{ $service['ram'] }}</p>
                    </div>
                    <div class="rounded-xl border border-neutral/60 bg-background/70 px-3 py-2">
                        <p class="font-semibold">Disk</p>
                        <p>{{ $service['disk'] }}</p>
                    </div>
                    <div class="rounded-xl border border-neutral/60 bg-background/70 px-3 py-2">
                        <p class="font-semibold">Location</p>
                        <p>{{ $service['location'] }}</p>
                    </div>
                </div>

                <p class="mt-4 text-sm gsc-subtle">
                    <span class="font-semibold text-base/85">Best for:</span> {{ $service['best_for'] }}
                </p>
            </article>
            @endforeach
        </div>

        <div class="mt-6 gsc-surface rounded-2xl p-5">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <h3 class="text-xl font-semibold">One-click app stack options</h3>
                <span class="gsc-pill bg-primary/12 text-primary">RepoCloud inspired</span>
            </div>
            <p class="mt-2 text-sm gsc-subtle">
                Build bundles around proven services seen in cloud app catalogs and package them with managed database, VPN, and proxy layers for complete production environments.
            </p>
            <div class="mt-4 flex flex-wrap gap-2">
                @foreach ($repocloudInspiredApps as $app)
                <span class="rounded-full border border-neutral/60 bg-background/70 px-3 py-1.5 text-xs font-semibold tracking-wide text-base/80">
                    {{ $app }}
                </span>
                @endforeach
            </div>
        </div>

        <div class="gsc-grid gsc-categories mt-6">
            @foreach ($categories as $category)
            <article class="gsc-category-card flex h-full flex-col gap-4 p-5">
                @if ($category->image)
                <img
                    src="{{ Storage::url($category->image) }}"
                    alt="{{ $category->name }}"
                    class="{{ theme('small_images', false) ? 'h-14 w-14 rounded-xl object-cover' : 'h-44 w-full rounded-2xl object-cover object-center' }}">
                @endif

                <div class="flex items-center justify-between gap-3">
                    <h3 class="text-xl font-semibold">{{ $category->name }}</h3>
                    <span class="gsc-pill bg-primary/12 text-primary">Active</span>
                </div>

                @if(theme('show_category_description', true))
                <article class="prose prose-sm max-w-none dark:prose-invert gsc-subtle">
                    {!! $category->description !!}
                </article>
                @endif

                <a href="{{ route('category.show', ['category' => $category->slug]) }}" wire:navigate class="mt-auto pt-2">
                    <x-button.primary>
                        {{ __('common.button.view_all') }}
                        <x-ri-arrow-right-fill class="size-5" />
                    </x-button.primary>
                </a>
            </article>
            @endforeach
        </div>
    </section>

    <section id="global-coverage" class="mt-10 md:mt-14">
        <div class="mb-4 flex flex-col gap-2">
            <span class="gsc-pill w-fit bg-secondary/15 text-secondary">Global Network</span>
            <h2 class="text-2xl font-semibold md:text-3xl">Worldwide cloud map and region coverage</h2>
            <p class="max-w-3xl text-sm md:text-base gsc-subtle">
                Inspired by modern cloud network views, this map highlights active locations and traffic flow across Europe, Asia, and America regions.
            </p>
        </div>

        <div class="gsc-world-shell">
            <div class="gsc-world-map">
                <img src="{{ asset('getselfcloud-modern/images/world-map.jpg') }}" alt="Global cloud coverage map" class="gsc-world-map-img" />

                <svg class="gsc-world-flow" viewBox="0 0 100 100" preserveAspectRatio="none" aria-hidden="true">
                    <path d="M30,35 C44,20 60,24 73,58" />
                    <path d="M52,35 C58,33 66,33 79,42" />
                    <path d="M36,68 C44,56 48,42 52,35" />
                    <path d="M30,35 C35,33 42,33 50,33" />
                </svg>

                @foreach($mapNodes as $node)
                <div class="gsc-map-node" style="left: {{ $node['x'] }}%; top: {{ $node['y'] }}%;">
                    <span class="gsc-map-dot"></span>
                    <span class="gsc-map-label">{{ $node['label'] }}</span>
                </div>
                @endforeach
            </div>

            <div class="gsc-world-region-list">
                @foreach($globalRegions as $region)
                <article class="gsc-world-region-card">
                    <strong>{{ $region['name'] }}</strong>
                    <p>{{ $region['detail'] }}</p>
                </article>
                @endforeach
            </div>
        </div>
    </section>

    <section id="cloud-providers" class="mt-10 md:mt-14">
        <div class="mb-4 flex flex-col gap-2">
            <span class="gsc-pill w-fit bg-primary/12 text-primary">Cloud Partners</span>
            <h2 class="text-2xl font-semibold md:text-3xl">Built with major cloud providers</h2>
            <p class="max-w-3xl text-sm md:text-base gsc-subtle">
                We work with Yandex Cloud, Alibaba Cloud, HUAWEI CLOUD, Google Cloud, and AWS while operating production infrastructure in Europe, Asia, and America.
            </p>
        </div>

        <div class="gsc-provider-grid">
            @foreach($cloudPartners as $partner)
            <article class="gsc-provider-card">
                <img src="{{ asset($partner['logo']) }}" alt="{{ $partner['name'] }} logo" class="h-12 w-auto object-contain" loading="lazy" />
            </article>
            @endforeach
        </div>

        <div class="mt-5 flex flex-wrap gap-2">
            <span class="gsc-region-pill">Europe Locations</span>
            <span class="gsc-region-pill">Asia Locations</span>
            <span class="gsc-region-pill">America Locations</span>
        </div>
    </section>

    {!! hook('pages.home') !!}
</div>
