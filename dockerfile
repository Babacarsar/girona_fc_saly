# Étape 1 : Image de base PHP avec Apache
FROM php:8.2-apache

# Étape 2 : Installer les extensions nécessaires (dont PostgreSQL)
RUN apt-get update && apt-get install -y \
    libpq-dev \
    unzip \
    zip \
    git \
    && docker-php-ext-install pdo pdo_pgsql

# Étape 3 : Activer le module Apache rewrite
RUN a2enmod rewrite

# Étape 4 : Copier les fichiers du projet Laravel dans le conteneur
COPY . /var/www/html

# Étape 5 : Copier un fichier apache.conf personnalisé (tu peux aussi le créer, je t’aide juste après)
COPY docker/apache.conf /etc/apache2/sites-available/000-default.conf

# Étape 6 : Permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Étape 7 : Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Étape 8 : Installer les dépendances Laravel
WORKDIR /var/www/html
RUN composer install --optimize-autoloader --no-dev

EXPOSE 80
