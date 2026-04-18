# TaskFlow — SaaS Project Management Tool

A fully-featured Laravel SaaS application with **multi-tenancy**, **Kanban boards**, **team collaboration**, and **Stripe billing**.

## 🎯 Features

### Core
- ✅ User authentication & email verification (Breeze v2.4)
- ✅ Teams (multi-tenancy) with roles: Owner, Admin, Member
- ✅ Free/Pro/Business plans with feature limits
- ✅ Stripe integration (Cashier v16) for subscriptions

### Projects & Boards
- ✅ Create projects → boards → columns → tasks (Kanban structure)
- ✅ Drag & drop tasks between columns (SortableJS)
- ✅ Real-time task editing (Livewire with wire:model.live)
- ✅ Task priorities, assignees, due dates, descriptions

### Team Management
- ✅ Invite team members by email
- ✅ Assign roles (member/admin) with fine-grained permissions
- ✅ Activity log (who did what, when)
- ✅ Plan usage tracking (3/20 projects, 2/10 members, etc.)

### Billing & Plans
- ✅ Plan selection on signup (Free: 3 projects, Pro: 20, Business: unlimited)
- ✅ Change plan anytime → Stripe handles subscription update
- ✅ Access Stripe Billing Portal for invoices, payment method

### Security & Testing
- ✅ Policies-based authorization (ProjectPolicy, TeamPolicy, TaskPolicy)
- ✅ FormRequests for input validation
- ✅ Feature & unit tests (Pest framework)
- ✅ Rate limiting, CSRF protection, SQL injection prevention
- ✅ XSS protection (Blade auto-escaping)

## 🚀 Tech Stack

| Component | Tool | Version |
|-----------|------|---------|
| Framework | Laravel | 13.4 |
| PHP | PHP | 8.5 |
| Database | PostgreSQL | 18 Alpine |
| Cache & Queue | Redis | Alpine |
| Frontend | Tailwind CSS | Latest |
| Reactivity | Livewire | 3.7 |
| Drag & Drop | SortableJS | Latest |
| Payments | Stripe | Cashier v16 |
| Testing | Pest | Latest |
| Dev Environment | Docker (Sail) | Latest |

## 📋 Project Structure

```
app/
├── Actions/              # Business logic (CreateProject, CreateTask, MoveTask, etc.)
├── Livewire/             # Real-time components (KanbanBoard, TaskDetail, ProjectList, etc.)
├── Models/               # Eloquent models (Project, Board, Column, Task, Team, Plan, etc.)
├── Policies/             # Authorization (ProjectPolicy, TeamPolicy, TaskPolicy)
├── Http/
│   └── Requests/         # Form validation (StoreProjectRequest, etc.)
├── Exceptions/           # Custom (PlanLimitExceededException)
├── Services/             # Helpers (PlanLimiter)
└── Traits/               # Reusable (BelongsToTeam)

resources/
├── views/
│   ├── layouts/          # App layout with sidebar
│   ├── components/       # Blade components (<x-card>, <x-badge>)
│   ├── livewire/         # Component views
│   ├── projects/         # Project-related pages
│   ├── team/             # Team pages
│   └── billing.blade.php
├── js/app.js             # Imports for Sortable, Alpine, Livewire
└── css/app.css           # Tailwind

database/
├── migrations/           # Schema (projects, boards, columns, tasks, activity_logs)
└── seeders/              # PlanSeeder (Free, Pro, Business)

tests/
├── Feature/              # Auth, PlanLimit, Kanban, Authorization
└── Unit/                 # PlanLimiter, BelongsToTeam
```

## 🏃 Quick Start

### Development (with Docker)

```bash
# 1. Clone repo
git clone https://github.com/ide-la-r/SaaS-in-laravel.git
cd SaaS-in-laravel

# 2. Start Docker containers (includes PHP, PostgreSQL, Redis)
./vendor/bin/sail up -d

# 3. Generate app key
./vendor/bin/sail artisan key:generate

# 4. Run migrations & seed plans
./vendor/bin/sail artisan migrate
./vendor/bin/sail artisan db:seed --class=PlanSeeder

# 5. Compile frontend assets
./vendor/bin/sail npm run build

# 6. Visit http://localhost:8080
```

### Running Tests

```bash
./vendor/bin/sail pest                    # All tests
./vendor/bin/sail pest tests/Feature     # Feature tests only
./vendor/bin/sail pest tests/Unit        # Unit tests only
```

## 🔐 Security Features

- **Rate Limiting:** 60 req/min per IP
- **CSRF Protection:** All POST/PUT/DELETE protected
- **SQL Injection:** Eloquent ORM with parameter binding
- **XSS Protection:** Blade `{{ }}` auto-escaping
- **Mass Assignment:** Fillable/Guarded properties
- **Authorization:** Policies for view/create/update/delete
- **Password Hashing:** bcrypt (Laravel default)
- **Session Security:** Secure cookies, HTTP-only flags

## 📊 Database Schema

**Teams** belong to users (multi-tenancy)
↓
**Projects** belong to teams
↓
**Boards** belong to projects
↓
**Columns** belong to boards (e.g., "To Do", "In Progress", "Done")
↓
**Tasks** belong to columns (with priority, assignee, due date)
↓
**Activity Logs** track all actions (polymorphic)

## 💳 Stripe Integration

- Plans stored in database with Stripe price IDs
- Cashier handles subscription creation/update/cancellation
- Webhook endpoint `/stripe/webhook` for async events
- Billing Portal link for customer self-service

## 🚢 Deployment

See [DEPLOYMENT.md](./DEPLOYMENT.md) for step-by-step guide.

Platforms supported:
- **Laravel Forge** (managed PHP + PostgreSQL)
- **Railway** / **Render** (simple PaaS)
- **DigitalOcean** / **AWS** (manual setup)

Key steps:
```bash
composer install --no-dev --optimize-autoloader
npm run build
php artisan migrate --force
bash scripts/optimize.sh
```

## 📚 Learning Resources

- [Laravel Docs](https://laravel.com/docs)
- [Livewire Docs](https://livewire.laravel.com)
- [Tailwind CSS](https://tailwindcss.com)
- [Stripe Cashier](https://laravel.com/docs/11.x/cashier)
- [Pest Testing](https://pestphp.com)

## 📄 License

MIT License. See [LICENSE](./LICENSE) file.

## 👨‍💻 Author

Built as a job interview test for [IDE-LA-R](https://github.com/ide-la-r).

---

**Questions?** Check the code commits, inline comments, or open an issue! 🚀
