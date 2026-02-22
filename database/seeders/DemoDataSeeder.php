<?php

namespace Database\Seeders;

use App\Enums\InvoiceTransactionStatus;
use App\Models\Category;
use App\Models\Credit;
use App\Models\CronStat;
use App\Models\Currency;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\InvoiceTransaction;
use App\Models\Order;
use App\Models\Plan;
use App\Models\Price;
use App\Models\Product;
use App\Models\Property;
use App\Models\Role;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Ticket;
use App\Models\TicketMessage;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DemoDataSeeder extends Seeder
{
    private const SENTINEL_KEY = 'demo_data_seeded_v1';

    private int $invoiceNumberCounter = 5000;

    /**
     * Seed a full demo dataset for docker demo environments.
     */
    public function run(): void
    {
        if ($this->alreadySeeded()) {
            $this->command?->info('Demo dataset already exists, skipping.');

            return;
        }

        $this->call([
            CustomPropertySeeder::class,
        ]);

        $currency = Currency::firstOrCreate(
            ['code' => 'USD'],
            [
                'name' => 'US Dollar',
                'prefix' => '$',
                'suffix' => '',
                'format' => '1,000.00',
            ]
        );

        $adminRole = Role::firstOrCreate(
            ['name' => 'admin'],
            ['permissions' => ['*']]
        );

        $admin = User::updateOrCreate(
            ['email' => 'admin@demo.paymenter.local'],
            [
                'first_name' => 'Demo',
                'last_name' => 'Admin',
                'password' => Hash::make('demo-admin-123'),
                'role_id' => $adminRole->id,
                'email_verified_at' => now(),
            ]
        );

        $support = User::updateOrCreate(
            ['email' => 'support@demo.paymenter.local'],
            [
                'first_name' => 'Support',
                'last_name' => 'Agent',
                'password' => Hash::make('demo-support-123'),
                'role_id' => $adminRole->id,
                'email_verified_at' => now(),
            ]
        );

        $clients = $this->seedClients();
        $allUsers = collect([$admin, $support])->merge($clients);
        $this->seedUserProperties($allUsers);

        [$products, $plansByProduct] = Model::withoutEvents(function () use ($currency) {
            return $this->seedCatalog($currency);
        });

        $servicesByUser = Model::withoutEvents(function () use ($clients, $products, $plansByProduct, $currency) {
            return $this->seedCommerce($clients, $products, $plansByProduct, $currency);
        });

        Model::withoutEvents(function () use ($clients, $admin, $support, $servicesByUser) {
            $this->seedTickets($clients, $admin, $support, $servicesByUser);
        });

        $this->seedCredits($clients, $currency);
        $this->seedCronStats();
        $this->seedDemoSettings();
        $this->markSeeded();

        $this->command?->info('Demo dataset seeded.');
    }

    private function alreadySeeded(): bool
    {
        return Setting::where('key', self::SENTINEL_KEY)->exists();
    }

    /**
     * @return Collection<int, User>
     */
    private function seedClients(): Collection
    {
        $clients = collect([
            ['first_name' => 'Alice', 'last_name' => 'Morgan', 'email' => 'alice@demo.paymenter.local'],
            ['first_name' => 'Brian', 'last_name' => 'Hayes', 'email' => 'brian@demo.paymenter.local'],
            ['first_name' => 'Carla', 'last_name' => 'Lopez', 'email' => 'carla@demo.paymenter.local'],
            ['first_name' => 'Derek', 'last_name' => 'Shaw', 'email' => 'derek@demo.paymenter.local'],
            ['first_name' => 'Emma', 'last_name' => 'Patel', 'email' => 'emma@demo.paymenter.local'],
            ['first_name' => 'Frank', 'last_name' => 'Rossi', 'email' => 'frank@demo.paymenter.local'],
            ['first_name' => 'Grace', 'last_name' => 'Nguyen', 'email' => 'grace@demo.paymenter.local'],
            ['first_name' => 'Henry', 'last_name' => 'Clark', 'email' => 'henry@demo.paymenter.local'],
            ['first_name' => 'Ivy', 'last_name' => 'Turner', 'email' => 'ivy@demo.paymenter.local'],
            ['first_name' => 'Jason', 'last_name' => 'Miller', 'email' => 'jason@demo.paymenter.local'],
        ]);

        return $clients->map(function (array $client): User {
            return User::updateOrCreate(
                ['email' => $client['email']],
                [
                    'first_name' => $client['first_name'],
                    'last_name' => $client['last_name'],
                    'password' => Hash::make('demo-client-123'),
                    'email_verified_at' => now(),
                    'role_id' => null,
                ]
            );
        });
    }

    private function seedUserProperties(Collection $users): void
    {
        $customProperties = \App\Models\CustomProperty::whereIn('key', [
            'phone',
            'company_name',
            'address',
            'address2',
            'city',
            'state',
            'zip',
            'country',
        ])->get()->keyBy('key');

        if ($customProperties->isEmpty()) {
            return;
        }

        foreach ($users as $index => $user) {
            $countryValue = in_array($index % 3, [0, 1], true) ? 'United States' : 'Netherlands';
            $values = [
                'phone' => '+1-202-555-' . str_pad((string) (1000 + $index), 4, '0', STR_PAD_LEFT),
                'company_name' => Str::of($user->name)->replace(' ', '') . ' Hosting',
                'address' => (500 + $index) . ' Cloud Avenue',
                'address2' => 'Suite ' . (100 + $index),
                'city' => ['New York', 'Austin', 'Seattle', 'Amsterdam'][$index % 4],
                'state' => ['NY', 'TX', 'WA', 'NH'][$index % 4],
                'zip' => (string) (10000 + $index),
                'country' => $countryValue,
            ];

            foreach ($values as $key => $value) {
                if (!$customProperties->has($key)) {
                    continue;
                }

                $property = $customProperties->get($key);
                Property::updateOrCreate(
                    [
                        'key' => $key,
                        'model_type' => User::class,
                        'model_id' => $user->id,
                    ],
                    [
                        'name' => $property->name,
                        'value' => (string) $value,
                        'custom_property_id' => $property->id,
                    ]
                );
            }
        }
    }

    /**
     * @return array{0: Collection<int, Product>, 1: Collection<int, Collection<int, Plan>>}
     */
    private function seedCatalog(Currency $currency): array
    {
        $rootCategories = [
            [
                'name' => 'Cloud VPS',
                'slug' => 'cloud-vps',
                'description' => 'High-availability virtual servers with instant deployment.',
            ],
            [
                'name' => 'Dedicated Servers',
                'slug' => 'dedicated-servers',
                'description' => 'Bare-metal servers for workloads that need consistent performance.',
            ],
            [
                'name' => 'Web Hosting',
                'slug' => 'web-hosting',
                'description' => 'Managed hosting plans with backups, SSL, and built-in security.',
            ],
            [
                'name' => 'Game Servers',
                'slug' => 'game-servers',
                'description' => 'Low-latency game hosting with automatic updates and DDoS protection.',
            ],
            [
                'name' => 'Network Services',
                'slug' => 'network-services',
                'description' => 'Managed VPN and proxy infrastructure for secure and controlled traffic routing.',
            ],
            [
                'name' => 'Managed Databases',
                'slug' => 'managed-databases',
                'description' => 'Production-ready database clusters with backups, monitoring, and automatic failover.',
            ],
            [
                'name' => 'One-click Apps',
                'slug' => 'one-click-apps',
                'description' => 'Launch popular cloud applications with pre-wired infrastructure and managed updates.',
            ],
        ];

        $categories = [];
        foreach ($rootCategories as $index => $rootCategory) {
            $categories[$rootCategory['slug']] = Category::updateOrCreate(
                ['slug' => $rootCategory['slug']],
                [
                    'name' => $rootCategory['name'],
                    'description' => $rootCategory['description'],
                    'parent_id' => null,
                    'full_slug' => $rootCategory['slug'],
                    'sort' => $index,
                ]
            );
        }

        $childCategories = [
            ['parent' => 'cloud-vps', 'name' => 'KVM VPS', 'slug' => 'kvm-vps', 'description' => 'Dedicated CPU VPS clusters built for production applications.'],
            ['parent' => 'cloud-vps', 'name' => 'Storage VPS', 'slug' => 'storage-vps', 'description' => 'Cost-efficient storage-focused VPS plans with large volume options.'],
            ['parent' => 'dedicated-servers', 'name' => 'GPU Dedicated', 'slug' => 'gpu-dedicated', 'description' => 'GPU-accelerated dedicated servers for rendering and AI workloads.'],
            ['parent' => 'web-hosting', 'name' => 'WordPress Hosting', 'slug' => 'wordpress-hosting', 'description' => 'Optimized stack for fast and secure WordPress websites.'],
            ['parent' => 'game-servers', 'name' => 'Minecraft Hosting', 'slug' => 'minecraft-hosting', 'description' => 'Managed Minecraft nodes with one-click modpack deployment.'],
            ['parent' => 'network-services', 'name' => 'Managed VPN', 'slug' => 'managed-vpn', 'description' => 'Secure WireGuard and OpenVPN gateways with multi-region routing.'],
            ['parent' => 'network-services', 'name' => 'PROF Proxy', 'slug' => 'prof-proxy', 'description' => 'High-throughput reverse proxy and traffic filtering nodes for edge workloads.'],
            ['parent' => 'managed-databases', 'name' => 'PostgreSQL DBaaS', 'slug' => 'postgresql-dbaas', 'description' => 'Managed PostgreSQL clusters with automated backups and HA replication.'],
            ['parent' => 'managed-databases', 'name' => 'MySQL DBaaS', 'slug' => 'mysql-dbaas', 'description' => 'Managed MySQL clusters tuned for transactional applications.'],
            ['parent' => 'one-click-apps', 'name' => 'Automation Apps', 'slug' => 'automation-apps', 'description' => 'Automated workflow and integration platforms ready in minutes.'],
            ['parent' => 'one-click-apps', 'name' => 'Data Apps', 'slug' => 'data-apps', 'description' => 'No-code data platforms and internal tooling apps.'],
            ['parent' => 'one-click-apps', 'name' => 'Monitoring Apps', 'slug' => 'monitoring-apps', 'description' => 'Observability and dashboard stacks for cloud services.'],
            ['parent' => 'one-click-apps', 'name' => 'Collaboration Apps', 'slug' => 'collaboration-apps', 'description' => 'Team messaging and support tools with managed operations.'],
        ];

        foreach ($childCategories as $index => $childCategory) {
            $parent = $categories[$childCategory['parent']];
            $fullSlug = $parent->full_slug . '/' . $childCategory['slug'];
            $categories[$childCategory['slug']] = Category::updateOrCreate(
                ['slug' => $childCategory['slug']],
                [
                    'name' => $childCategory['name'],
                    'description' => $childCategory['description'],
                    'parent_id' => $parent->id,
                    'full_slug' => $fullSlug,
                    'sort' => $index,
                ]
            );
        }

        $catalog = [
            [
                'category' => 'kvm-vps',
                'name' => 'KVM VPS Starter',
                'slug' => 'kvm-vps-starter',
                'description' => '2 vCPU, 4 GB RAM, NVMe storage and full root access.',
                'stock' => 150,
                'plans' => [
                    ['name' => 'Monthly', 'type' => 'recurring', 'period' => 1, 'unit' => 'month', 'price' => 9.99],
                    ['name' => 'Quarterly', 'type' => 'recurring', 'period' => 3, 'unit' => 'month', 'price' => 27.99],
                    ['name' => 'Yearly', 'type' => 'recurring', 'period' => 12, 'unit' => 'month', 'price' => 99.99],
                ],
            ],
            [
                'category' => 'storage-vps',
                'name' => 'Storage VPS Pro',
                'slug' => 'storage-vps-pro',
                'description' => 'Large-capacity storage VPS for backup and archive workloads.',
                'stock' => 120,
                'plans' => [
                    ['name' => 'Monthly', 'type' => 'recurring', 'period' => 1, 'unit' => 'month', 'price' => 12.99],
                    ['name' => 'Semiannual', 'type' => 'recurring', 'period' => 6, 'unit' => 'month', 'price' => 72.50],
                    ['name' => 'Yearly', 'type' => 'recurring', 'period' => 12, 'unit' => 'month', 'price' => 134.00],
                ],
            ],
            [
                'category' => 'gpu-dedicated',
                'name' => 'GPU Dedicated A10',
                'slug' => 'gpu-dedicated-a10',
                'description' => 'Dedicated NVIDIA A10 server for ML inference and rendering.',
                'stock' => 40,
                'plans' => [
                    ['name' => 'Monthly', 'type' => 'recurring', 'period' => 1, 'unit' => 'month', 'price' => 229.00],
                    ['name' => 'Quarterly', 'type' => 'recurring', 'period' => 3, 'unit' => 'month', 'price' => 659.00],
                    ['name' => 'Yearly', 'type' => 'recurring', 'period' => 12, 'unit' => 'month', 'price' => 2499.00],
                ],
            ],
            [
                'category' => 'wordpress-hosting',
                'name' => 'Managed WordPress',
                'slug' => 'managed-wordpress',
                'description' => 'Managed WordPress with daily backups and malware scanning.',
                'stock' => 200,
                'plans' => [
                    ['name' => 'Monthly', 'type' => 'recurring', 'period' => 1, 'unit' => 'month', 'price' => 8.49],
                    ['name' => 'Quarterly', 'type' => 'recurring', 'period' => 3, 'unit' => 'month', 'price' => 23.99],
                    ['name' => 'Yearly', 'type' => 'recurring', 'period' => 12, 'unit' => 'month', 'price' => 84.99],
                ],
            ],
            [
                'category' => 'minecraft-hosting',
                'name' => 'Minecraft Node 8GB',
                'slug' => 'minecraft-node-8gb',
                'description' => 'Optimized Minecraft hosting with premium anti-DDoS filtering.',
                'stock' => 180,
                'plans' => [
                    ['name' => 'Monthly', 'type' => 'recurring', 'period' => 1, 'unit' => 'month', 'price' => 14.99],
                    ['name' => 'Quarterly', 'type' => 'recurring', 'period' => 3, 'unit' => 'month', 'price' => 41.99],
                    ['name' => 'Yearly', 'type' => 'recurring', 'period' => 12, 'unit' => 'month', 'price' => 149.99],
                ],
            ],
            [
                'category' => 'cloud-vps',
                'name' => 'Enterprise Cloud Cluster',
                'slug' => 'enterprise-cloud-cluster',
                'description' => 'Multi-node cloud cluster with private networking and snapshots.',
                'stock' => 35,
                'plans' => [
                    ['name' => 'Monthly', 'type' => 'recurring', 'period' => 1, 'unit' => 'month', 'price' => 79.00],
                    ['name' => 'Semiannual', 'type' => 'recurring', 'period' => 6, 'unit' => 'month', 'price' => 450.00],
                    ['name' => 'Yearly', 'type' => 'recurring', 'period' => 12, 'unit' => 'month', 'price' => 860.00],
                ],
            ],
            [
                'category' => 'managed-vpn',
                'name' => 'WireGuard Business VPN',
                'slug' => 'wireguard-business-vpn',
                'description' => 'Managed WireGuard gateway cluster with policy routing and dedicated egress IP.',
                'stock' => 100,
                'plans' => [
                    ['name' => 'Monthly', 'type' => 'recurring', 'period' => 1, 'unit' => 'month', 'price' => 19.99],
                    ['name' => 'Quarterly', 'type' => 'recurring', 'period' => 3, 'unit' => 'month', 'price' => 56.50],
                    ['name' => 'Yearly', 'type' => 'recurring', 'period' => 12, 'unit' => 'month', 'price' => 209.00],
                ],
            ],
            [
                'category' => 'prof-proxy',
                'name' => 'PROF Proxy Edge',
                'slug' => 'prof-proxy-edge',
                'description' => 'Proxy edge service with caching, WAF rules, and geo-routing for global traffic.',
                'stock' => 90,
                'plans' => [
                    ['name' => 'Monthly', 'type' => 'recurring', 'period' => 1, 'unit' => 'month', 'price' => 24.99],
                    ['name' => 'Quarterly', 'type' => 'recurring', 'period' => 3, 'unit' => 'month', 'price' => 71.99],
                    ['name' => 'Yearly', 'type' => 'recurring', 'period' => 12, 'unit' => 'month', 'price' => 269.00],
                ],
            ],
            [
                'category' => 'postgresql-dbaas',
                'name' => 'PostgreSQL Cluster HA',
                'slug' => 'postgresql-cluster-ha',
                'description' => 'Managed PostgreSQL primary-replica cluster with PITR backups and monitoring.',
                'stock' => 70,
                'plans' => [
                    ['name' => 'Monthly', 'type' => 'recurring', 'period' => 1, 'unit' => 'month', 'price' => 39.00],
                    ['name' => 'Quarterly', 'type' => 'recurring', 'period' => 3, 'unit' => 'month', 'price' => 112.00],
                    ['name' => 'Yearly', 'type' => 'recurring', 'period' => 12, 'unit' => 'month', 'price' => 429.00],
                ],
            ],
            [
                'category' => 'mysql-dbaas',
                'name' => 'MySQL Managed Primary',
                'slug' => 'mysql-managed-primary',
                'description' => 'Managed MySQL service with performance tuning, backups, and alerting.',
                'stock' => 85,
                'plans' => [
                    ['name' => 'Monthly', 'type' => 'recurring', 'period' => 1, 'unit' => 'month', 'price' => 34.00],
                    ['name' => 'Quarterly', 'type' => 'recurring', 'period' => 3, 'unit' => 'month', 'price' => 98.00],
                    ['name' => 'Yearly', 'type' => 'recurring', 'period' => 12, 'unit' => 'month', 'price' => 375.00],
                ],
            ],
            [
                'category' => 'automation-apps',
                'name' => 'n8n Workflow Cloud',
                'slug' => 'n8n-workflow-cloud',
                'description' => 'Managed n8n deployment for low-code workflow automation with secure webhooks.',
                'stock' => 140,
                'plans' => [
                    ['name' => 'Monthly', 'type' => 'recurring', 'period' => 1, 'unit' => 'month', 'price' => 18.50],
                    ['name' => 'Quarterly', 'type' => 'recurring', 'period' => 3, 'unit' => 'month', 'price' => 52.00],
                    ['name' => 'Yearly', 'type' => 'recurring', 'period' => 12, 'unit' => 'month', 'price' => 198.00],
                ],
            ],
            [
                'category' => 'monitoring-apps',
                'name' => 'Grafana Observability Stack',
                'slug' => 'grafana-observability-stack',
                'description' => 'Managed Grafana stack with metrics, logs, and alerting pipelines.',
                'stock' => 110,
                'plans' => [
                    ['name' => 'Monthly', 'type' => 'recurring', 'period' => 1, 'unit' => 'month', 'price' => 21.00],
                    ['name' => 'Quarterly', 'type' => 'recurring', 'period' => 3, 'unit' => 'month', 'price' => 59.00],
                    ['name' => 'Yearly', 'type' => 'recurring', 'period' => 12, 'unit' => 'month', 'price' => 226.00],
                ],
            ],
            [
                'category' => 'data-apps',
                'name' => 'NocoDB Managed Workspace',
                'slug' => 'nocodb-managed-workspace',
                'description' => 'Managed NocoDB workspace with backups and role-based access controls.',
                'stock' => 120,
                'plans' => [
                    ['name' => 'Monthly', 'type' => 'recurring', 'period' => 1, 'unit' => 'month', 'price' => 16.00],
                    ['name' => 'Quarterly', 'type' => 'recurring', 'period' => 3, 'unit' => 'month', 'price' => 45.00],
                    ['name' => 'Yearly', 'type' => 'recurring', 'period' => 12, 'unit' => 'month', 'price' => 172.00],
                ],
            ],
            [
                'category' => 'collaboration-apps',
                'name' => 'Mattermost Team Chat',
                'slug' => 'mattermost-team-chat',
                'description' => 'Managed Mattermost cluster for internal communication and incident channels.',
                'stock' => 130,
                'plans' => [
                    ['name' => 'Monthly', 'type' => 'recurring', 'period' => 1, 'unit' => 'month', 'price' => 17.00],
                    ['name' => 'Quarterly', 'type' => 'recurring', 'period' => 3, 'unit' => 'month', 'price' => 48.00],
                    ['name' => 'Yearly', 'type' => 'recurring', 'period' => 12, 'unit' => 'month', 'price' => 184.00],
                ],
            ],
        ];

        $products = collect();
        $plansByProduct = collect();

        foreach ($catalog as $catalogItem) {
            $category = $categories[$catalogItem['category']];
            $product = Product::updateOrCreate(
                ['slug' => $catalogItem['slug']],
                [
                    'category_id' => $category->id,
                    'name' => $catalogItem['name'],
                    'description' => $catalogItem['description'],
                    'stock' => $catalogItem['stock'],
                    'allow_quantity' => 'disabled',
                    'hidden' => false,
                ]
            );

            $products->push($product);

            $productPlans = collect();
            foreach ($catalogItem['plans'] as $index => $planItem) {
                $plan = Plan::updateOrCreate(
                    [
                        'priceable_type' => Product::class,
                        'priceable_id' => $product->id,
                        'name' => $planItem['name'],
                        'billing_period' => $planItem['period'],
                        'billing_unit' => $planItem['unit'],
                    ],
                    [
                        'type' => $planItem['type'],
                        'sort' => $index,
                    ]
                );

                Price::updateOrCreate(
                    [
                        'plan_id' => $plan->id,
                        'currency_code' => $currency->code,
                    ],
                    [
                        'price' => $planItem['price'],
                        'setup_fee' => 0,
                    ]
                );

                $productPlans->push($plan);
            }

            $plansByProduct->put($product->id, $productPlans);
        }

        return [$products, $plansByProduct];
    }

    /**
     * @param  Collection<int, User>  $clients
     * @param  Collection<int, Product>  $products
     * @param  Collection<int, Collection<int, Plan>>  $plansByProduct
     * @return Collection<int, Collection<int, Service>>
     */
    private function seedCommerce(Collection $clients, Collection $products, Collection $plansByProduct, Currency $currency): Collection
    {
        $servicesByUser = collect();
        $invoiceStatuses = [Invoice::STATUS_PAID, Invoice::STATUS_PENDING, Invoice::STATUS_CANCELLED];

        foreach ($clients as $index => $client) {
            $userServices = collect();

            for ($orderCount = 0; $orderCount < 2; $orderCount++) {
                $order = Order::create([
                    'user_id' => $client->id,
                    'currency_code' => $currency->code,
                    'created_at' => now()->subDays(45 - ($index * 2 + $orderCount)),
                    'updated_at' => now()->subDays(45 - ($index * 2 + $orderCount)),
                ]);

                $servicesInOrder = collect();
                $serviceRows = $orderCount === 0 ? 2 : 1;

                for ($serviceIndex = 0; $serviceIndex < $serviceRows; $serviceIndex++) {
                    $product = $products[($index + $serviceIndex + $orderCount) % $products->count()];
                    $plan = $plansByProduct->get($product->id)[($serviceIndex + $orderCount) % 3];
                    $planPrice = Price::where('plan_id', $plan->id)->where('currency_code', $currency->code)->first();

                    $serviceStatus = [
                        Service::STATUS_ACTIVE,
                        Service::STATUS_PENDING,
                        Service::STATUS_SUSPENDED,
                        Service::STATUS_CANCELLED,
                    ][($index + $serviceIndex + $orderCount) % 4];

                    $createdAt = now()->subDays(40 - ($index + $serviceIndex + $orderCount));
                    $service = Service::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'plan_id' => $plan->id,
                        'quantity' => 1,
                        'price' => $planPrice?->price ?? 0,
                        'status' => $serviceStatus,
                        'user_id' => $client->id,
                        'currency_code' => $currency->code,
                        'expires_at' => $serviceStatus === Service::STATUS_ACTIVE ? now()->addDays(25 + (($index + $serviceIndex) % 20)) : null,
                        'created_at' => $createdAt,
                        'updated_at' => $createdAt,
                    ]);

                    $servicesInOrder->push($service);
                    $userServices->push($service);
                }

                $invoiceStatus = $invoiceStatuses[($index + $orderCount) % count($invoiceStatuses)];
                $invoiceCreatedAt = now()->subDays(35 - ($index + $orderCount));
                $invoice = Invoice::create([
                    'number' => 'D' . str_pad((string) (++$this->invoiceNumberCounter), 7, '0', STR_PAD_LEFT),
                    'user_id' => $client->id,
                    'currency_code' => $currency->code,
                    'due_at' => now()->addDays(($index % 10) - 5),
                    'status' => $invoiceStatus,
                    'created_at' => $invoiceCreatedAt,
                    'updated_at' => $invoiceCreatedAt,
                ]);

                foreach ($servicesInOrder as $service) {
                    InvoiceItem::create([
                        'invoice_id' => $invoice->id,
                        'quantity' => $service->quantity,
                        'price' => $service->price,
                        'description' => $service->product->name . ' - ' . $service->plan->name,
                        'reference_id' => $service->id,
                        'reference_type' => Service::class,
                        'created_at' => $invoiceCreatedAt,
                        'updated_at' => $invoiceCreatedAt,
                    ]);
                }

                $invoice->refresh();
                if ($invoiceStatus === Invoice::STATUS_PAID) {
                    InvoiceTransaction::create([
                        'invoice_id' => $invoice->id,
                        'amount' => $invoice->total,
                        'fee' => round($invoice->total * 0.03, 2),
                        'transaction_id' => 'DEMO-S-' . strtoupper(Str::random(10)),
                        'status' => InvoiceTransactionStatus::Succeeded->value,
                        'is_credit_transaction' => false,
                        'created_at' => $invoiceCreatedAt->copy()->addHours(3),
                        'updated_at' => $invoiceCreatedAt->copy()->addHours(3),
                    ]);
                } elseif ($invoiceStatus === Invoice::STATUS_PENDING) {
                    InvoiceTransaction::create([
                        'invoice_id' => $invoice->id,
                        'amount' => $invoice->total,
                        'fee' => 0,
                        'transaction_id' => 'DEMO-P-' . strtoupper(Str::random(10)),
                        'status' => InvoiceTransactionStatus::Processing->value,
                        'is_credit_transaction' => false,
                        'created_at' => $invoiceCreatedAt->copy()->addHours(2),
                        'updated_at' => $invoiceCreatedAt->copy()->addHours(2),
                    ]);
                } else {
                    InvoiceTransaction::create([
                        'invoice_id' => $invoice->id,
                        'amount' => $invoice->total,
                        'fee' => 0,
                        'transaction_id' => 'DEMO-F-' . strtoupper(Str::random(10)),
                        'status' => InvoiceTransactionStatus::Failed->value,
                        'is_credit_transaction' => false,
                        'created_at' => $invoiceCreatedAt->copy()->addHours(4),
                        'updated_at' => $invoiceCreatedAt->copy()->addHours(4),
                    ]);
                }
            }

            $servicesByUser->put($client->id, $userServices);
        }

        return $servicesByUser;
    }

    /**
     * @param  Collection<int, User>  $clients
     * @param  Collection<int, Collection<int, Service>>  $servicesByUser
     */
    private function seedTickets(Collection $clients, User $admin, User $support, Collection $servicesByUser): void
    {
        $ticketStatuses = ['active', 'replied', 'closed'];
        $priorities = ['low', 'medium', 'high'];
        $departments = ['Billing', 'Technical', 'Abuse'];

        foreach ($clients->take(8) as $index => $client) {
            $userServices = $servicesByUser->get($client->id, collect());
            $linkedService = $userServices->isNotEmpty() ? $userServices[$index % $userServices->count()] : null;
            $createdAt = now()->subDays(18 - $index);

            $ticket = Ticket::create([
                'subject' => 'Demo Ticket #' . str_pad((string) ($index + 1), 3, '0', STR_PAD_LEFT) . ' - ' . $client->first_name,
                'status' => $ticketStatuses[$index % count($ticketStatuses)],
                'priority' => $priorities[$index % count($priorities)],
                'department' => $departments[$index % count($departments)],
                'user_id' => $client->id,
                'assigned_to' => $index % 2 === 0 ? $admin->id : $support->id,
                'service_id' => $linkedService?->id,
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);

            TicketMessage::create([
                'ticket_id' => $ticket->id,
                'user_id' => $client->id,
                'message' => 'Hello team, I need help with service configuration and billing details.',
                'created_at' => $createdAt->copy()->addMinutes(5),
                'updated_at' => $createdAt->copy()->addMinutes(5),
            ]);

            TicketMessage::create([
                'ticket_id' => $ticket->id,
                'user_id' => $index % 2 === 0 ? $admin->id : $support->id,
                'message' => 'Thanks for reaching out. We have reviewed your account and provided the requested update.',
                'created_at' => $createdAt->copy()->addMinutes(30),
                'updated_at' => $createdAt->copy()->addMinutes(30),
            ]);
        }
    }

    /**
     * @param  Collection<int, User>  $clients
     */
    private function seedCredits(Collection $clients, Currency $currency): void
    {
        foreach ($clients as $index => $client) {
            Credit::create([
                'user_id' => $client->id,
                'currency_code' => $currency->code,
                'amount' => [5, 10, 15, 20, 25][$index % 5],
                'created_at' => now()->subDays(15 - ($index % 10)),
                'updated_at' => now()->subDays(15 - ($index % 10)),
            ]);
        }
    }

    private function seedCronStats(): void
    {
        $keys = [
            'invoices_created',
            'orders_cancelled',
            'upgrade_invoices_updated',
            'services_suspended',
            'services_terminated',
            'tickets_closed',
            'email_logs_deleted',
        ];

        for ($day = 0; $day < 30; $day++) {
            $date = now()->subDays($day)->toDateString();
            foreach ($keys as $index => $key) {
                CronStat::updateOrCreate(
                    [
                        'key' => $key,
                        'date' => $date,
                    ],
                    [
                        'value' => 8 + (($day + $index * 3) % 37),
                    ]
                );
            }
        }
    }

    private function seedDemoSettings(): void
    {
        $settings = [
            'company_name' => 'GetSelfCloud Demo',
            'theme' => 'getselfcloud-modern',
            'home_page_enabled' => true,
            'invoice_snapshot' => true,
            'registration_disabled' => false,
            'app_url' => env('APP_URL', 'http://localhost:8080'),
            'default_currency' => 'USD',
        ];

        foreach ($settings as $key => $value) {
            $type = match (true) {
                is_bool($value) => 'boolean',
                default => 'string',
            };

            Setting::updateOrCreate(
                ['key' => $key],
                [
                    'value' => $value,
                    'type' => $type,
                ]
            );
        }
    }

    private function markSeeded(): void
    {
        Setting::updateOrCreate(
            ['key' => self::SENTINEL_KEY],
            [
                'value' => now()->toDateTimeString(),
                'type' => 'string',
            ]
        );
    }
}
