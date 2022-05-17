FROM php:7.4-apache

ARG uid=1000
ARG user=user

ENV APACHE_DOCUMENT_ROOT=/var/www/public

RUN a2enmod rewrite
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN apt-get update && apt-get install -y \
    git \
    curl \
    sudo \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libwebp-dev \
    pv \
    zip \
    unzip \
    && docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install gd

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN curl -sL https://deb.nodesource.com/setup_17.x | sudo -E bash - \
    && apt-get install -y nodejs

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && echo "xdebug.mode=coverage" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    mkdir -p /home/$user/.ssh && \
    chown -R $user:$user /home/$user

# Install Composer 
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

#RUN ssh-keyscan -t rsa github.com > /home/$user/.ssh/known_hosts

# Set working directory
WORKDIR /var/www

USER $user

# Install PHP CodeSniffer
RUN composer global require "squizlabs/php_codesniffer=*"

RUN /home/$user/.composer/vendor/bin/phpcs --config-set show_progress 1 && \
    /home/$user/.composer/vendor/bin/phpcs --config-set colors 1 && \
    /home/$user/.composer/vendor/bin/phpcs --config-set report_width 140 && \
    /home/$user/.composer/vendor/bin/phpcs --config-set encoding utf-8

ENV PATH="/home/$user/.composer/vendor/bin:${PATH}"
