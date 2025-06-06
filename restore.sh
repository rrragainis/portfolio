#!/bin/bash

# Find the most recent backup
LATEST_BACKUP=$(ls -t backups/portfolio_backup_*.sql | head -n1)

if [ -z "$LATEST_BACKUP" ]; then
    echo "No backup found!"
    exit 1
fi

# Create database and user if they don't exist
docker exec -i db mysql -u root -proot -e "CREATE DATABASE IF NOT EXISTS portfolio; CREATE USER IF NOT EXISTS 'portfolio'@'%' IDENTIFIED BY 'portfolio'; GRANT ALL PRIVILEGES ON portfolio.* TO 'portfolio'@'%'; FLUSH PRIVILEGES;"

# Restore the backup
docker exec -i db mysql -u root -proot portfolio < "$LATEST_BACKUP"

echo "Restored from backup: $LATEST_BACKUP"
