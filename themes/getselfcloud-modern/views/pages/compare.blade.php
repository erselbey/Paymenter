<x-app-layout title="Compare with Major Clouds" description="A practical cloud capability comparison for teams evaluating GetSelfCloud against other developer-focused platforms.">
    <div class="gsc-page-shell py-8 md:py-10">
        <x-navigation.breadcrumb />

        <section class="gsc-page-hero mt-4">
            <span class="gsc-page-pill">Comparison</span>
            <h1 class="mt-3">How the platform compares with major developer clouds</h1>
            <p class="gsc-page-subtle mt-3 max-w-3xl text-sm md:text-base">
                This overview is built from publicly documented feature categories from DigitalOcean, UpCloud, and Vultr product pages.
                Use it as a shortlist matrix for technical evaluation and proof-of-concept planning.
            </p>
        </section>

        <section class="mt-6 gsc-page-table-wrap">
            <table class="gsc-page-table">
                <thead>
                    <tr>
                        <th>Capability</th>
                        <th>GetSelfCloud</th>
                        <th>DigitalOcean</th>
                        <th>UpCloud</th>
                        <th>Vultr</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>General purpose compute</td>
                        <td>Yes, KVM VPS tiers</td>
                        <td>Yes</td>
                        <td>Yes</td>
                        <td>Yes</td>
                    </tr>
                    <tr>
                        <td>Managed databases</td>
                        <td>Yes, HA plans</td>
                        <td>Yes</td>
                        <td>Yes</td>
                        <td>Yes</td>
                    </tr>
                    <tr>
                        <td>Object storage</td>
                        <td>Yes, S3-compatible</td>
                        <td>Yes</td>
                        <td>Yes</td>
                        <td>Yes</td>
                    </tr>
                    <tr>
                        <td>One-click app catalog</td>
                        <td>Yes, curated stack presets</td>
                        <td>Yes</td>
                        <td>Partial ecosystem</td>
                        <td>Yes</td>
                    </tr>
                    <tr>
                        <td>Global routing blueprint</td>
                        <td>Digital city map and traffic flows</td>
                        <td>Region-centric</td>
                        <td>Region-centric</td>
                        <td>Region-centric</td>
                    </tr>
                    <tr>
                        <td>Control-plane focus</td>
                        <td>Cost clarity and operational simplicity</td>
                        <td>Developer-first</td>
                        <td>Performance-first</td>
                        <td>Breadth and flexible pricing</td>
                    </tr>
                </tbody>
            </table>
        </section>

        <section class="gsc-page-grid gsc-page-grid--3 mt-6">
            <article class="gsc-page-card">
                <h3>When to pick GetSelfCloud</h3>
                <ul class="gsc-page-list">
                    <li>You need curated stacks with clear region routing patterns.</li>
                    <li>You want one platform for compute, DB, proxy, and operations basics.</li>
                    <li>You prioritize operational clarity over raw product sprawl.</li>
                </ul>
            </article>
            <article class="gsc-page-card">
                <h3>Evaluation flow</h3>
                <ul class="gsc-page-list">
                    <li>Deploy one workload per provider in matched regions.</li>
                    <li>Measure p95 latency, recovery time, and monthly cost envelope.</li>
                    <li>Compare runbook complexity for incident and migration scenarios.</li>
                </ul>
            </article>
            <article class="gsc-page-card">
                <h3>Important note</h3>
                <ul class="gsc-page-list">
                    <li>Provider features and packaging change over time.</li>
                    <li>Validate final capabilities against current vendor documentation before purchase decisions.</li>
                    <li>Use your own workload profile for final benchmarking.</li>
                </ul>
            </article>
        </section>
    </div>
</x-app-layout>
