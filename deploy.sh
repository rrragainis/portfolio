#!/bin/bash

# Colors for output
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

# Exit on error
set -e

# Function to print status messages
print_status() {
    echo -e "${GREEN}[STATUS]${NC} $1"
}

# Function to print warnings
print_warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

# Function to print errors and exit
print_error() {
    echo -e "${RED}[ERROR]${NC} $1"
    exit 1
}

# Check if .env exists
if [ ! -f .env ]; then
    print_warning ".env file not found. Creating from .env.example..."
    cp .env.example .env
    print_status "Created .env file. Please update the configuration values and run the script again."
    exit 0
fi

# Load environment variables
print_status "Loading environment variables..."
set -a
source .env
set +a

# Create necessary directories
print_status "Creating required directories..."
mkdir -p nginx/conf.d docker/mysql

# Stop any running containers
print_status "Stopping any running containers..."
docker-compose -f docker-compose.prod.yml down

# Pull latest images
print_status "Pulling latest images..."
docker-compose -f docker-compose.prod.yml pull || print_warning "Failed to pull some images. Continuing with local images..."

# Build services
print_status "Building services..."
docker-compose -f docker-compose.prod.yml build || print_error "Failed to build services"

# Start database first
print_status "Starting database service..."
docker-compose -f docker-compose.prod.yml up -d db

# Wait for database to be ready
print_status "Waiting for database to be ready..."
DB_HEALTH=0
MAX_RETRIES=30
RETRY_COUNT=0

while [ $DB_HEALTH -eq 0 ] && [ $RETRY_COUNT -lt $MAX_RETRIES ]; do
    if docker-compose -f docker-compose.prod.yml ps | grep -q "db.*healthy"; then
        DB_HEALTH=1
        print_status "Database is ready!"
    else
        RETRY_COUNT=$((RETRY_COUNT+1))
        echo "Waiting for database to be ready... (Attempt $RETRY_COUNT/$MAX_RETRIES)"
        sleep 5
    fi
done

if [ $DB_HEALTH -eq 0 ]; then
    print_error "Database failed to start. Please check the logs with: docker-compose -f docker-compose.prod.yml logs db"
fi

# Run database migrations
print_status "Running database migrations..."
docker-compose -f docker-compose.prod.yml exec -T backend php artisan migrate --force --no-interaction || \
    print_warning "Failed to run migrations. The database might already be up to date."

# Generate application key if not exists
if ! grep -q '^APP_KEY=base64:' .env; then
    print_status "Generating application key..."
    docker-compose -f docker-compose.prod.yml exec -T backend php artisan key:generate --force
fi

# Set storage permissions
print_status "Setting storage permissions..."
docker-compose -f docker-compose.prod.yml exec -T backend chown -R www-data:www-data /var/www/html/storage

# Start all services
print_status "Starting all services..."
docker-compose -f docker-compose.prod.yml up -d

# Verify services are running
print_status "Verifying services..."
SERVICES=("frontend" "backend" "db")
ALL_RUNNING=true

for service in "${SERVICES[@]}"; do
    if ! docker-compose -f docker-compose.prod.yml ps | grep -q "${service}.*Up"; then
        print_warning "Service $service is not running. Check logs with: docker-compose -f docker-compose.prod.yml logs $service"
        ALL_RUNNING=false
    fi
done

if [ "$ALL_RUNNING" = true ]; then
    echo -e "\n${GREEN}Deployment completed successfully!${NC}"
    echo -e "Your application should now be available at: ${GREEN}http://46.101.117.113${NC}"
    echo -e "\nYou can check the status of your services with: ${GREEN}docker-compose -f docker-compose.prod.yml ps${NC}"
    echo -e "View logs with: ${GREEN}docker-compose -f docker-compose.prod.yml logs -f${NC}"
else
    echo -e "\n${YELLOW}Deployment completed with warnings.${NC} Some services may not be running correctly."
    echo -e "Check the logs for more information: ${YELLOW}docker-compose -f docker-compose.prod.yml logs${NC}"
fi
