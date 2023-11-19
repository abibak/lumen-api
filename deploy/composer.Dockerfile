FROM composer:2.6.5

WORKDIR /var/www/project

CMD apt update && \
    apt install curl-php -y

CMD composer install
