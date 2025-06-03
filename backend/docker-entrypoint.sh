#!/bin/sh

# Wait for the database to be ready
until php artisan db:monitor > /dev/null 2>&1; do
    echo "Waiting for database connection..."
    sleep 1
done

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
