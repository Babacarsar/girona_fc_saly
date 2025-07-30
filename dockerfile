# Étape 1 : Utiliser une image officielle PHP avec extensions nécessaires
FROM php:8.2-fpm

# Étape 2 : Installer les dépendances système
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpq-dev libonig-dev libxml2-dev libzip-dev \
    && docker-php-ext-install pdo pdo_pgsql zip

# Étape 3 : Installer Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Étape 4 : Définir le répertoire de travail
WORKDIR /var/www

# Étape 5 : Copier les fichiers du projet Laravel
COPY . .

# Étape 6 : Installer les dépendances PHP
RUN composer install --no-dev --optimize-autoloader

# Étape 7 : Donner les bonnes permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Étape 8 : Exposer le port 8000
EXPOSE 8000

# Étape 9 : Lancer Laravel avec le serveur intégré
CMD php artisan serve --host=0.0.0.0 --port=8000
