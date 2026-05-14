#!/bin/bash

echo "Running migrations and seeders..."
php artisan migrate:fresh --force --seed

echo "Starting server..."
php-fpm & caddy run --config /etc/caddy/Caddyfile