# Usar una imagen base ligera
FROM php:8.1-fpm-alpine

# Establecer el directorio de trabajo
WORKDIR /var/www

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
    postgresql-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo pdo_mysql pdo_pgsql mbstring zip exif pcntl

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar el código de la aplicación
COPY . .

# Instalar dependencias de Composer (si existe composer.json)
RUN if [ -f "composer.json" ]; then composer install --no-dev --optimize-autoloader; fi

# Configurar permisos
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
RUN chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Cambiar al usuario no root
USER www-data

# Exponer el puerto 9000 (puerto predeterminado de PHP-FPM)
EXPOSE 9000

# Comando para iniciar PHP-FPM
CMD ["php-fpm"]