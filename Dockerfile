FROM php:8.3-apache

RUN a2enmod rewrite

# Copy app files from the app directory.
COPY ./framework /var/www/html

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

RUN echo "<Directory /var/www/html>\n\
    AllowOverride All\n\
</Directory>" > /etc/apache2/conf-available/allow-override.conf \
    && a2enconf allow-override

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --working-dir=/var/www/html

# Set permissions for Psalm cache directory
RUN mkdir -p /var/www/html/cache \
    && chown -R www-data:www-data /var/www/html/cache \
    && chmod -R 755 /var/www/html/cache

USER www-data