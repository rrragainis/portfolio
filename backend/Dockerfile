# Dockerfile for Laravel backend
FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libjpeg-dev \
    libfreetype6-dev \
    libwebp-dev

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp
RUN docker-php-ext-install -j$(nproc) pdo_mysql mbstring exif pcntl bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy existing application directory
COPY . .

# Install dependencies
RUN composer install

# Set permissions
RUN chown -R www-data:www-data /var/www

# Configure PHP upload limits
RUN echo "upload_max_filesize=50M" >> /usr/local/etc/php/conf.d/docker-php-upload-limit.ini
RUN echo "post_max_size=50M" >> /usr/local/etc/php/conf.d/docker-php-upload-limit.ini

# Set working directory
WORKDIR /var/www/html

# Create storage symlink
RUN php artisan storage:link

# Expose port 8000
EXPOSE 8000

# Start the Laravel development server
CMD php artisan serve --host=0.0.0.0 --port=8000
