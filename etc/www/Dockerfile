FROM php:5.6-apache

RUN a2enmod rewrite

RUN apt-get update && apt-get install -y \
    && docker-php-ext-install pdo_mysql mbstring bcmath

RUN sed -e 's%www-data:x:33%www-data:x:1000%g' /etc/passwd -i

COPY ./000-default.conf /etc/apache2/sites-available/000-default.conf
