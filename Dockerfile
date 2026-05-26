FROM php:8.2-apache

# Active Apache rewrite (utile pour frameworks)
RUN a2enmod rewrite

# Copie du projet dans le serveur web
COPY . /var/www/html/

# Permissions
RUN chown -R www-data:www-data /var/www/html

# Port exposé
EXPOSE 80