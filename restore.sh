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
