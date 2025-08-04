FROM php:8.3-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libsqlite3-dev \
    sqlite3 \
    zip \
    unzip \
    && docker-php-ext-install pdo_mysql pdo_sqlite mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy existing application directory
COPY . /var/www

# Install PHP dependencies via Composer
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Set correct permissions for Laravel
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage \
    && chmod -R 755 /var/www/bootstrap/cache \
    && chmod -R 775 /var/www/database

# Optional: create SQLite database file
RUN touch /var/www/database/database.sqlite \
    && chown www-data:www-data /var/www/database/database.sqlite

# Expose port
EXPOSE 9000

# Start PHP-FPM
CMD ["php-fpm"]
