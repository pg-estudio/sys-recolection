FROM php:8.3-fpm-alpine

# Instalar dependencias del sistema y extensiones PHP
RUN apk add --no-cache \
    git curl libpng-dev libjpeg-turbo-dev freetype-dev oniguruma-dev zip unzip bash \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring gd exif pcntl bcmath

# Instalar Composer (copiado desde la imagen oficial)
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copiar archivos del proyecto
COPY . .

RUN npm install && npm run build

# Instalar dependencias de Laravel
RUN composer install --no-dev --optimize-autoloader || true

# Permisos a las carpetas necesarias
RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 9000
CMD ["php-fpm"]