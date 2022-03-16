FROM php:7.4-fpm

RUN apt-get update && apt-get install -y \
    unzip wget\
 #       for CI
        ssh \
        rsync \
        zip \
        unzip 


ENV ACCEPT_EULA=Y
ENV COMPOSER_ALLOW_SUPERUSER 1


# Install Composer
RUN php -r "readfile('https://getcomposer.org/installer');" | php\
    && chmod +x composer.phar\
    && mv composer.phar /usr/local/bin/composer



# Install PDO
RUN apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql

RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libpng-dev \
        vim \
        git \
    && docker-php-ext-install -j$(nproc) iconv bcmath \
    && docker-php-ext-install -j$(nproc) gd

RUN apt-get install -y zlib1g-dev libicu-dev g++ libzip-dev && \
    docker-php-ext-configure intl && \
    docker-php-ext-install intl zip sockets

RUN apt-get install -y libxslt-dev
RUN docker-php-ext-install xsl soap mysqli pcntl

# Install xdebug
RUN pecl install xdebug-2.9.1 \
    && docker-php-ext-enable xdebug

# Install Redis extension
RUN pecl install -o -f redis \
    && rm -rf /tmp/pear \
    && echo "extension=redis.so" > /usr/local/etc/php/conf.d/docker-php-ext-redis.ini

CMD php-fpm

