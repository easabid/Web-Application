#!/bin/sh
set -e

echo "Starting Laravel application..."

# Run migrations
php artisan migrate --force

# Create storage link
php artisan storage:link || true

# Start the server
exec php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
