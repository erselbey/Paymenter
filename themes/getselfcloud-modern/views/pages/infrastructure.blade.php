<x-app-layout title="Infrastructure Footprint" description="Global infrastructure overview, inter-region design, and reliability practices for GetSelfCloud deployments.">
    <div class="gsc-page-shell py-8 md:py-10">
        <x-navigation.breadcrumb />

        <section class="gsc-page-hero mt-4">
            <span class="gsc-page-pill">Infrastructure</span>
            <h1 class="mt-3">Global footprint for low-latency application delivery</h1>
            <p class="gsc-page-subtle mt-3 max-w-3xl text-sm md:text-base">
                Designed for production workloads with regional compute pools, private networking, and multi-region recovery paths.
                The map layer on the home page mirrors these city links and inter-region traffic paths.
            </p>
        </section>

        <section class="gsc-page-grid gsc-page-grid--4 mt-6">
            <article class="gsc-page-card gsc-page-kpi">
                <strong>11</strong>
                <span>Active city locations on digital map</span>
            </article>
            <article class="gsc-page-card gsc-page-kpi">
                <strong>5</strong>
                <span>Traffic corridors with packet animation</span>
            </article>
            <article class="gsc-page-card gsc-page-kpi">
                <strong>24/7</strong>
                <span>NOC and on-call response model</span>
            </article>
            <article class="gsc-page-card gsc-page-kpi">
                <strong>N+1</strong>
                <span>Default redundancy on core systems</span>
            </article>
        </section>

        <section class="mt-6">
            <div class="mb-3 flex flex-wrap items-center justify-between gap-3">
                <h2 class="text-xl font-semibold">Key region clusters</h2>
                <span class="gsc-page-pill">Renowned countries and cities</span>
            </div>
            <div class="gsc-page-grid gsc-page-grid--3">
                <article class="gsc-page-card">
                    <h3>North America</h3>
                    <p class="gsc-page-subtle text-sm">San Francisco, Toronto, and New York anchor ingress routing and API traffic handling.</p>
                    <ul class="gsc-page-list">
                        <li>Anycast ingress with regional failover</li>
                        <li>Managed database replicas for burst traffic</li>
                        <li>Edge cache and queue workers for API workloads</li>
                    </ul>
                </article>
                <article class="gsc-page-card">
                    <h3>Europe and Middle East</h3>
                    <p class="gsc-page-subtle text-sm">London, Frankfurt, and Dubai connect core compute with compliance-ready network boundaries.</p>
                    <ul class="gsc-page-list">
                        <li>Primary compute and private backbone transit</li>
                        <li>Managed Kubernetes control plane services</li>
                        <li>Secure VPN gateway mesh for enterprise traffic</li>
                    </ul>
                </article>
                <article class="gsc-page-card">
                    <h3>APAC and Oceania</h3>
                    <p class="gsc-page-subtle text-sm">Mumbai, Singapore, Tokyo, and Sydney support low-latency regional expansion and DR strategy.</p>
                    <ul class="gsc-page-list">
                        <li>Cross-region routing and transit optimization</li>
                        <li>Read replicas and object storage mirrors</li>
                        <li>DR lanes between Singapore and Sydney</li>
                    </ul>
                </article>
            </div>
        </section>

        <section class="gsc-page-grid gsc-page-grid--2 mt-6">
            <article class="gsc-page-card">
                <h3>Network design principles</h3>
                <ul class="gsc-page-list">
                    <li>Traffic enters closest regional edge, then forwards over private lanes.</li>
                    <li>Stateful services use synchronous or asynchronous replication based on latency budget.</li>
                    <li>Each region supports dedicated VPN and firewall boundaries for tenant isolation.</li>
                </ul>
            </article>
            <article class="gsc-page-card">
                <h3>Reliability and operations</h3>
                <ul class="gsc-page-list">
                    <li>Rolling updates and health probes are default for managed workloads.</li>
                    <li>Backup policy templates include daily snapshots and point-in-time restore targets.</li>
                    <li>Runbooks cover failover, traffic rerouting, and post-incident review.</li>
                </ul>
            </article>
        </section>
    </div>
</x-app-layout>
