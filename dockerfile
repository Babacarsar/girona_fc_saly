# ✅ Dockerfile (placer à la racine de ton projet Laravel)

FROM php:8.2-apache

# Installer extensions utiles
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    curl \
    git \
    libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip

# Activer mod_rewrite
RUN a2enmod rewrite

# Copier projet
COPY . /var/www/html/

# Travailler dans le dossier Laravel
WORKDIR /var/www/html

# Donner les bons droits
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Installer dépendances
RUN composer install --no-interaction --optimize-autoloader

# Clear + cache Laravel
RUN php artisan config:clear && \
    php artisan cache:clear && \
    php artisan route:clear && \
    php artisan view:clear && \
    php artisan config:cache

EXPOSE 80
