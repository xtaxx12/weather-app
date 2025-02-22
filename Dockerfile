FROM php:8.2-fpm-alpine

# Instalar dependencias del sistema
RUN apk update && \
    apk add --no-cache \
    git \
    curl \
    zip \
    unzip \
    libzip-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    oniguruma-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo pdo_mysql zip exif pcntl

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar el código de la aplicación
COPY . .

# Instalar dependencias de Composer
RUN composer install --no-dev --optimize-autoloader

# Crear los directorios si no existen
RUN mkdir -p /var/www/storage /var/www/bootstrap/cache

# Configurar permisos
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
RUN chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Cambiar al usuario no root
USER www-data

# Exponer el puerto en el que se ejecutará la aplicación
EXPOSE 8080

# Comando para iniciar PHP-FPM
CMD ["php-fpm"]