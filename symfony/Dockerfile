# Utilisation d'une image Symfony avec PHP 8.0
FROM php:8.0-fpm

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

# Copie du code Symfony dans le conteneur
COPY . /var/www/symfony
WORKDIR /var/www/symfony

# Installation des dépendances Symfony
RUN composer install --no-scripts

# Exposer le port utilisé par Symfony
EXPOSE 8000

# Commande par défaut pour exécuter Symfony
CMD ["php", "bin/console", "server:run", "0.0.0.0:8000"]
