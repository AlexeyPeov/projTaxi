FROM composer:2.3

FROM php:8.1-fpm
WORKDIR /www
COPY --from=composer:2.3 /usr/bin/composer /usr/bin/composer