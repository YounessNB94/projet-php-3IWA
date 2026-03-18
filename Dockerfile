FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libicu-dev \
    libzip-dev \
    libpq-dev \
    && docker-php-ext-install \
    intl \
    pdo \
    pdo_mysql \
    zip \
    opcache

WORKDIR /var/www/html

RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
