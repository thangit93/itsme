#!/bin/sh

# Exit on fail
set -e
php-fpm

# Finally call command issued to the docker service
exec "$@"
