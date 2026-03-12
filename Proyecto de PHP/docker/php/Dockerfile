FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    libpng-dev \
    libzip-dev \
    unzip \
    curl \
    && docker-php-ext-install pdo pdo_mysql mysqli gd zip

WORKDIR /var/www/html