# Authentication & Role/Permission Setup (Step 3)

This file documents the exact commands and their explanations to configure authentication and Spatie role/permission system for Meultech.

Prerequisites:

- Laravel 13 project created
- PHP 8.3+, Composer, Node.js installed

Steps & Commands

1. Install Laravel Breeze (Livewire stack)

```bash
composer require laravel/breeze --dev
php artisan breeze:install livewire
npm install
npm run dev
php artisan migrate
```

Why: Breeze provides authentication scaffolding (login, register, password reset, email verification). The `livewire` stack wires Livewire components for interactive flows.

2. Install Spatie Permission

```bash
composer require spatie/laravel-permission
php artisan vendor:publish --provider="Spatie\\Permission\\PermissionServiceProvider"
php artisan migrate
```

Why: Spatie package provides role & permission persistence and helper methods used across policies and middleware.

3. Install Laravel Debugbar (dev)

```bash
composer require barryvdh/laravel-debugbar --dev
php artisan vendor:publish --provider="Barryvdh\\Debugbar\\ServiceProvider"
```

Why: Helpful during development for profiling requests.

4. Create roles & permissions seeders and run them

```bash
php artisan db:seed --class=DatabaseSeeder
```

What this does: runs the `RolePermissionSeeder` and `AdminUserSeeder` which create the role/permission set and a default Super Admin user (see `.env` keys `ADMIN_EMAIL` and `ADMIN_PASSWORD`).

5. Register middleware alias

Files added in repository already implement `App\\Http\\Middleware\\RoleMiddleware` and register the alias `role` in `bootstrap/app.php` (Laravel 13 style). Use in routes as:

```php
Route::middleware(['auth','verified','role:Super Admin|Admin|Staff'])->prefix('admin')->group(function(){
    // admin routes
});
```

Why: `role` middleware protects admin area and prevents customers from accessing it.

6. Assign roles to users

From tinker or application UI:

```bash
php artisan tinker
>>> $user = App\\Models\\User::where('email','admin@meultech.local')->first();
>>> $user->assignRole('Super Admin');
```

7. Policies and helpers

- `app/Policies/ProductPolicy.php` added and registered in `App\\Providers\\AuthServiceProvider.php`.
- `app/Helpers/authorization.php` provides `user_has_role()` and `user_can()` helper functions. These are loaded by `RepositoryServiceProvider::boot()`.

8. User model changes

`app/Models/User.php` was added/updated to implement `MustVerifyEmail` and use `Spatie\\HasRoles` trait and profile fields `phone`, `address`, `profile_photo_path`.

`canAccessPanel()` is implemented so Filament only opens for `Super Admin`, `Admin`, and `Staff` roles.

9. Migrations

`database/migrations/2026_05_16_000000_add_profile_fields_to_users.php` created to add `phone`, `address`, and `profile_photo_path` to `users` table.

10. Filament configuration

Filament uses the `web` guard by default. Ensure Filament users belong to an admin role. `User::canAccessPanel()` now blocks customers from admin access. Example gate added in `AuthServiceProvider` (`access-admin`). Configure Filament's `auth` config if you want a separate guard.

No separate admin guard is required for this architecture. Keeping `web` as the primary guard and using role/policy checks is simpler, safer, and works well with Breeze + Filament.

11. Final steps

```bash
php artisan migrate
php artisan db:seed
php artisan route:cache
php artisan config:cache
```

Why: Run migrations, seed roles and admin user, and cache config/routes for performance.

Notes

- If you want helper autoloading via Composer, add in `composer.json` under `autoload.files`:
- If you want helper autoloading via Composer, add in `composer.json` under `autoload.files`:

```json
"autoload": {
  "files": [
    "app/Helpers/authorization.php"
  ]
}
```

and run `composer dump-autoload`.

- Add these values to `.env` for default admin provisioning and locale/timezone bootstrap:

```dotenv
ADMIN_EMAIL=admin@meultech.local
ADMIN_PASSWORD=password
APP_TIMEZONE=UTC
APP_LOCALE=en
```

- `routes/auth.php` is now separated from `routes/web.php` to keep auth concerns clean and Breeze-friendly.

---

If you want, I can now scaffold Filament resources for `Product`, `Category` and `Brand`, and create a login page customization for the admin area.
