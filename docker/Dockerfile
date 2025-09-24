FROM php:8.3-fpm

# Install system dependencies and build libraries
RUN apt-get update && apt-get install -y --no-install-recommends \
    curl nodejs npm git \
    unzip \
    libpq-dev \
    libonig-dev \
    libssl-dev \
    libxml2-dev \
    libcurl4-openssl-dev \
    libicu-dev \
    libzip-dev \
    && docker-php-ext-install -j$(nproc) \
    pdo_mysql \
    pdo_pgsql \
    pgsql \
    opcache \
    intl \
    zip \
    bcmath \
    soap \
    && pecl install redis xdebug \
    && docker-php-ext-enable redis xdebug\
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && apt-get autoremove -y && apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*
RUN mkdir /var/www/html/sys-recolection
WORKDIR /var/www/html/sys-recolection

# --- Usuario de desarrollo ---
ARG UID=1000
ARG GID=1000
RUN groupadd -g $GID devuser \
    && useradd -m -u $UID -g $GID -s /bin/bash devuser \
    && usermod -aG www-data devuser

# --- Copiar proyecto ---
COPY ../ . 

# --- Permisos para Laravel ---
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/sys-recolection/storage \
    && chmod -R 775 /var/www/html/sys-recolection/bootstrap/cache

# --- Instalar dependencias (con devuser) ---
USER devuser
RUN composer install --no-dev --optimize-autoloader || true
RUN npm install && npm run build || true

# --- Volver a www-data para PHP-FPM ---
USER www-data

EXPOSE 9000
CMD ["php-fpm"]