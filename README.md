# Meultech

Starter repository for Meultech eCommerce (Laravel 12)

This repo contains the architecture and planning document for Meultech. Use the instructions in `ARCHITECTURE.md` to start implementation.

Quick start:

```bash
# from your development folder
composer create-project --prefer-dist laravel/laravel Meultech "12.*"
cd Meultech
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```

See `ARCHITECTURE.md` for full details.
