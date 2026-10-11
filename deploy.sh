#!/bin/bash
# Production deploy steps, run on the server from the site directory after the new code is pulled.
# The GitHub Actions deploy workflow triggers it over SSH; the server's ~/bin/deploy pulls the branch, then runs this file.
set -euo pipefail

composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader
npm ci
npm run build
php artisan migrate --force

sudo -n service php8.3-fpm reload
