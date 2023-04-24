FROM php:8.2-fpm-alpine
WORKDIR /var/www/html

USER root

# Install dependencies
RUN apk update && \
    apk add \
    curl

# Install extensions
RUN docker-php-ext-install pdo_mysql

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Expose port 9000 and start php-fpm server
EXPOSE 9000

CMD ["php-fpm"]
