# Base image
FROM php:8.1-fpm

# Set working directory
WORKDIR /var/www

# Install dependencies
RUN apt-get update && apt-get install -y \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Copy custom PHP configuration
COPY php/local.ini /usr/local/etc/php/conf.d/local.ini

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Add user for laravel application
# RUN groupadd -g 1000 www
# RUN useradd -u 1000 -ms /bin/bash -g www www


# Copy existing application directory contents
COPY . /var/www

# Copy existing application directory permissions
COPY --chown=www:www . /var/www

RUN chown -R www-data:www-data /var/www
RUN chmod -R 775 /var/www/storage
RUN chmod 644 /var/www/.env

# Change current user to www
# USER www
#RUN chmod -R 775 /var/www/bootstrap/cache

#RUN chown -R www-data:www-data /var/www/storage
#RUN chown -R www-data:www-data /var/www/bootstrap/cache


# Expose port 9000 (if you're using php-fpm as a service)
EXPOSE 9000

# Start PHP-FPM server
CMD ["php-fpm"]
