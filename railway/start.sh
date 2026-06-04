#!/bin/sh
set -e

sh railway/init-app.sh
php artisan serve --host=0.0.0.0 --port="${PORT:-8080}"
