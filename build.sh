#!/bin/sh

set -u
set -e

chmod -R 777 storage bootstrap/cache || true

curl https://getcomposer.org/installer > composer-installer
php composer-installer

# dummy user
php composer.phar config -g github-oauth.github.com 167b296588ae36f73e283ec0feb2cf5bb17f3fb9

php composer.phar install

php artisan migrate --force