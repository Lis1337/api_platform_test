#!/bin/sh
set -e

mkdir -p bin
ln -sf ../vendor/bin/codecept bin/codecept

exec docker-php-entrypoint "$@"
