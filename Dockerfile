FROM php:8.2-fpm-alpine

# Instalar Nginx y otras dependencias
RUN apk update && \
    apk add --no-cache \
    nginx \
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

# Crear los directorios necesarios
RUN mkdir -p /var/www/storage /var/www/bootstrap/cache

# Configurar permisos
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
RUN chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Copiar la configuración de Nginx
COPY nginx.conf /etc/nginx/conf.d/default.conf

# Exponer los puertos
EXPOSE 80

# Iniciar Nginx y PHP-FPM
CMD sh -c "nginx && php-fpm"