FROM php:7.4-fpm

USER root

# Add the content
ADD . /app/

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    unzip \
    libzip-dev libsodium-dev zlib1g-dev libicu-dev g++ \
    git \
    sudo \
    curl

# Install docker-php-extension
ADD https://raw.githubusercontent.com/mlocati/docker-php-extension-installer/master/install-php-extensions /usr/local/bin/
RUN chmod uga+x /usr/local/bin/install-php-extensions && sync

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install pdo_mysql zip exif pcntl sodium intl opcache
RUN docker-php-ext-install gd

# Install Test dependencies
RUN pecl install xdebug
RUN docker-php-ext-enable xdebug

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Add user
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Permissions
RUN chown -R www:www /app && \
    mkdir /var/log/php-fpm && \
    touch /var/log/php-fpm/access.log && \
    touch /var/log/php-fpm/error.log && \
    touch /var/log/php-fpm/slow.log && \
    touch /var/log/php-fpm/php-fpm.log

# Composer setup
USER www
WORKDIR /app
RUN composer install --prefer-dist --optimize-autoloader

# Run
ADD docker/php-fpm/app.conf /usr/local/etc/php-fpm.d/app.conf
COPY docker/php-fpm/opcache.ini /usr/local/etc/php-fpm.d/opcache.ini
COPY docker/php-fpm/xdebug.ini /usr/local/etc/php-fpm.d/xdebug.ini
USER root
EXPOSE 7000
CMD ["php-fpm"]
