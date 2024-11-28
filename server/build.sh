#!/usr/bin/env bash

case "$1" in
--force)
  docker build --file unit_php.Dockerfile --tag onixspot/unit-php .
  ;;
esac
docker build --no-cache --file Dockerfile --build-arg hostname=api-server --tag api/server .
