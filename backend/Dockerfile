# Dockerfile for Laravel backend
FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    sqlite3 \
    libsqlite3-dev \
    nginx

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd pdo_sqlite

# Set working directory
WORKDIR /var/www/html

# Copy composer and install dependencies
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer
COPY . /var/www/html
RUN composer install --no-dev --optimize-autoloader

# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Set PHP upload limits
RUN echo "upload_max_filesize=50M\npost_max_size=50M" > /usr/local/etc/php/conf.d/uploads.ini

# Create storage symlink
RUN php artisan storage:link

# Expose port 8000
EXPOSE 8000

# Start the Laravel development server
CMD php artisan serve --host=0.0.0.0 --port=8000
