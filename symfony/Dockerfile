# Utilisation d'une image Symfony avec PHP 8.0
FROM php:8.2-fpm

# Installation des dépendances Symfony
RUN apt-get update \
    && apt-get install -y \
        git \
        curl \
        unzip \
        libpq-dev \
        libzip-dev \
        libicu-dev \
    && docker-php-ext-install pdo pdo_pgsql zip intl

# Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Définir le répertoire de travail
WORKDIR /var/www/symfony

# Copier uniquement les fichiers de configuration de Composer au début
COPY ./composer.json ./composer.lock ./

# Installer les dépendances PHP (bibliothèques)
RUN composer install

# Copier le reste du code Symfony dans le conteneur
COPY ./ .

# Exposer le port utilisé par Symfony
EXPOSE 8000

# Commande par défaut pour exécuter Symfony
CMD ["php", "bin/console", "server:run", "0.0.0.0:8000"]
