# Dockerfile
FROM php:8.3-fpm

# Install System Dependencies
RUN apt-get update && apt-get upgrade -y

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set Working Directory
WORKDIR /var/www
