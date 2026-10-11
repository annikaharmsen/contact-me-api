#!/bin/bash
# Production deploy steps, run on the server from the site directory after the new code is pulled.
# The GitHub Actions deploy workflow triggers it over SSH; the server's ~/bin/deploy pulls the branch, then runs this file.
# The workflow builds the frontend assets and streams them in on stdin as a tar.gz of public/build:
# the server has too little memory to run the build itself.
set -euo pipefail

composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

rm -rf public/build.new
mkdir public/build.new
tar -xzf - -C public/build.new
rm -rf public/build
mv public/build.new public/build

php artisan migrate --force

sudo -n service php8.3-fpm reload
