# Use official PHP image with Apache
FROM php:8.2-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Get Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Copy application files
COPY . .

# Install dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Create storage and bootstrap cache directories
RUN mkdir -p /app/storage/app/public \
    && mkdir -p /app/storage/framework/cache/data \
    && mkdir -p /app/storage/framework/sessions \
    && mkdir -p /app/storage/framework/views \
    && mkdir -p /app/storage/logs \
    && mkdir -p /app/bootstrap/cache \
    && chmod -R 777 /app/storage \
    && chmod -R 777 /app/bootstrap/cache

# Expose port
EXPOSE 8000

# Start PHP built-in server with config cache clear
ENTRYPOINT ["sh", "-c", "php artisan config:clear && php artisan cache:clear && php -S 0.0.0.0:${PORT:-8000} -t /app/public"]
