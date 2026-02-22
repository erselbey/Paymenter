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
        $getselfcloudMapImagePath = public_path('assets/getselfcloud-modern/images/svg-worldmap-dots.png');
        $getselfcloudMapImageUrl = file_exists($getselfcloudMapImagePath)
            ? asset('assets/getselfcloud-modern/images/svg-worldmap-dots.png')
            : 'https://outpost.swisscom.com/images/svg-worldmap-dots.png';

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

        $getselfcloudMapCities = [
            [
                'id' => 'sfo',
                'city' => 'San Francisco',
                'country' => 'USA',
                'region' => 'US West region',
                'x' => 200,
                'y' => 165,
                'delay' => '-0.2s',
                'label_x' => 10,
                'label_y' => -10,
                'tip_x' => 14,
                'tip_y' => -114,
                'services' => [
                    'KVM VPS compute pool',
                    'Anycast edge and VPN',
                    'Nightly backup mirror',
                ],
            ],
            [
                'id' => 'tor',
                'city' => 'Toronto',
                'country' => 'Canada',
                'region' => 'North America core',
                'x' => 250,
                'y' => 140,
                'delay' => '-1.4s',
                'label_x' => 10,
                'label_y' => -10,
                'tip_x' => 14,
                'tip_y' => -114,
                'services' => [
                    'Managed database zone',
                    'Low-latency API nodes',
                    'Object storage replica',
                ],
            ],
            [
                'id' => 'nyc',
                'city' => 'New York',
                'country' => 'USA',
                'region' => 'US East region',
                'x' => 300,
                'y' => 210,
                'delay' => '-0.6s',
                'label_x' => 10,
                'label_y' => 18,
                'tip_x' => 14,
                'tip_y' => -98,
                'services' => [
                    'Ingress and load balancers',
                    'DDoS protected edge',
                    'Realtime queue workers',
                ],
            ],
            [
                'id' => 'sao',
                'city' => 'Sao Paulo',
                'country' => 'Brazil',
                'region' => 'South America edge',
                'x' => 350,
                'y' => 330,
                'delay' => '-1.1s',
                'label_x' => 10,
                'label_y' => 18,
                'tip_x' => 14,
                'tip_y' => -96,
                'services' => [
                    'Regional cache layer',
                    'Traffic acceleration',
                    'Cross-region failover',
                ],
            ],
            [
                'id' => 'lon',
                'city' => 'London',
                'country' => 'United Kingdom',
                'region' => 'Europe gateway',
                'x' => 420,
                'y' => 150,
                'delay' => '-1.0s',
                'label_x' => 10,
                'label_y' => -10,
                'tip_x' => 14,
                'tip_y' => -114,
                'services' => [
                    'Global ingress control',
                    'Managed Kubernetes plane',
                    'Backup restore center',
                ],
            ],
            [
                'id' => 'fra',
                'city' => 'Frankfurt',
                'country' => 'Germany',
                'region' => 'EU central hub',
                'x' => 520,
                'y' => 150,
                'delay' => '-0.8s',
                'label_x' => 10,
                'label_y' => -10,
                'tip_x' => 14,
                'tip_y' => -114,
                'services' => [
                    'Primary compute cluster',
                    'Managed PostgreSQL HA',
                    'Private backbone transit',
                ],
            ],
            [
                'id' => 'dxb',
                'city' => 'Dubai',
                'country' => 'United Arab Emirates',
                'region' => 'Middle East node',
                'x' => 520,
                'y' => 230,
                'delay' => '-1.6s',
                'label_x' => 10,
                'label_y' => 18,
                'tip_x' => 14,
                'tip_y' => -98,
                'services' => [
                    'Secure VPN gateways',
                    'Regional firewall mesh',
                    'Managed DNS resolvers',
                ],
            ],
            [
                'id' => 'mum',
                'city' => 'Mumbai',
                'country' => 'India',
                'region' => 'India core zone',
                'x' => 620,
                'y' => 150,
                'delay' => '-0.4s',
                'label_x' => 10,
                'label_y' => -10,
                'tip_x' => 14,
                'tip_y' => -112,
                'services' => [
                    'High IOPS NVMe pool',
                    'Container registry cache',
                    'Regional observability',
                ],
            ],
            [
                'id' => 'sin',
                'city' => 'Singapore',
                'country' => 'Singapore',
                'region' => 'APAC traffic hub',
                'x' => 720,
                'y' => 175,
                'delay' => '-1.2s',
                'label_x' => -84,
                'label_y' => 18,
                'tip_x' => -220,
                'tip_y' => -98,
                'services' => [
                    'Cross-region routing mesh',
                    'Latency optimized edge',
                    'Multi-cloud private links',
                ],
            ],
            [
                'id' => 'tyo',
                'city' => 'Tokyo',
                'country' => 'Japan',
                'region' => 'North Asia edge',
                'x' => 780,
                'y' => 190,
                'delay' => '-0.9s',
                'label_x' => -58,
                'label_y' => -10,
                'tip_x' => -220,
                'tip_y' => -110,
                'services' => [
                    'AI and GPU ready nodes',
                    'High-speed proxy tier',
                    'Database read replicas',
                ],
            ],
            [
                'id' => 'syd',
                'city' => 'Sydney',
                'country' => 'Australia',
                'region' => 'Oceania edge',
                'x' => 870,
                'y' => 330,
                'delay' => '-1.8s',
                'label_x' => -68,
                'label_y' => 18,
                'tip_x' => -222,
                'tip_y' => -94,
                'services' => [
                    'Disaster recovery node',
                    'Regional storage mirror',
                    'Low-latency app hosting',
                ],
            ],
        ];

        $getselfcloudMapCitiesById = collect($getselfcloudMapCities)->keyBy('id');

        $getselfcloudMapRoutes = [
            ['id' => 'gsc-map-flow-0', 'from' => 'sfo', 'to' => 'lon', 'arc' => -72, 'alt' => false, 'dur' => '7.2s', 'begin' => '0s', 'r' => 3],
            ['id' => 'gsc-map-flow-1', 'from' => 'tor', 'to' => 'fra', 'arc' => -58, 'alt' => true, 'dur' => '6.9s', 'begin' => '-1.8s', 'r' => 2.8],
            ['id' => 'gsc-map-flow-2', 'from' => 'nyc', 'to' => 'lon', 'arc' => -36, 'alt' => false, 'dur' => '5.8s', 'begin' => '-1.1s', 'r' => 2.8],
            ['id' => 'gsc-map-flow-3', 'from' => 'nyc', 'to' => 'sao', 'arc' => 36, 'alt' => true, 'dur' => '7.6s', 'begin' => '-2.5s', 'r' => 2.6],
            ['id' => 'gsc-map-flow-4', 'from' => 'lon', 'to' => 'fra', 'arc' => -16, 'alt' => false, 'dur' => '4.6s', 'begin' => '-0.7s', 'r' => 2.6],
            ['id' => 'gsc-map-flow-5', 'from' => 'fra', 'to' => 'dxb', 'arc' => 24, 'alt' => true, 'dur' => '5.7s', 'begin' => '-1.5s', 'r' => 2.6],
            ['id' => 'gsc-map-flow-6', 'from' => 'fra', 'to' => 'mum', 'arc' => -18, 'alt' => false, 'dur' => '6.1s', 'begin' => '-2.8s', 'r' => 2.6],
            ['id' => 'gsc-map-flow-7', 'from' => 'mum', 'to' => 'sin', 'arc' => -14, 'alt' => true, 'dur' => '5.6s', 'begin' => '-3.4s', 'r' => 2.5],
            ['id' => 'gsc-map-flow-8', 'from' => 'dxb', 'to' => 'sin', 'arc' => 18, 'alt' => false, 'dur' => '6.6s', 'begin' => '-2.2s', 'r' => 2.5],
            ['id' => 'gsc-map-flow-9', 'from' => 'sin', 'to' => 'tyo', 'arc' => -18, 'alt' => false, 'dur' => '4.9s', 'begin' => '-0.9s', 'r' => 2.5],
            ['id' => 'gsc-map-flow-10', 'from' => 'sin', 'to' => 'syd', 'arc' => 34, 'alt' => true, 'dur' => '6.8s', 'begin' => '-3.1s', 'r' => 2.5],
        ];

        $getselfcloudMapFlows = collect($getselfcloudMapRoutes)
            ->map(function (array $route) use ($getselfcloudMapCitiesById) {
                $from = $getselfcloudMapCitiesById->get($route['from']);
                $to = $getselfcloudMapCitiesById->get($route['to']);

                if (! $from || ! $to) {
                    return null;
                }

                $dx = $to['x'] - $from['x'];
                $dy = $to['y'] - $from['y'];
                $arc = $route['arc'] ?? 0;

                $c1x = $from['x'] + ($dx * 0.32);
                $c1y = $from['y'] + ($dy * 0.18) + $arc;
                $c2x = $from['x'] + ($dx * 0.72);
                $c2y = $from['y'] + ($dy * 0.82) + $arc;

                $route['d'] = sprintf(
                    'M%d %d C %.1f %.1f %.1f %.1f %d %d',
                    $from['x'],
                    $from['y'],
                    $c1x,
                    $c1y,
                    $c2x,
                    $c2y,
                    $to['x'],
                    $to['y']
                );

                return $route;
            })
            ->filter()
            ->values()
            ->all();

        $getselfcloudMapPackets = array_map(
            fn (array $flow): array => [
                'flow_id' => $flow['id'],
                'r' => $flow['r'] ?? 2.6,
                'dur' => $flow['dur'] ?? '6.8s',
                'begin' => $flow['begin'] ?? '0s',
            ],
            $getselfcloudMapFlows
        );

        $getselfcloudMapCities = array_map(function (array $city): array {
            $city['tooltip_width'] = $city['tooltip_width'] ?? 212;
            $city['tooltip_height'] = 56 + (count($city['services']) * 15);

            return $city;
        }, $getselfcloudMapCities);

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

        <div class="mt-6 gsc-surface rounded-2xl p-4 md:p-5">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <h3 class="text-xl font-semibold">Digital city communication map</h3>
                <span class="gsc-pill bg-secondary/15 text-secondary">Global links</span>
            </div>
            <p class="mt-2 text-sm gsc-subtle">
                Major cities across renowned countries are connected with live animated routes to visualize real-time communication flow.
            </p>

            <div class="mt-4 gsc-world-map gsc-world-map--network gsc-world-map--getselfcloud">
                <img
                    class="gsc-world-map-image"
                    src="{{ $getselfcloudMapImageUrl }}"
                    alt=""
                    loading="lazy"
                    aria-hidden="true">

                <svg class="gsc-world-overlay" viewBox="0 0 1000 500" preserveAspectRatio="xMidYMid meet" role="img" aria-label="Global city communication map">
                    <defs>
                        <filter id="gsc-node-glow" x="-50%" y="-50%" width="200%" height="200%">
                            <feGaussianBlur stdDeviation="3" result="blur"></feGaussianBlur>
                            <feMerge>
                                <feMergeNode in="blur"></feMergeNode>
                                <feMergeNode in="SourceGraphic"></feMergeNode>
                            </feMerge>
                        </filter>
                        <filter id="gsc-line-glow" x="-20%" y="-20%" width="140%" height="140%">
                            <feGaussianBlur stdDeviation="2" result="blur"></feGaussianBlur>
                            <feMerge>
                                <feMergeNode in="blur"></feMergeNode>
                                <feMergeNode in="SourceGraphic"></feMergeNode>
                            </feMerge>
                        </filter>
                    </defs>

                    <g class="gsc-map-layer">
                        <g class="gsc-map-flows">
                            @foreach($getselfcloudMapFlows as $flow)
                            <path id="{{ $flow['id'] }}" class="gsc-map-flow{{ $flow['alt'] ? ' gsc-map-flow--alt' : '' }}" d="{{ $flow['d'] }}"></path>
                            @endforeach
                        </g>

                        <g class="gsc-map-locations">
                            @foreach($getselfcloudMapCities as $city)
                            <g class="gsc-map-location" tabindex="0">
                                <title>{{ $city['city'] }}, {{ $city['country'] }} | {{ $city['region'] }}</title>
                                <circle class="gsc-map-location-hit" cx="{{ $city['x'] }}" cy="{{ $city['y'] }}" r="13"></circle>
                                <circle class="gsc-map-node-dot" cx="{{ $city['x'] }}" cy="{{ $city['y'] }}" r="3.1" style="--node-delay: {{ $city['delay'] }};"></circle>
                                <text class="gsc-map-city-label" x="{{ $city['x'] + $city['label_x'] }}" y="{{ $city['y'] + $city['label_y'] }}">{{ $city['city'] }}</text>

                                <g class="gsc-map-city-tooltip" transform="translate({{ $city['x'] + $city['tip_x'] }} {{ $city['y'] + $city['tip_y'] }})">
                                    <rect class="gsc-map-city-tooltip-card" width="{{ $city['tooltip_width'] }}" height="{{ $city['tooltip_height'] }}" rx="10" ry="10"></rect>
                                    <text class="gsc-map-city-tooltip-title" x="12" y="20">{{ $city['city'] }}, {{ $city['country'] }}</text>
                                    <text class="gsc-map-city-tooltip-meta" x="12" y="36">{{ $city['region'] }}</text>
                                    @foreach($city['services'] as $serviceIndex => $service)
                                    <text class="gsc-map-city-tooltip-line" x="12" y="{{ 54 + ($serviceIndex * 14) }}">- {{ $service }}</text>
                                    @endforeach
                                </g>
                            </g>
                            @endforeach
                        </g>

                        <g class="gsc-map-packets">
                            @foreach($getselfcloudMapPackets as $packet)
                            <circle class="gsc-world-packet" r="{{ $packet['r'] }}">
                                <animateMotion dur="{{ $packet['dur'] }}" begin="{{ $packet['begin'] }}" repeatCount="indefinite">
                                    <mpath href="#{{ $packet['flow_id'] }}"></mpath>
                                </animateMotion>
                            </circle>
                            @endforeach
                        </g>
                    </g>
                </svg>
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

    {!! hook('pages.home') !!}
</div>
