FROM node:10
RUN mkdir -p /var/www
WORKDIR /var/www
RUN npm install

FROM php:7.2-cli

RUN apt-get update && apt-get install -y libmcrypt-dev libfreetype6-dev curl libjpeg62-turbo-dev libpng-dev libpq-dev wget libzip-dev zip mariadb-client libmagickwand-dev \
    && docker-php-ext-install pdo_mysql \
    && pecl install mcrypt-1.0.1 \
    && pecl install imagick \
    && docker-php-ext-enable imagick \
    && docker-php-ext-enable mcrypt \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-configure zip --with-libzip \
    && docker-php-ext-install gd zip

#composer
RUN curl -s https://getcomposer.org/installer > ./composer-setup.php && php ./composer-setup.php --version=1.0.0 && mv composer.phar /usr/local/bin/composer
RUN composer global require hirak/prestissimo
#composer

#xdebug
RUN pecl install xdebug && docker-php-ext-enable xdebug
COPY ./php/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
RUN sed -i "s/xdebug.remote_autostart=0/xdebug.remote_autostart=1/" /usr/local/etc/php/conf.d/xdebug.ini && \
    sed -i "s/xdebug.remote_enable=0/xdebug.remote_enable=1/" /usr/local/etc/php/conf.d/xdebug.ini && \
    sed -i "s/xdebug.cli_color=0/xdebug.cli_color=1/" /usr/local/etc/php/conf.d/xdebug.ini
#xdebug

#php
COPY ./php/default.ini /usr/local/etc/php/conf.d/default.ini
#php

WORKDIR /var/www


