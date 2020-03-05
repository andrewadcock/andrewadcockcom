FROM php:7.4-fpm

# Extensions
RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    zlib1g-dev \
    libpng-dev \
    libpq-dev \
    libssl-dev \
    libxml2-dev \
    libmemcached-dev \
    wget \
    git

RUN docker-php-ext-configure gd \
    && docker-php-ext-install -j$(nproc) \
        gd \
        iconv \
        bcmath \
        mysqli \
        pcntl \
        pdo_mysql \
    && docker-php-ext-enable \
        opcache

RUN echo "$(curl -sS https://composer.github.io/installer.sig) -" > composer-setup.php.sig \
        && curl -sS https://getcomposer.org/installer | tee composer-setup.php | sha384sum -c composer-setup.php.sig \
        && php composer-setup.php && rm composer-setup.php* \
        && chmod +x composer.phar && mv composer.phar /usr/bin/composer

COPY symfony.ini /etc/php7/conf.d/
COPY symfony.ini /etc/php7/cli/conf.d/
COPY xdebug.ini  /etc/php7/conf.d/

COPY symfony.pool.conf /etc/php7/php-fpm.d/

#CMD ["php-fpm7", "-F"]

WORKDIR /var/www/symfony
EXPOSE 9000