# Use PHP Apache base image
FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    wget \
    && docker-php-ext-install zip mysqli pdo pdo_mysql \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Set working directory
WORKDIR /var/www/html

# Download and extract WordPress
RUN wget https://wordpress.org/latest.tar.gz \
    && tar -xzf latest.tar.gz \
    && mv wordpress/* . \
    && rmdir wordpress \
    && rm latest.tar.gz

# Copy WordPress files
COPY wp-content/ /var/www/html/wp-content/

# Copy WordPress configuration
COPY wp-config.php /var/www/html/wp-config.php

# Copy .htaccess for URL rewriting
COPY .htaccess /var/www/html/.htaccess

# Copy fix script
COPY fix-site-url.php /var/www/html/fix-site-url.php

# Copy emergency fix script
COPY emergency-fix.php /var/www/html/emergency-fix.php

# Copy reset script
COPY reset-wordpress.php /var/www/html/reset-wordpress.php

# Configure Apache for Cloud Run (listen on port 8080)
RUN sed -i 's/Listen 80/Listen 8080/' /etc/apache2/ports.conf \
    && sed -i 's/<VirtualHost \*:80>/<VirtualHost *:8080>/' /etc/apache2/sites-available/000-default.conf \
    && echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Create a startup script to handle Cloud Run's PORT environment variable
RUN echo '#!/bin/bash\n\
# Use PORT environment variable if set, otherwise default to 8080\n\
PORT=${PORT:-8080}\n\
echo "Starting Apache on port $PORT"\n\
sed -i "s/Listen 8080/Listen $PORT/" /etc/apache2/ports.conf\n\
sed -i "s/<VirtualHost \*:8080>/<VirtualHost *:$PORT>/" /etc/apache2/sites-available/000-default.conf\n\
apache2-foreground' > /usr/local/bin/start-apache.sh \
    && chmod +x /usr/local/bin/start-apache.sh

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Expose port 8080 for Cloud Run
EXPOSE 8080

# Start Apache using our custom script
CMD ["/usr/local/bin/start-apache.sh"]
