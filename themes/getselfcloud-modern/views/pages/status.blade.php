<x-app-layout title="Service Status and Reliability" description="Service status posture, incident process, maintenance policy, and SLO framework for GetSelfCloud environments.">
    <div class="gsc-page-shell py-8 md:py-10">
        <x-navigation.breadcrumb />

        <section class="gsc-page-hero mt-4">
            <span class="gsc-page-pill">Status</span>
            <h1 class="mt-3">Reliability model, incident response, and maintenance policy</h1>
            <p class="gsc-page-subtle mt-3 max-w-3xl text-sm md:text-base">
                Operational transparency includes clear availability targets, scheduled maintenance windows,
                and communication steps for incidents and service degradation events.
            </p>
        </section>

        <section class="gsc-page-grid gsc-page-grid--4 mt-6">
            <article class="gsc-page-card gsc-page-kpi">
                <strong>99.99%</strong>
                <span>Target monthly availability for core services</span>
            </article>
            <article class="gsc-page-card gsc-page-kpi">
                <strong>&lt;15 min</strong>
                <span>Initial acknowledgment target for critical alerts</span>
            </article>
            <article class="gsc-page-card gsc-page-kpi">
                <strong>24/7</strong>
                <span>On-call engineering and support rotation</span>
            </article>
            <article class="gsc-page-card gsc-page-kpi">
                <strong>Postmortem</strong>
                <span>Structured review for high-severity incidents</span>
            </article>
        </section>

        <section class="gsc-page-grid gsc-page-grid--2 mt-6">
            <article class="gsc-page-card">
                <h3>Incident lifecycle</h3>
                <ul class="gsc-page-list">
                    <li>Detection via telemetry and customer reports.</li>
                    <li>Impact classification and response team assignment.</li>
                    <li>Mitigation, recovery, and validation against service health checks.</li>
                    <li>Public summary and follow-up actions.</li>
                </ul>
            </article>
            <article class="gsc-page-card">
                <h3>Maintenance policy</h3>
                <ul class="gsc-page-list">
                    <li>Planned changes are announced in advance with expected impact window.</li>
                    <li>Rolling operations are preferred to avoid full-region interruptions.</li>
                    <li>Emergency maintenance follows the same communication and review process.</li>
                </ul>
            </article>
        </section>

        <section class="mt-6 gsc-page-card">
            <h2 class="text-xl font-semibold">Service streams tracked</h2>
            <div class="gsc-page-grid gsc-page-grid--3 mt-4">
                <article>
                    <h3>Compute and hypervisor plane</h3>
                    <ul class="gsc-page-list">
                        <li>Host cluster health and resource pressure alarms</li>
                        <li>Provisioning queue and API control checks</li>
                    </ul>
                </article>
                <article>
                    <h3>Data services</h3>
                    <ul class="gsc-page-list">
                        <li>Database replication lag and failover readiness</li>
                        <li>Backup job completion and restore verification tests</li>
                    </ul>
                </article>
                <article>
                    <h3>Network and edge</h3>
                    <ul class="gsc-page-list">
                        <li>Ingress packet loss and latency anomaly alerts</li>
                        <li>VPN and proxy endpoint continuity monitoring</li>
                    </ul>
                </article>
            </div>
        </section>
    </div>
</x-app-layout>
