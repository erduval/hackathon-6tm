# Utilise une image PHP avec Apache
FROM php:8.2-apache

# Installation des dépendances
RUN apt-get update && apt-get install -y \
    libicu-dev \
    && docker-php-ext-install -j$(nproc) intl pdo_mysql

# Configuration Apache
RUN a2enmod rewrite

# Copie du code source de Symfony dans le conteneur
COPY . /var/www/html

# Installation des dépendances PHP avec Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN cd /var/www/html && composer install --no-dev --optimize-autoloader

# Définition du port à exposer
EXPOSE 80

# Commande par défaut pour lancer Apache
CMD ["apache2-foreground"]