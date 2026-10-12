FROM php:8.2-fpm

# Install dependensi sistem & ekstensi PHP untuk Database (MySQL)
RUN apt-get update && apt-get install -y \
    libpng-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-install pdo pdo_mysql gd

WORKDIR /var/www

# Copy seluruh source code ke container
COPY . .

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

EXPOSE 8000
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
