FROM composer:2.2.7 as composer
FROM php:8.2-fpm-alpine

COPY --from=mlocati/php-extension-installer:latest /usr/bin/install-php-extensions /usr/bin/install-php-extensions

ENV APP_DIR=/var/www

RUN apk add --update --no-cache \
      git \
      wget \
      unzip \
      npm \
    && install-php-extensions \
      amqp \
      bcmath \
      gd \
      intl \
      pcntl \
      pdo_pgsql \
      soap \
      sockets \
      xdebug \
      xmlreader \
      zip

WORKDIR /var/www

COPY --from=composer /usr/bin/composer /usr/bin/composer

COPY etc/php.ini ${PHP_INI_DIR}/php.ini

EXPOSE 9000
