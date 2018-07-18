FROM php:7.2-fpm

RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libicu-dev \
        wget \
        mc \
            --no-install-recommends

RUN docker-php-ext-install \
    zip \
    intl \
    mbstring \
    pdo_mysql \
    exif \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install gd

RUN pecl install -o -f xdebug \
    && rm -rf /tmp/pear

COPY ./php/install-composer.sh /
COPY ./php/php.ini /usr/local/etc/php/

RUN apt-get purge -y g++ \
    && apt-get autoremove -y \
    && rm -r /var/lib/apt/lists/* \
    && rm -rf /tmp/* \
    && sh /install-composer.sh \
    && rm /install-composer.sh

# ARG hostUID=1000
# ARG hostGID=1000
# RUN usermod -u $hostUID www-data \
#    && usermod -u $hostGID www-data 

VOLUME /root/.composer
WORKDIR /app

EXPOSE 9000

CMD ["php-fpm"]
