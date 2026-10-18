#!/bin/sh
set -e

# Generate .env if not mounted or present
if [ ! -f /var/www/html/.env ]; then
    echo "Creating default .env from .env.example..."
    cp /var/www/html/.env.example /var/www/html/.env
fi

# Ensure database config in .env matches container environment variables
if [ -n "$DB_HOST" ]; then
    sed -i "s|^DB_HOST=.*|DB_HOST=${DB_HOST}|" /var/www/html/.env 2>/dev/null || true
fi
if [ -n "$DB_DATABASE" ]; then
    sed -i "s|^DB_DATABASE=.*|DB_DATABASE=${DB_DATABASE}|" /var/www/html/.env 2>/dev/null || true
fi
if [ -n "$DB_USERNAME" ]; then
    sed -i "s|^DB_USERNAME=.*|DB_USERNAME=${DB_USERNAME}|" /var/www/html/.env 2>/dev/null || true
fi
if [ -n "$DB_PASSWORD" ]; then
    sed -i "s|^DB_PASSWORD=.*|DB_PASSWORD=${DB_PASSWORD}|" /var/www/html/.env 2>/dev/null || true
fi

# Ensure APP_URL in .env matches container environment
if [ -n "$APP_URL" ]; then
    sed -i "s|^APP_URL=.*|APP_URL=${APP_URL}|" /var/www/html/.env 2>/dev/null || true
fi

# Ensure APP_KEY exists in .env or from environment
if [ -n "$APP_KEY" ]; then
    if grep -q "^APP_KEY=" /var/www/html/.env; then
        sed -i "s|^APP_KEY=.*|APP_KEY=${APP_KEY}|" /var/www/html/.env
    else
        echo "APP_KEY=${APP_KEY}" >> /var/www/html/.env
    fi
elif ! grep -q "^APP_KEY=base64:" /var/www/html/.env; then
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

# Wait for database to be ready (especially when running with MySQL container)
if [ "$DB_CONNECTION" = "mysql" ] || grep -q "^DB_CONNECTION=mysql" /var/www/html/.env; then
    echo "Waiting for MySQL database to become ready..."
    MAX_TRIES=30
    COUNT=0
    until php -r "
        \$host = env('DB_HOST', 'mysql');
        \$port = env('DB_PORT', 3306);
        \$db   = env('DB_DATABASE', 'admin_start');
        \$user = env('DB_USERNAME', 'root');
        \$pass = env('DB_PASSWORD', 'root');
        try {
            new PDO(\"mysql:host=\$host;port=\$port;dbname=\$db\", \$user, \$pass, [PDO::ATTR_TIMEOUT => 3]);
            exit(0);
        } catch (\Exception \$e) {
            exit(1);
        }
    " 2>/dev/null || [ $COUNT -eq $MAX_TRIES ]; do
        COUNT=$((COUNT+1))
        echo "Waiting for MySQL connection... ($COUNT/$MAX_TRIES)"
        sleep 2
    done
fi

# Run migrations automatically if database is accessible
echo "Checking database, running migrations and seeds..."
if php artisan migrate --force; then
    php artisan db:seed --force || true
fi

# Clear and optimize configurations
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan config:cache

echo "Starting application on port 80..."
exec php artisan serve --host=0.0.0.0 --port=80
