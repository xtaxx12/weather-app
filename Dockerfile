# Dockerfile
FROM php:8.1-fpm
WORKDIR /var/www
COPY . .
RUN docker-php-ext-install pdo pdo_mysql
