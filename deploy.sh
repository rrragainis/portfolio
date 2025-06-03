#!/bin/bash

# Exit on error
set -e

# Check if .env exists
if [ ! -f .env ]; then
    echo "Error: .env file not found. Please copy .env.example to .env and update the values."
    exit 1
fi

# Load environment variables
set -a
source .env
set +a

# Create necessary directories
mkdir -p nginx/conf.d

echo "Stopping any running containers..."
docker-compose -f docker-compose.prod.yml down

echo "Pulling latest images..."
docker-compose -f docker-compose.prod.yml pull

echo "Building services..."
docker-compose -f docker-compose.prod.yml build

echo "Starting services..."
docker-compose -f docker-compose.prod.yml up -d db

echo "Waiting for database to be ready..."
sleep 30

echo "Running database migrations..."
docker-compose -f docker-compose.prod.yml exec -T backend php artisan migrate --force

echo "Generating application key..."
docker-compose -f docker-compose.prod.yml exec -T backend php artisan key:generate --force

echo "Setting storage permissions..."
docker-compose -f docker-compose.prod.yml exec -T backend chown -R www-data:www-data /var/www/html/storage

echo "Starting all services..."
docker-compose -f docker-compose.prod.yml up -d

echo "Deployment completed successfully!"
echo "Your application is now available at: http://46.101.117.113"
