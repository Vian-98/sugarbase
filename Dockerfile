# syntax=docker/dockerfile:1
# ─── Stage 1: build aset frontend (Vite + Tailwind) ───────────────────────────
FROM node:22-alpine AS frontend
WORKDIR /app
COPY package.json package-lock.json ./
RUN npm ci
COPY vite.config.js ./
COPY resources ./resources
COPY public ./public
RUN npm run build

# ─── Stage 2: dependensi PHP (composer) ───────────────────────────────────────
FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install \
    --no-dev --no-interaction --no-progress --prefer-dist --no-scripts
COPY . .
RUN mkdir -p bootstrap/cache \
        storage/framework/cache storage/framework/sessions storage/framework/views \
        storage/logs storage/app/public \
    && composer dump-autoload --optimize --no-dev --classmap-authoritative \
    && php artisan package:discover --ansi

# ─── Stage 3: runtime (Apache + PHP-FPM-less, mod_php) ────────────────────────
FROM php:8.3-apache

RUN apt-get update && apt-get install -y --no-install-recommends \
        libpq-dev \
        libzip-dev \
        libpng-dev \
        libjpeg-dev \
        libfreetype-dev \
        libonig-dev \
        unzip \
    && docker-php-ext-configure gd --with-jpeg --with-freetype \
    && docker-php-ext-install -j"$(nproc)" \
        pdo_pgsql \
        pdo_mysql \
        zip \
        gd \
        mbstring \
        opcache \
    && a2enmod rewrite headers \
    && rm -rf /var/lib/apt/lists/*

# Konfigurasi PHP production
RUN { \
        echo 'memory_limit=256M'; \
        echo 'upload_max_filesize=16M'; \
        echo 'post_max_size=20M'; \
        echo 'max_execution_time=60'; \
        echo 'expose_php=Off'; \
        opcache.enable=1; \
        opcache.memory_consumption=192; \
        opcache.interned_strings_buffer=16; \
        opcache.max_accelerated_files=20000; \
        opcache.validate_timestamps=0; \
    } > /usr/local/etc/php/conf.d/app.ini

# Document root ke public/, AllowOverride supaya .htaccess Laravel aktif
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
        /etc/apache2/sites-available/000-default.conf \
        /etc/apache2/apache2.conf \
    && sed -ri 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf \
    && printf 'ServerName localhost\n' > /etc/apache2/conf-available/servername.conf \
    && a2enconf servername

WORKDIR /var/www/html
COPY --from=vendor --chown=www-data:www-data /app /var/www/html
COPY --from=frontend /app/public/build /var/www/html/public/build
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh \
    && mkdir -p storage/framework/{cache,sessions,views} storage/logs storage/app/public bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

EXPOSE 80
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
