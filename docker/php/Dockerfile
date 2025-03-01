FROM php:8.4-fpm

RUN apt-get update && apt-get install -y \
    wget \
    git \
    unzip \
    libzip-dev \
    libicu-dev \
    libpq-dev \
    libonig-dev \
    && docker-php-ext-install zip intl pdo_mysql \
    && pecl install apcu xdebug \
    && docker-php-ext-enable apcu opcache xdebug \
    && rm -rf /var/lib/apt/lists/*

RUN wget https://get.symfony.com/cli/installer -O - | bash \
    && mv /root/.symfony*/bin/symfony /usr/local/bin/symfony

RUN wget https://getcomposer.org/installer -O composer-setup.php \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && rm composer-setup.php

RUN mkdir -p /var/www/var/cache /var/www/var/log \
    && chown -R www-data:www-data /var/www/var \
    && chmod -R 775 /var/www/var

COPY php.ini /usr/local/etc/php/conf.d/custom.ini

WORKDIR /var/www
RUN usermod -u 1000 www-data && groupmod -g 1000 www-data

CMD ["php-fpm"]
