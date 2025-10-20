FROM php:8.3-cli

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    libpq-dev git unzip && \
    docker-php-ext-install pdo pdo_pgsql

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copiar composer files primero para mejor caching
COPY composer.json composer.lock ./

# Instalar dependencias sin scripts de autoload primero
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Copiar el resto del código
COPY . .

# Ejecutar scripts de autoload ahora que tenemos artisan
RUN composer dump-autoload --optimize

# Asegurar permisos correctos
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 8000

CMD ["sh", "-c", "php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8000"]
