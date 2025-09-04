# Use official WordPress image with Apache
FROM wordpress:php8.2-apache

# Install additional PHP extensions and dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Set working directory
WORKDIR /var/www/html

# Copy WordPress files
COPY wp-content/ /var/www/html/wp-content/

# Copy WordPress configuration
COPY wp-config.php /var/www/html/wp-config.php

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Configure Apache for Cloud Run
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Expose port 8080 for Cloud Run
EXPOSE 8080

# Start Apache
CMD ["apache2-foreground"]
