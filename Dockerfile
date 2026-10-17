FROM php:8.2-cli-alpine

# Set working directory
WORKDIR /var/www/html

# Install required system packages, PHP extensions & Node.js
RUN apk update && apk add --no-cache \
    curl \
    git \
    unzip \
    libpng-dev \
    libxml2-dev \
    oniguruma-dev \
    sqlite-dev \
    nodejs \
    npm \
    && docker-php-ext-install pdo pdo_mysql pdo_sqlite mbstring bcmath gd opcache

# Install Composer from official image
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy application files
COPY . /var/www/html

# Copy entrypoint script and ensure executable permissions
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Install PHP dependencies without dev packages
RUN composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

# Install NPM dependencies, compile Vite assets, then remove node_modules to keep image small
RUN npm ci || npm install && npm run build && rm -rf node_modules

# Ensure proper storage & cache permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Expose web port
EXPOSE 80

# Run entrypoint script
ENTRYPOINT ["docker-entrypoint.sh"]
