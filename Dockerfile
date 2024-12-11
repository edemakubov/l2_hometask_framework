FROM php:8.3-apache

RUN a2enmod rewrite

RUN apt-get update && apt-get install -y \
    zip \
    unzip \
    git
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
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install && composer dump-autoload --working-dir=/var/www/html
RUN apt-get update && apt-get install -y libpq-dev && docker-php-ext-install pdo pdo_pgsql



USER www-data