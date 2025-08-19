# TeaShop Menu Management Website

This project is a Laravel-based Admin Dashboard using [Filament](https://filamentphp.com/). It provides a clean and powerful admin interface with role-based access control.

## 📋 Features

- Filament Admin Panel UI
- Laravel 11 framework
- Role-based user access (Admin, Editor, User)
- User authentication (Login, Register)
- CRUD for:
  - Users
  - Categories
  - Posts

## 🛠 Installation

Email: admin@example.com

Password: password

```bash
git clone https://github.com/PhoeKae/shop-backend-laravel.git
```
    cd shop-backend-laravel
```
composer install
```
    cp .env.example .env
    php artisan key:generate
    php artisan storage:link
```
php artisan migrate --seed
```
    php artisan serve

Made with ❤️ by PhoeKae
