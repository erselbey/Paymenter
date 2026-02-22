<x-app-layout title="Cloud Platform" description="Compute, managed database, networking, and one-click stack capabilities of GetSelfCloud platform.">
    <div class="gsc-page-shell py-8 md:py-10">
        <x-navigation.breadcrumb />

        <section class="gsc-page-hero mt-4">
            <span class="gsc-page-pill">Platform</span>
            <h1 class="mt-3">Build production systems with modular cloud primitives</h1>
            <p class="gsc-page-subtle mt-3 max-w-3xl text-sm md:text-base">
                The platform combines cloud compute, managed services, and one-click app stacks so teams can go from zero to production
                without stitching multiple providers together.
            </p>
        </section>

        <section class="mt-6">
            <div class="mb-3 flex flex-wrap items-center justify-between gap-3">
                <h2 class="text-xl font-semibold">Core product layers</h2>
                <span class="gsc-page-pill">Inspired by leading cloud catalogs</span>
            </div>
            <div class="gsc-page-grid gsc-page-grid--3">
                <article class="gsc-page-card">
                    <h3>Compute and networking</h3>
                    <p class="gsc-page-subtle text-sm">KVM VPS pools, private networking, and ingress controls for low-latency traffic management.</p>
                    <ul class="gsc-page-list">
                        <li>Elastic compute nodes with NVMe tiers</li>
                        <li>Private VPC-style segmentation</li>
                        <li>Managed VPN and proxy edges</li>
                    </ul>
                </article>
                <article class="gsc-page-card">
                    <h3>Data and storage</h3>
                    <p class="gsc-page-subtle text-sm">Managed PostgreSQL/MySQL clusters, Redis nodes, and object storage replication options.</p>
                    <ul class="gsc-page-list">
                        <li>Automated backups and restore plans</li>
                        <li>High-availability database topology</li>
                        <li>S3-compatible storage endpoints</li>
                    </ul>
                </article>
                <article class="gsc-page-card">
                    <h3>Application delivery</h3>
                    <p class="gsc-page-subtle text-sm">One-click stacks and deployment templates for common production application topologies.</p>
                    <ul class="gsc-page-list">
                        <li>Template-driven app deployments</li>
                        <li>Built-in observability primitives</li>
                        <li>Versioned rollout and rollback process</li>
                    </ul>
                </article>
            </div>
        </section>

        <section class="gsc-page-grid gsc-page-grid--2 mt-6">
            <article class="gsc-page-card">
                <h3>One-click app stacks</h3>
                <p class="gsc-page-subtle text-sm">Fast deploy options based on widely used open-source app ecosystems.</p>
                <div class="mt-3 flex flex-wrap gap-2">
                    @foreach (['n8n', 'Grafana', 'Chatwoot', 'Directus', 'NocoDB', 'Coolify', 'Mattermost', 'ToolJet'] as $stack)
                    <span class="rounded-full border border-neutral/65 bg-background/70 px-3 py-1.5 text-xs font-semibold tracking-wide text-base/85">{{ $stack }}</span>
                    @endforeach
                </div>
            </article>
            <article class="gsc-page-card">
                <h3>Operations baseline</h3>
                <ul class="gsc-page-list">
                    <li>Provisioning templates for repeatable region launches</li>
                    <li>Centralized logs, metrics, and alerting hooks</li>
                    <li>Environment-aware runbooks for staging and production</li>
                    <li>Cost-aware sizing guidance across instance tiers</li>
                </ul>
            </article>
        </section>

        <section class="gsc-page-grid gsc-page-grid--4 mt-6">
            <article class="gsc-page-card gsc-page-kpi">
                <strong>&lt;5 min</strong>
                <span>Typical one-click deployment bootstrap</span>
            </article>
            <article class="gsc-page-card gsc-page-kpi">
                <strong>99.99%</strong>
                <span>Service-level availability target</span>
            </article>
            <article class="gsc-page-card gsc-page-kpi">
                <strong>24/7</strong>
                <span>Operational support coverage</span>
            </article>
            <article class="gsc-page-card gsc-page-kpi">
                <strong>API-first</strong>
                <span>Automation-friendly control model</span>
            </article>
        </section>
    </div>
</x-app-layout>
