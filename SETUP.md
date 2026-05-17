# Meultech — Laravel 13 Setup & Development Environment

This document contains step-by-step commands and explanations to bootstrap the Meultech Laravel 13 ecommerce project based on the architecture decisions in `ARCHITECTURE.md`.

Requirements

- PHP 8.3+
- Composer
- Node.js (18+ recommended)
- NPM or Yarn
- MySQL / MariaDB (or other supported DB)
- Redis (for cache/queues)
- Meilisearch (optional for search)

Overview
This guide performs the following high-level tasks:

- Create a Laravel 13 project
- Configure environment and common settings
- Install Breeze, Livewire, Tailwind, Filament, Spatie permissions, Debugbar
- Configure Vite and frontend assets
- Create enterprise folder scaffolding and initial providers
- Create basic routes, controllers, layouts, and protected admin routes
- Setup Git repository

Important: run these commands locally on your development machine (the repo now contains templates and starter files). If you want me to run commands in this environment I need access to your local shell; otherwise copy/paste the blocks below.

---

1. Create Laravel 13 project

Commands:

```bash
composer create-project --prefer-dist laravel/laravel="13.*" meultech
cd meultech
```

Why: Installs Laravel 13 skeleton using Composer. Using project folder `meultech` keeps files in a new directory.

2. Set PHP requirement and verify

```bash
php -v
# Ensure version >= 8.3
```

Why: Laravel 13 requires PHP 8.3+ for features and compatibility.

3. Initialize Git

```bash
git init
git add --all
git commit -m "chore: initial laravel 13 skeleton"
```

Why: Track changes from the start. We already have `.gitignore` in this repository; ensure it is used.

4. Configure `.env` basics

Copy the template and set values:

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` and set these key values (these are examples):

- `APP_NAME=Meultech`
- `APP_URL=http://localhost:8000`
- `APP_ENV=local`
- `APP_DEBUG=true`
- Database: `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`
- `APP_TIMEZONE=UTC` (change as required)
- `APP_LOCALE=en`
- Cache/Queue/Session drivers: `redis`

Why: .env holds environment-specific configuration. `php artisan key:generate` sets the application key.

5. Install Laravel Breeze (auth scaffolding) with Livewire

Commands:

```bash
composer require laravel/breeze --dev
php artisan breeze:install blade --auth
# If you prefer Livewire stack (recommended for interactive flows):
composer require livewire/livewire
php artisan breeze:install livewire
```

Run:

```bash
npm install
npm run dev
php artisan migrate
```

Why: Breeze provides lightweight auth scaffolding (login, register, password reset, email verification). The Livewire stack helps for dynamic components (cart, filters) without building a SPA.

6. Install Livewire separately (if not installed by Breeze)

```bash
composer require livewire/livewire
```

Why: Provides reactive server-driven components used throughout the storefront.

7. Install Tailwind CSS v4 and configure

Commands (Tailwind v4 if available; replace with v3 if v4 is not released):

```bash
npm install -D tailwindcss@^4 postcss autoprefixer
npx tailwindcss init -p
```

Update `tailwind.config.js` to include paths:

```js
module.exports = {
  content: [
    "./resources/views/**/*.blade.php",
    "./resources/js/**/*.js",
    "./app/Http/Livewire/**/*.php",
  ],
  theme: { extend: {} },
  plugins: [],
};
```

Why: Tailwind provides utility-first CSS used in the design system. Configure `content` to purge unused CSS in production.

8. Install Filament (admin panel)

Commands:

```bash
composer require filament/filament
php artisan vendor:publish --tag=filament-config
php artisan migrate
php artisan make:filament-user
```

Why: Filament provides a modern admin UI and resource scaffolding useful for product management. `make:filament-user` creates an admin account.

9. Install Spatie Laravel Permission (roles & permissions)

```bash
composer require spatie/laravel-permission
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
php artisan migrate
```

Why: Provides role and permission management for admin roles (super-admin, product-manager, order-manager).

10. Install Debugbar (dev only)

```bash
composer require barryvdh/laravel-debugbar --dev
php artisan vendor:publish --provider="Barryvdh\Debugbar\ServiceProvider"
```

Why: Debugbar provides profiling information while developing.

11. Install other recommended packages

Examples:

