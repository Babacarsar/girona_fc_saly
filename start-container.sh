#!/bin/bash
set -e

unset DB_CHARSET
export DB_CHARSET=UTF8

echo "Clearing Laravel config cache before database access..."
php artisan config:clear

if [ "$IS_LARAVEL" = "true" ]; then
  if [ "$RAILPACK_SKIP_MIGRATIONS" != "true" ]; then
    echo "Running migrations and seeding database ..."
    php artisan migrate --force
    php artisan db:seed --class=AdminUserSeeder --force
  fi

  php artisan storage:link
  echo "Starting Laravel server ..."
fi

exec docker-php-entrypoint --config /Caddyfile --adapter caddyfile 2>&1
