# use the official PHP image as base image
FROM php:7.4-apache
# install packages
RUN apt-get update && apt-get install -y \
        mariadb-client \
        npm \
        libzip-dev \
        libpng-dev \
        libonig-dev \
        libxml2-dev \
        unzip
# install PHP extensions
RUN docker-php-ext-install \
        bcmath \
        ctype \
        fileinfo \
        gd \
        json \
        mbstring \
        opcache \
        pdo \
        pdo_mysql \
        tokenizer \
        xml \
        zip
# copy the Composer PHAR from the Composer image into the PHP image
COPY --from=composer:2.6.4 /usr/bin/composer /usr/bin/composer
# show that both Composer and PHP run as expected
WORKDIR /var/www/stocky
COPY . .

RUN composer update && composer install

RUN cp .env.example .env
RUN mkdir -p /var/www/stocky/storage/framework/sessions

RUN chown -R www-data:www-data /var/www/stocky/storage \
&& chown -R www-data:www-data /var/www/stocky/bootstrap/cache && chown www-data:www-data .env

RUN a2enmod rewrite headers
COPY stocky.conf /etc/apache2/sites-available/stocky.conf
RUN a2dissite 000-default.conf && a2ensite stocky.conf

RUN service apache2 restart

EXPOSE 80

CMD ["apache2-foreground"]