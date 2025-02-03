#!/bin/sh
set -e

# Logging function
log() {
  local message="$1"
  local timestamp
  timestamp=$(date +'%Y-%m-%d %H:%M:%S')
  echo "${timestamp} [ENTRYPOINT] ${message}"
}

# Function to check PostgreSQL availability
wait_for_postgres() {
  log "Waiting for PostgreSQL service at ${DB_HOST}:${DB_PORT}..."
  until pg_isready -h "${DB_HOST}" -p "${DB_PORT}" -U "${DB_USERNAME}"; do
    log "PostgreSQL is not available yet. Retrying in 2 seconds..."
    sleep 2
  done
  log "PostgreSQL is available!"
}

# Set working directory
WORKDIR="/var/www/html"
if [ -d "${WORKDIR}" ]; then
  cd "${WORKDIR}"
else
  log "Error: Working directory ${WORKDIR} does not exist."
  exit 1
fi

# Wait for PostgreSQL service
wait_for_postgres

# Check if .env file exists and set APP_KEY if not present
if [ ! -f .env ]; then
  log ".env file not found. Copying from .env.example..."
  cp .env.example .env
  cp .env.example .env.testing
fi

if ! grep -q "^APP_KEY=" .env; then
  log "APP_KEY not set. Generating new application key..."
  php artisan key:generate --force
fi

# Install PHP dependencies
log "Installing PHP dependencies with Composer..."
composer install --no-interaction --prefer-dist --optimize-autoloader
log "Composer install completed."

# Run Laravel migrations
log "Running Artisan migrations..."
php artisan migrate --force

# Run Laravel seeders
log "Running database seeders..."
php artisan db:seed --force
log "Seeding completed."

# Running tests
log "Running tests..."
php ./vendor/bin/pest
log "Tests completed."

# Start PHP-FPM
log "Starting PHP-FPM..."
exec php-fpm -y /usr/local/etc/php-fpm.conf -R