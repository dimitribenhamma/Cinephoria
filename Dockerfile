FROM php:8.2-apache

ENV APACHE_DOCUMENT_ROOT /var/www/html/public

# Permissions
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf && \
    sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/apache2.conf \
    /etc/apache2/conf-available/*.conf

RUN apt-get update && apt-get install -y \
    libicu-dev \
    && docker-php-ext-install intl
    
# Active Apache rewrite (utile pour frameworks)
RUN a2enmod rewrite

# Copie du projet dans le serveur web
COPY . /var/www/html

# Port exposé
EXPOSE 80
