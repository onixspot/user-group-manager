#!/usr/bin/env bash

set -e

[ ! -d ./vendor ] &&
  symfony composer install &&
  symfony completion bash >/etc/bash_completion.d/symfony &&
  symfony console completion bash >/etc/bash_completion.d/console &&
  echo '. /etc/bash_completion' >>/root/.profile

#export SERVER_HOST="$(echo "${SERVER_API_URL}" | jq -rR 'capture("https?:\/\/(?<hostname>[^\/]+)\/?.*") | .hostname')"

[[ -n "${XDEBUG_CONFIG}" ]] &&
  ! php -v | grep Xdebug >/dev/null &&
  {
    echo -e "\e[33mInstalling xdebug extension\e[0m"
    install-php-extensions xdebug-3.4.0beta1
    echo "${XDEBUG_CONFIG}" |
      jq -rR 'split("\\s"; null) | .[] | . = "xdebug." + .' |
      cat >>"$(php --ini | jq -rR 'capture("(?<path>.+xdebug[^,]+),"; "g") | .path')"
    echo -e "\e[32mXdebug extension was plugged!\e[0m"
  }

# first arg is `-f` or `--some-option`
if [ "${1#-}" != "$1" ]; then
  set -- php "$@"
fi

exec "$@"
