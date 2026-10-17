#!/bin/sh
set -e

# Generate .env if not mounted or present
if [ ! -f /var/www/html/.env ]; then
    echo "Creating default .env from .env.example..."
    cp /var/www/html/.env.example /var/www/html/.env
fi

# Ensure APP_KEY exists
if ! grep -q "^APP_KEY=base64:" /var/www/html/.env; then
    echo "Generating Application Key..."
    php artisan key:generate --force
fi

# Set proper permissions for storage & cache
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# If SQLite is selected and database doesn't exist, create it
if grep -q "^DB_CONNECTION=sqlite" /var/www/html/.env; then
    touch /var/www/html/database/database.sqlite
    chown www-data:www-data /var/www/html/database/database.sqlite
fi

# Run migrations automatically if database is accessible
echo "Checking database and running migrations..."
php artisan migrate --force || echo "Warning: Database migration skipped (ensure DB credentials are set in environment if using external DB)."

# Clear and cache configurations for production speed
php artisan config:clear
php artisan route:clear
php artisan view:clear

echo "Starting application on port 80..."
exec php artisan serve --host=0.0.0.0 --port=80
