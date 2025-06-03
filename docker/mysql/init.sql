-- Create the database if it doesn't exist
CREATE DATABASE IF NOT EXISTS portfolio CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Create a user and grant privileges
GRANT ALL PRIVILEGES ON portfolio.* TO 'portfolio'@'%';
FLUSH PRIVILEGES;

-- Use the database
USE portfolio;
