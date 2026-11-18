FROM php:8.2-apache

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Install PHP MySQL PDO extension
RUN docker-php-ext-install pdo pdo_mysql

# Copy codebase
COPY . /var/www/html/

# Set permissions
RUN chown -R www-data:www-data /var/www/html

# Dynamic port binding for Render ($PORT)
EXPOSE 80
CMD sed -i "s/80/${PORT:-80}/g" /etc/apache2/ports.conf /etc/apache2/sites-available/*.conf && apache2-foreground
