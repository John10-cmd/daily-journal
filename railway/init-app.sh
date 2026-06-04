#!/bin/sh
set -e

echo "Preparing Laravel for Railway..."
php artisan optimize:clear

echo "Running database migrations..."
attempt=1
until php artisan migrate --force --no-interaction; do
    if [ "$attempt" -ge 10 ]; then
        echo "Database migration failed after $attempt attempts."
        exit 1
    fi

    echo "Database is not ready yet. Retrying in 5 seconds... ($attempt/10)"
    attempt=$((attempt + 1))
    sleep 5
done

echo "Seeding preset admin account..."
php artisan db:seed --force

echo "Refreshing public storage link..."
php artisan storage:link --force

echo "Caching Laravel config, routes, and views..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Railway pre-deploy setup complete."
