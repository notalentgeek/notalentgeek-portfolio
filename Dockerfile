# Dockerfile
FROM php:8.3-fpm

# Install System Dependencies
RUN apt-get update && apt-get upgrade -y && apt install -q -y libpq-dev && docker-php-ext-install pdo_pgsql pgsql

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set Working Directory
WORKDIR /var/www