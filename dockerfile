# Étape 1 : base image
FROM php:8.2-apache

# Étape 2 : installer les extensions système
RUN apt-get update && apt-get install -y \
    libpq-dev \
    unzip \
    zip \
    git \
    curl \
    libzip-dev \
    && docker-php-ext-install pdo pdo_pgsql zip

# Étape 3 : activer mod_rewrite pour Laravel
RUN a2enmod rewrite

# Étape 4 : copier le code source Laravel
COPY . /var/www/html/

# Étape 5 : définir le bon working directory
WORKDIR /var/www/html

# Étape 6 : ajuster les permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage

# Étape 7 : installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Étape 8 : installer les dépendances Laravel
RUN composer install --no-interaction --optimize-autoloader

# Étape 9 : vider tous les caches Laravel
RUN php artisan config:clear && \
    php artisan cache:clear && \
    php artisan route:clear && \
    php artisan view:clear && \
    php artisan config:cache



# Étape 10 : exposer le port
EXPOSE 80
