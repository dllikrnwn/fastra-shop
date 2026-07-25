#!/bin/bash
php artisan migrate --force --no-interaction 2>&1
php artisan storage:link --force 2>&1
php artisan config:clear 2>&1
php artisan view:clear 2>&1
php artisan route:clear 2>&1
php artisan serve --host=0.0.0.0 --port=$PORT 2>&1
