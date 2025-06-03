# Portfolio Application

This is a portfolio application with a Vue.js frontend and Laravel backend, containerized with Docker and served via Nginx.

## Prerequisites

- Docker (version 20.10.0 or higher)
- Docker Compose (version 1.29.0 or higher)
- Git

## Getting Started

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd portfolio
   ```

2. **Set up environment variables**
   ```bash
   cp .env.example .env
   ```
   
   Edit the `.env` file and update the following variables:
   ```
   APP_KEY=base64:YOUR_APP_KEY_HERE  # Will be generated automatically
   DB_PASSWORD=secure_password_here
   DB_ROOT_PASSWORD=secure_root_password_here
   ```

## Deployment

1. **Start the application**
   ```bash
   # Make the deployment script executable
   chmod +x deploy.sh
   
   # Run the deployment script
   ./deploy.sh
   ```

2. **Access the application**
   - Frontend: http://46.101.117.113
   - Backend API: http://46.101.117.113/api

## Project Structure

- `frontend/` - Vue.js frontend application
- `backend/` - Laravel backend API
- `nginx/` - Nginx configuration files
- `docker-compose.prod.yml` - Production Docker Compose configuration
- `deploy.sh` - Deployment script

## Environment Variables

Key environment variables that can be configured in `.env`:

- `APP_ENV` - Application environment (production/development)
- `APP_DEBUG` - Debug mode (false in production)
- `DB_*` - Database configuration
- `BACKEND_URL` - Backend API URL (http://46.101.117.113)

## Maintenance

### Stopping the application
```bash
docker-compose -f docker-compose.prod.yml down
```

### Viewing logs
```bash
# View all logs
docker-compose -f docker-compose.prod.yml logs -f

# View specific service logs (e.g., backend, frontend, nginx, db)
docker-compose -f docker-compose.prod.yml logs -f backend
```

### Running database migrations
```bash
docker-compose -f docker-compose.prod.yml exec backend php artisan migrate
```

### Running tests
```bash
docker-compose -f docker-compose.prod.yml exec backend php artisan test
```

## Troubleshooting

- If you encounter permission issues, try:
  ```bash
  sudo chown -R $USER:$USER .
  ```

- If containers fail to start, check the logs:
  ```bash
  docker-compose -f docker-compose.prod.yml logs
  ```

## Security

- Keep your `.env` file secure and never commit it to version control
- Use strong passwords for database users
- Regularly update your dependencies
- Monitor your server logs for suspicious activity
