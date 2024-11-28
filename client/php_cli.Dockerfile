FROM php:cli
LABEL authors="mrx"

RUN apt update -qq && apt install -qq -y \
  unzip \
  curl \
  git \
  jq \
  wget \
  bash-completion

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
  zip \
 && curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.deb.sh' | bash \
 && apt install -qq -y symfony-cli