#!/bin/bash
set -e

export DB_CHARSET="${DB_CHARSET:-UTF8}"
if [ "$DB_CHARSET" = "utf8mb4" ]; then
  export DB_CHARSET=UTF8
fi

# Override Railpack default: clear stale config (e.g. MySQL utf8mb4) before DB access.
php artisan config:clear

if [ "$IS_LARAVEL" = "true" ]; then
  if [ "$RAILPACK_SKIP_MIGRATIONS" != "true" ]; then
    echo "Running migrations and seeding database ..."
    php artisan migrate --force
  fi

  php artisan storage:link
  echo "Starting Laravel server ..."
fi

exec docker-php-entrypoint --config /Caddyfile --adapter caddyfile 2>&1
