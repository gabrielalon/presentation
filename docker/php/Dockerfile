ARG PHP_VERSION=""
FROM php:${PHP_VERSION:+${PHP_VERSION}-}fpm

# Install recommended extensions for Symfony
RUN apt-get update && apt-get install -y \
        libicu-dev \
        libpq-dev \
        libxml2-dev \
        zlib1g-dev \
        libzip-dev \
        git \
        vim \
        zip \
        cron \
        unzip \
        curl \
        gnupg \
        htop \
        ncdu \
        build-essential \
        jpegoptim \
        optipng \
        pngquant \
        gifsicle \
        libcurl4-openssl-dev \
        pkg-config \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libpng-dev \
        libonig-dev \
        graphviz \
        exiftool \
    && docker-php-ext-configure intl \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install \
        intl \
        exif \
        opcache \
        pdo pdo_mysql pdo_pgsql pgsql \
        mysqli \
        zip \
        pcntl \
        xml \
        json \
        mbstring \
        bcmath \
        gettext \
        gd \
    && docker-php-ext-enable \
        intl \
        exif \
        opcache \
        pdo pdo_mysql pdo_pgsql pgsql \
        mysqli \
        zip \
        pcntl \
        xml \
        json \
        mbstring \
        bcmath \
        gettext \
        gd

# Install Node.js
RUN curl -sL https://deb.nodesource.com/setup_10.x | bash - && \
    apt-get install -yq nodejs build-essential
RUN npm install -g npm
RUN npm install -g svgo # Install for media

# Cleanup
RUN apt-get update && apt-get upgrade -y && apt-get autoremove -y

# Install PHP Redis extension
RUN pecl install -o -f redis \
  &&  rm -rf /tmp/pear \
  &&  docker-php-ext-enable redis

# Install PHP Xdebug extension
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# Install composer
RUN curl --insecure https://getcomposer.org/composer.phar -o /usr/bin/composer && chmod +x /usr/bin/composer

# Permission fix
RUN usermod -u 1000 www-data

WORKDIR /var/www/html
RUN mkdir storage
RUN chown -R $USER:www-data storage
RUN chmod -R 775 storage
