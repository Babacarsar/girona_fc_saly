# Dockerfile pour Laravel sur Render avec Apache
FROM php:8.2-apache

# Installer les extensions PHP nécessaires
RUN docker-php-ext-install pdo pdo_pgsql

# Activer le module Apache rewrite
RUN a2enmod rewrite

# Copier les fichiers Laravel dans le conteneur
COPY . /var/www/html

# Copier la configuration Apache personnalisée
COPY ./docker/apache.conf /etc/apache2/sites-available/000-default.conf

# Donner les permissions nécessaires
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Installer les dépendances PHP Laravel
WORKDIR /var/www/html
RUN composer install --no-dev --optimize-autoloader

# Exposer le port 80
EXPOSE 80

# Démarrer Apache
CMD ["apache2-foreground"]
