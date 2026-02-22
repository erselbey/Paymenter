# Paymenter Demo Stack

This repository includes a dedicated demo stack with preloaded data.

## Start

```bash
docker compose -f docker-compose.demo.yml up --build -d
```

## Access

- Paymenter: http://localhost:8080
- Adminer (database UI): http://localhost:8081

## Demo Credentials

- Admin: `admin@demo.paymenter.local` / `demo-admin-123`
- Support Admin: `support@demo.paymenter.local` / `demo-support-123`
- Client users: `alice@demo.paymenter.local` ... `jason@demo.paymenter.local`
- Client password: `demo-client-123`

## What is Seeded

- Roles and users (admin, support, multiple clients)
- Custom user properties (address/company/country/etc.)
- Category and product catalog with multiple plans/prices
- Extra service lines: managed VPN, PROF proxy, managed DBaaS (PostgreSQL/MySQL)
- One-click app style services inspired by RepoCloud catalog entries (n8n, Grafana, NocoDB, Mattermost)
- Orders, services, invoices, invoice items, and payment transactions
- Tickets and ticket conversations
- Credits and cron stats
- Theme switched to `getselfcloud-modern`

## Reset Demo Data

```bash
docker compose -f docker-compose.demo.yml down -v
docker compose -f docker-compose.demo.yml up --build -d
```
