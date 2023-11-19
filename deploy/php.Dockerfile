FROM php:8.2-fpm-alpine

RUN set -ex \
  && apk --no-cache add \
    postgresql-dev

RUN docker-php-ext-install pgsql pdo_pgsql

WORKDIR /var/www/project

COPY ../ /var/www/project

