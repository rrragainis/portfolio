#!/bin/bash

# Create backups directory if it doesn't exist
mkdir -p backups

# Create timestamp for backup file
TIMESTAMP=$(date +%Y%m%d_%H%M%S)
BACKUP_FILE="backups/portfolio_backup_$TIMESTAMP.sql"

# Create database and user if they don't exist
docker exec -i db mysql -u root -proot -e "CREATE DATABASE IF NOT EXISTS portfolio; CREATE USER IF NOT EXISTS 'portfolio'@'%' IDENTIFIED BY 'portfolio'; GRANT ALL PRIVILEGES ON portfolio.* TO 'portfolio'@'%'; FLUSH PRIVILEGES;"

# Create backup
docker exec -i db mysqldump -u root -proot portfolio > "$BACKUP_FILE"

# Keep only the last 10 backups
ls -t backups/portfolio_backup_*.sql | tail -n +11 | xargs -r rm

# Create restore script
cat > restore.sh << 'EOF'
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
EOF

# Make restore script executable
chmod +x restore.sh
