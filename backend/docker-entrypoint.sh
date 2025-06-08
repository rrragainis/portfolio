#!/bin/sh

# Create database file if it doesn't exist
touch database/database.sqlite
chmod 666 database/database.sqlite

# Generate application key if not exists
if [ -z "$(grep '^APP_KEY=base64:' .env)" ]; then
    php artisan key:generate --force
fi

# Run database migrations
php artisan migrate --force

# Clear and cache config
php artisan config:cache

# Set storage permissions
chown -R www-data:www-data storage
chmod -R 775 storage bootstrap/cache

# Start Apache
apache2-foreground
