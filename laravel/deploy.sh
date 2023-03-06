#!/bin/bash
whoami
git pull
/usr/local/bin/composer install --prefer-dist --optimize-autoloader -vvv
php artisan vendor:publish --force
php artisan view:clear
php artisan migrate
php artisan key:generate
