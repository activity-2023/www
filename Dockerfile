FROM php:8.3-apache AS base

FROM base AS deps
WORKDIR /www

RUN apt update && apt install -y \
    libzip-dev \
    zip \
    && docker-php-ext-install zip

COPY --from=composer/composer:2.7-bin /composer /usr/bin/composer
COPY composer.json composer.lock ./
RUN COMPOSER_ALLOW_SUPERUSER=1 composer install

FROM base AS runner
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
WORKDIR /www

RUN apt update && apt install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql pgsql

COPY --from=deps /www/vendor ./vendor
COPY . .

ENV DB_USER="activity"
ENV DB_PASSWORD="activity"
ENV DB_HOST="adb"
ENV DB_PORT="5432"

ENV APACHE_DOCUMENT_ROOT /www/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
RUN a2enmod rewrite

EXPOSE 80