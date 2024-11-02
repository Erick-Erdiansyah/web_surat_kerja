#!/bin/bash
# Make sure this file has executable permissions, run `chmod +x run-app.sh`


# seed database
php artisan migrate --force

#install package
npm install

# Build assets using NPM
npm run build

# symlink
php artisan storage:link
# Clear cache
php artisan optimize:clear

# Cache the various components of the Laravel application
php artisan config:cache
php artisan event:cache
php artisan route:cache
php artisan view:cache
