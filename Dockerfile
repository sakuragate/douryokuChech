FROM php:8.2-apache

RUN a2enmod rewrite

COPY .htaccess index.php ArithmeticScienceClass.php /var/www/html/

EXPOSE 80
