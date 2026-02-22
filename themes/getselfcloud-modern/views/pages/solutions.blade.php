<x-app-layout title="Workload Blueprints" description="Deployment blueprints for SaaS, AI APIs, eCommerce, and high-traffic web workloads on GetSelfCloud.">
    <div class="gsc-page-shell py-8 md:py-10">
        <x-navigation.breadcrumb />

        <section class="gsc-page-hero mt-4">
            <span class="gsc-page-pill">Solutions</span>
            <h1 class="mt-3">Reference blueprints for common production workloads</h1>
            <p class="gsc-page-subtle mt-3 max-w-3xl text-sm md:text-base">
                Build faster with pre-modeled solution patterns. Each blueprint includes suggested regions,
                service composition, and scaling guidance.
            </p>
        </section>

        <section class="gsc-page-grid gsc-page-grid--2 mt-6">
            <article class="gsc-page-card">
                <h3>SaaS control panel stack</h3>
                <p class="gsc-page-subtle text-sm">Best for B2B SaaS products with web, API, and billing workflows.</p>
                <ul class="gsc-page-list">
                    <li>App nodes in London + Frankfurt with active-passive failover</li>
                    <li>Managed PostgreSQL HA and Redis queue workers</li>
                    <li>Object storage for assets, exports, and backups</li>
                </ul>
            </article>
            <article class="gsc-page-card">
                <h3>AI inference API</h3>
                <p class="gsc-page-subtle text-sm">Optimized for region-aware inference endpoints and burst traffic.</p>
                <ul class="gsc-page-list">
                    <li>GPU-ready compute nodes in Tokyo and Frankfurt</li>
                    <li>Traffic shaping via managed proxy layer</li>
                    <li>Queue buffering and caching to stabilize latency</li>
                </ul>
            </article>
            <article class="gsc-page-card">
                <h3>Global eCommerce platform</h3>
                <p class="gsc-page-subtle text-sm">Built for storefront response time and checkout reliability.</p>
                <ul class="gsc-page-list">
                    <li>Regional app edges in New York, London, Singapore</li>
                    <li>Database replicas by read-heavy traffic geography</li>
                    <li>Integrated WAF and DDoS guard perimeter</li>
                </ul>
            </article>
            <article class="gsc-page-card">
                <h3>Media and event streaming backend</h3>
                <p class="gsc-page-subtle text-sm">Low-latency ingest and distribution using distributed worker pools.</p>
                <ul class="gsc-page-list">
                    <li>Ingress relays near source regions</li>
                    <li>Object storage lifecycle and archival policies</li>
                    <li>Message queue fan-out for asynchronous processing</li>
                </ul>
            </article>
        </section>

        <section class="mt-6 gsc-page-card">
            <h2 class="text-xl font-semibold">Implementation checklist</h2>
            <div class="gsc-page-grid gsc-page-grid--3 mt-4">
                <article>
                    <h3>1. Choose region topology</h3>
                    <ul class="gsc-page-list">
                        <li>Pick primary and DR regions based on user concentration.</li>
                        <li>Define RTO and RPO targets before provisioning.</li>
                    </ul>
                </article>
                <article>
                    <h3>2. Select managed dependencies</h3>
                    <ul class="gsc-page-list">
                        <li>Pair app stack with managed database and cache tier.</li>
                        <li>Apply backup and retention policies from day one.</li>
                    </ul>
                </article>
                <article>
                    <h3>3. Run production readiness checks</h3>
                    <ul class="gsc-page-list">
                        <li>Enable health probes, alert routing, and deployment rollback plans.</li>
                        <li>Validate failover path using a controlled game-day drill.</li>
                    </ul>
                </article>
            </div>
        </section>
    </div>
</x-app-layout>
