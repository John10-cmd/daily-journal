# Daily Journal

A full-stack Laravel daily journal built for private writing, mood tracking, profile customization, and Railway deployment.

## Features

- Registration, login, logout, and protected pages
- Dashboard with total entries, favorite count, current streak, recent entries, and mood mix
- Journal CRUD with validation, favorites, tags, reading time, search, mood filter, and delete confirmation
- Profile update with name, email, bio, password change, and image upload
- Admin user management with search, create, edit, delete, role assignment, and guarded self-delete
- Flash notifications, responsive Blade UI, Vite/Tailwind styling, and small JavaScript enhancements
- Railway-ready `railway.toml`, `nixpacks.toml`, `Procfile`, and deploy scripts

## Local Setup

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed
npm run build
php artisan serve
```

Open `http://127.0.0.1:8000`.

The default local database is MySQL:

```text
Database: daily_journal
Host: 127.0.0.1
Port: 3306
Username: root
Password: blank
```

Create the database in your local MySQL first if it does not exist:

```sql
CREATE DATABASE daily_journal CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Seeded admin login:

```text
Email: admin@dailyjournal.test
Password: Admin12345
```

## Railway Notes

Set these environment variables in Railway:

```bash
APP_NAME="Daily Journal"
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:your-generated-key
APP_URL=https://your-railway-url.up.railway.app
FILESYSTEM_DISK=public
DB_CONNECTION=mysql
DB_URL=${{ MySQL.MYSQL_URL }}
SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database
LOG_CHANNEL=stderr
LOG_LEVEL=info
```

Generate an app key locally with `php artisan key:generate --show`, then paste it into Railway as `APP_KEY`.

Add a MySQL database service in Railway first. Railway exposes MySQL variables such as `MYSQLHOST`, `MYSQLPORT`, `MYSQLUSER`, `MYSQLPASSWORD`, `MYSQLDATABASE`, and `MYSQL_URL`; this app can read `MYSQL_URL` directly, but setting `DB_URL=${{ MySQL.MYSQL_URL }}` keeps the Laravel config explicit.

The Railway config-as-code file, `railway.toml`, sets the Railpack builder, Vite build command, healthcheck, and start command. The start command clears and caches Laravel config, runs migrations, seeds the preset admin account, refreshes the storage symlink, and then runs Laravel on Railway's assigned `PORT`.

## Verification

```bash
php artisan test
npm run build
php artisan route:list
```

# daily-journal
