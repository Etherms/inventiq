#!/bin/sh
set -e

echo "Container started successfully"

php-fpm -D

echo "PHP-FPM started"

nginx -g "daemon off;"