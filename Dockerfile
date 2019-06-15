FROM php:7.3-apache
COPY . /var/www/html/

RUN docker-php-ext-install pdo pdo_mysql mysqli

RUN a2enmod rewrite

WORKDIR /var/www/html
