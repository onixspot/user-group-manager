FROM unit:php
#FROM unit:1.33.0-php8.3
LABEL authors="mrx"

RUN apt update -qq && apt install -qq -y \
  unzip \
  curl \
  git \
  jq \
  wget \
  bash-completion

ADD --chmod=0755 https://github.com/nginx/unit/releases/download/1.33.0/unitctl-1.33.0-x86_64-unknown-linux-gnu /usr/bin/unitctl

RUN mv "${PHP_INI_DIR}"/php.ini-production "${PHP_INI_DIR}"/php.ini

ADD --chmod=0755 https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN install-php-extensions \
      apcu \
      curl \
      http \
      intl \
      json \
      memcached \
      opcache \
      pdo_mysql \
      zip \
 && curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.deb.sh' | bash \
 && apt install -qq -y symfony-cli

EXPOSE 80 443