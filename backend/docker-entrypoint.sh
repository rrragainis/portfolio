#!/bin/sh

# Create SQLite database if it doesn't exist
touch database/database.sqlite

# Generate application key if not exists
if [ -z "$(grep '^APP_KEY=base64:' .env)" ]; then
    php artisan key:generate --force
fi

# Run database migrations
php artisan migrate --force

# Clear and cache config
php artisan config:cache

# Set storage permissions
chown -R www-data:www-data storage database
chmod -R 775 storage bootstrap/cache database

# Start Apache
apache2-foreground
