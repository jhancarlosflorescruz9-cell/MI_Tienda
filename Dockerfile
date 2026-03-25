FROM php:8.1-apache

WORKDIR /var/www/html

# Instalar dependencias
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    zip \
    unzip

# Instalar extensiones PHP
RUN docker-php-ext-install pdo pdo_mysql zip gd

# Habilitar mod_rewrite
RUN a2enmod rewrite

# Copiar composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar archivos del proyecto
COPY . .

# Instalar dependencias de composer
RUN composer install --no-dev

# Instalar Node.js y npm
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Instalar dependencias npm y compilar
RUN npm install && npm run build

# Permisos
RUN chown -R www-data:www-data /var/www/html/storage
RUN chmod -R 775 /var/www/html/storage

# Exponer puerto
EXPOSE 80

# Comando para iniciar
CMD ["apache2-foreground"]