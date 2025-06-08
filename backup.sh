#!/bin/bash

# Create backups directory if it doesn't exist
mkdir -p backups

# Create timestamp for backup file
TIMESTAMP=$(date +%Y%m%d_%H%M%S)
BACKUP_FILE="backups/portfolio_backup_$TIMESTAMP.sqlite"

# Create backup
cp database/database.sqlite "$BACKUP_FILE"

# Keep only the last 10 backups
ls -t backups/portfolio_backup_*.sqlite | tail -n +11 | xargs -r rm

# Create restore script
cat > restore.sh << 'EOF'
#!/bin/bash

# Find the most recent backup
LATEST_BACKUP=$(ls -t backups/portfolio_backup_*.sqlite | head -n1)

if [ -z "$LATEST_BACKUP" ]; then
    echo "No backup found!"
    exit 1
fi

# Restore the backup
cp "$LATEST_BACKUP" database/database.sqlite

echo "Restored from backup: $LATEST_BACKUP"
EOF

# Make restore script executable
chmod +x restore.sh
