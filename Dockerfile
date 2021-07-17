FROM php:7.1-cli

ENV COMPOSER_ALLOW_SUPERUSER=1
ENV COMPOSER_NO_INTERACTION=1
ENV DEBIAN_FRONTEND=noninteractive

RUN apt-get update
RUN apt-get install -y -qq libxml2-dev libzip-dev unzip --no-install-suggests --no-install-recommends
RUN docker-php-ext-install -j$(nproc) xml
RUN docker-php-ext-install -j$(nproc) zip
RUN rm -rf /var/lib/apt/lists/*
RUN apt-get clean

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --filename=composer --install-dir=/usr/local/bin --version=2.2.25 > /dev/null 2>&1 && \
    chmod +x /usr/local/bin/composer

WORKDIR /app

COPY .docker/php ./
