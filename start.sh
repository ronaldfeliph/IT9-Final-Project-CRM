#!/bin/bash

echo "Running migrations and seeders..."
php artisan migrate:fresh --force --seed

echo "Starting server..."
frankenphp run --config /etc/frankenphp/Caddyfile