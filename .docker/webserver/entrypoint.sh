#!/bin/bash
set -e

# Constants
INIT_FILE="/var/www/html/.initialized"
DB_HOST="postgres"
DB_PORT=${POSTGRES_PORT:-5432}
DB_URL="pgsql://${POSTGRES_USER}:${POSTGRES_PASSWORD}@${DB_HOST}:${DB_PORT}/${POSTGRES_DB}"
ADMIN_USER=${BACKEND_ADMIN:-admin}
ADMIN_PASS=${BACKEND_PASSWORD:-admin}
MODULES=("kozlony_base" "kozlony_tajekoztatok_highlight")

log() {
  echo "[INFO] $1"
}

wait_for_postgres() {
  log "Waiting for PostgreSQL to be ready..."
  until pg_isready -h "$DB_HOST" -p "$DB_PORT" -U "$POSTGRES_USER"; do
    sleep 2
  done
  log "PostgreSQL is ready!"
}

run_composer_install() {
  if [ ! -d "/var/www/html/vendor" ]; then
    log "Vendor directory not found. Running composer install..."
    composer install --prefer-source --working-dir=/var/www/html || {
      log "Composer install failed. Deleting vendor directory..."
      rm -rf /var/www/html/vendor
      exit 1
    }
  else
    log "Vendor directory already exists. Skipping composer install."
  fi
}

install_drupal() {
  log "Running Drupal site installation..."
  php drush.phar site:install \
    --db-url="$DB_URL" \
    --account-name="$ADMIN_USER" \
    --account-pass="$ADMIN_PASS" \
    --locale=hu \
    -y
}

enable_modules() {
  log "Enabling modules..."
  for MODULE in "${MODULES[@]}"; do
    log "Enabling module: $MODULE"
    php drush.phar en "$MODULE" -y
  done
}

update_database() {
  log "Running database updates..."
  php drush.phar updb -y
}

run_php_eval() {
  log "Running php-eval for hooks..."
  php drush.phar php-eval "include 'modules/kozlony/base/kozlony_base.install';
  kozlony_base_update_8004();
  kozlony_base_update_8005();
  kozlony_base_update_8006();"
}

set_permissions() {
  if [ ! -d "/var/www/html/web/sites/default/files" ]; then
    log "Creating web/sites/default/files directory..."
    mkdir -p /var/www/html/web/sites/default/files
    mkdir -p /var/www/html/web/sites/default/files/styles
  fi
  log "Setting permissions for web/sites/default/files..."
  chown -R www-data:www-data /var/www/html/web/sites/default/files
  chown -R www-data:www-data /var/www/html/web/sites/default/files/*
  chmod -R 777 /var/www/html/web/sites/default/files
  chmod -R 777 /var/www/html/web/sites/default/files/*
}

mark_initialized() {
  log "Marking initialization as complete..."
  touch "$INIT_FILE"
}

if [ ! -f "$INIT_FILE" ]; then
  log "Running setup for the first time..."
  wait_for_postgres
  run_composer_install
  set_permissions
  install_drupal
  enable_modules
  update_database
  run_php_eval
  mark_initialized
else
  log "Setup already completed. Skipping first-time steps."
fi

# Execute the passed command(s)
exec "$@"
