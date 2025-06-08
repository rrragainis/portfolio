#!/bin/sh

# Create database directory and file with proper permissions
mkdir -p /var/www/html/database
touch /var/www/html/database/database.sqlite
chown -R www-data:www-data /var/www/html/database
chmod -R 777 /var/www/html/database

# Generate application key if not exists
if [ -z "$(grep '^APP_KEY=base64:' .env)" ]; then
    php artisan key:generate --force
fi

# Run database migrations
php artisan migrate --force

# Clear and cache config
php artisan config:cache

# Set storage permissions
chown -R www-data:www-data /var/www/html/storage
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Start Apache
apache2-foreground
