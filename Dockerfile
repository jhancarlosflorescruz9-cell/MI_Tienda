FROM php:8.1-apache
WORKDIR /var/www/html
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libjpeg-dev libfreetype6-dev libzip-dev zip unzip
RUN docker-php-ext-install pdo pdo_mysql zip gd
RUN a2enmod rewrite
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY . .
RUN composer install --no-dev
RUN chown -R www-data:www-data /var/www/html/storage
RUN chmod -R 775 /var/www/html/storage
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|g' /etc/apache2/sites-available/000-default.conf
EXPOSE 80
CMD ["apache2-foreground & php artisan migrate --force"]