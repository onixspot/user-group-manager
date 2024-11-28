#!/usr/bin/env bash

case "$1" in
--force)
  docker build --file php_cli.Dockerfile --tag onixspot/php-cli .
  ;;
esac
docker build --no-cache --file Dockerfile --tag api/client .