```bash
composer require spatie/laravel-medialibrary
composer require meilisearch/meilisearch laravel/scout
composer require laravel/horizon --dev
composer require stripe/stripe-php
```

Publish vendor assets and run migrations for packages where necessary.

12. Configure Vite and frontend assets

- `vite.config.js` should already exist in the project root. Update to include `resources/css/app.css` and `resources/js/app.js`.
- In `resources/css/app.css` include Tailwind directives:

```css
@tailwind base;
@tailwind components;
@tailwind utilities;
```

- In `resources/js/app.js` import Livewire support if required and other global scripts.

Commands:

```bash
npm install
npm run dev
```

Why: Vite is the asset bundler for modern Laravel. `npm run dev` starts the dev server and builds assets.

13. Create enterprise folder architecture (scaffold)

Create the following directories under `app/`:

- `Services/` (domain services)
- `Repositories/` (repository interfaces & implementations)
- `Helpers/` (helper functions)
- `Actions/` (single-responsibility invokable classes)
- `Traits/` (reusable traits)
- `DTOs/` (data transfer objects)
- `Enums/` (PHP 8.1+ enums)

Why: Keeps code modular and testable. Implement repository contracts under `Repositories/Contracts` and bind them in a service provider such as `RepositoryServiceProvider`.

14. Configure Filament admin structure

- Publish Filament config and update `config/filament.php`.
- Create Filament resources for `Product`, `Category`, `Brand` using `php artisan make:filament-resource`.
- Restrict Filament access using Spatie roles or Filament's native policies.

Why: Organizes admin CRUD in Filament and secures admin routes.

15. Setup Git repository properly

Commands:

```bash
git init
git checkout -b dev
git add .
git commit -m "chore: project bootstrap and package installation"
```

Add remote and push to your origin later.

16. Create initial homepage route and layout

Routes are in `routes/web.php`. Example routes were scaffolded already in the repo.

17. Create protected admin dashboard routes

Group admin routes under `prefix('admin')` and middleware `auth,verified`.

18. Configure authentication system (Breeze provides):

- Login, Registration, Forgot password, Email verification are scaffolding by Breeze/Livewire.
- Run `php artisan migrate` after installing Breeze.

19. Create reusable Blade layout structure

Put base layout in `resources/views/layouts/app.blade.php` and partials in `resources/views/components/` (header, footer, navigation).

20. Development environment optimization

Run these commands when preparing environment for development and CI:

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

Prepare queues & Redis:

```bash
# Redis must be running
php artisan queue:work --tries=3
# For monitoring with Horizon
php artisan horizon
```

Why: Caching improves performance; Redis and queues handle background tasks like sending emails and indexing.

21. Sample file additions (already added to this repo):

- `routes/web.php` — home and admin routes
- `app/Http/Controllers/HomeController.php` — returns the home view
- `app/Http/Controllers/Admin/DashboardController.php` — admin dashboard stub
- `app/Providers/RepositoryServiceProvider.php` — place to bind repository interfaces
- `resources/views/layouts/app.blade.php` — base layout using Vite and Livewire
- `resources/views/components/header.blade.php` and `footer.blade.php`
- `resources/js/app.js`, `resources/css/app.css`, `vite.config.js`
- `.env.example` template

22. GitHub Actions / CI (starter)

Create `.github/workflows/ci.yml` with testing and static analysis steps (PHPUnit, PHPStan/PSalm, composer install). Example skeleton:

```yaml
name: CI
on: [push, pull_request]
jobs:
  tests:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v4
      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: "8.3"
          extensions: mbstring, bcmath, sqlite
      - name: Install dependencies
        run: composer install --no-progress --no-suggest --prefer-dist
      - name: Run tests
        run: vendor/bin/phpunit --testsuite=unit
```

Why: CI runs tests & static analysis to ensure code quality.

23. Next steps & checklist for you to run locally

- Run composer create-project and follow the steps above
- Configure `.env` for DB and Redis
- Run `composer require` commands for packages listed
- Run `php artisan migrate` and create first admin user (`php artisan make:filament-user`)
- Run `npm install && npm run dev`

---

If you'd like, I can now:

- Generate migration stubs for core tables (Category/Product/Brand/Variant)
- Create Filament resource stubs
- Add GitHub Actions `ci.yml` file for you

Tell me which of these you'd like me to do next and I will scaffold them in the repository.
