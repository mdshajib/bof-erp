FROM ubuntu:22.04

# Copy composer.lock and composer.json
COPY composer.lock composer.json /var/www/

# Install dockerize so we can wait for containers to be ready
ENV DOCKERIZE_VERSION 0.6.1

# RUN curl -s -f -L -o /tmp/dockerize.tar.gz https://github.com/jwilder/dockerize/releases/download/v$DOCKERIZE_VERSION/dockerize-linux-amd64-v$DOCKERIZE_VERSION.tar.gz \
#     && tar -C /usr/local/bin -xzvf /tmp/dockerize.tar.gz \
#     && rm /tmp/dockerize.tar.gz

# Install Composer
ENV COMPOSER_VERSION 2.1.5

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --version=$COMPOSER_VERSION

# Install dependencies
RUN apt update && apt install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl

# Clear cache
RUN apt clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl
RUN docker-php-ext-configure gd --with-gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ --with-png-dir=/usr/include/
RUN docker-php-ext-install gd

COPY ./docker/php/laravel.ini /usr/local/etc/php/conf.d/laravel.ini

WORKDIR /var/www

RUN chown -R www-data:www-data .

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]