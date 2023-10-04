FROM php:7.4-apache

# Copy virtual host config into container
COPY stocky.conf /etc/apache2/sites-available/000-default.conf

# Enable Apache modules
RUN a2enmod rewrite headers

# Install dependencies
RUN apt-get update && apt-get install -y \
        libzip-dev \
        libpng-dev \
        libonig-dev \
        libxml2-dev \
        unzip \
        -y --no-install-recommends

# Install PHP extensions
RUN docker-php-ext-install \
        bcmath \
        ctype \
        fileinfo \
        gd \
        json \
        mbstring \
        opcache \
        pdo_mysql \
        tokenizer \
        xml \
        zip

COPY --from=composer:2.6.4 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/stocky

CMD ["apache2-foreground"]