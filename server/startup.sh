#!/usr/bin/env bash

init_deps() {
  [ ! -d ./vendor ] &&
    symfony composer install &&
    symfony completion bash >/etc/bash_completion.d/symfony &&
    symfony console completion bash >/etc/bash_completion.d/console &&
    echo '. /etc/bash_completion' >>/root/.profile
}

init_db() {
  local host=db \
    port=3306

  echo -e '\e[33mDatabase health checking ...\e[0m'

  while true; do
    if (echo 2>/dev/null >/dev/tcp/$host/$port); then
      echo -e '\n\e[32m[Ok] - Database\e[0m'
      break
    fi
    echo -en .
    sleep 1
  done

  bin/console doctrine:database:create --if-not-exists
  bin/console doctrine:migrations:migrate --allow-no-migration --no-interaction
}

init_deps
init_db

unitd --no-daemon --control unix:/var/run/control.unit.sock
