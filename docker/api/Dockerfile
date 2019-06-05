########################################################################################################################
##
## PHP
##
########################################################################################################################
FROM php:7.3-fpm AS php

## DEFAULT EXTENSIONS
RUN apt-get update && apt-get install --no-install-recommends -y \
      libzip-dev \
    && docker-php-ext-install bcmath \
    && docker-php-ext-install opcache \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install zip \
    && pecl install xdebug-2.7.2  \
    && rm -rf /var/lib/apt/lists/*

RUN mv "${PHP_INI_DIR}/php.ini-production" "${PHP_INI_DIR}/php.ini" \
    && sed -i 's/memory_limit = .*/memory_limit = 512M/' "${PHP_INI_DIR}/php.ini"

RUN rm -rfv /var/www/*

WORKDIR /var/www

########################################################################################################################
##
## COMPOSER
##
########################################################################################################################
FROM php AS composer

RUN apt-get update && apt-get install --no-install-recommends -y \
      curl \
      git \
      zip \
      unzip  \
   && rm -rf /var/lib/apt/lists/*

# install composer
RUN curl 'http://getcomposer.org/installer' | php -- --install-dir=/usr/local/bin/ --filename=composer

VOLUME '/var/www/.composer'

########################################################################################################################
##
## COMPOSER INSTALL
##
########################################################################################################################
FROM composer AS composer_install

COPY ./composer.json /var/www/composer.json
COPY ./composer.lock /var/www/composer.lock

RUN /usr/local/bin/composer install -o -v

########################################################################################################################
##
## API PRODUCTION
##
########################################################################################################################
FROM php AS api-production

## PHP OVERRIDES
COPY ./docker/api/php.ini "${PHP_INI_DIR}/conf.d/99-overrides.ini"

## COPY APPLICATION
COPY ./bin /var/www/bin
COPY ./config /var/www/config
COPY ./public /var/www/public
COPY ./src /var/www/src
COPY ./translations /var/www/translations
COPY ./.env /var/www/.env

# VENDOR DIRECTORY
COPY --from=composer_install /var/www/vendor /var/www/vendor

## CONFIGURE VAR
COPY ./var /var/www/var
RUN find /var/www/var -type d -exec chmod -v 0770 {} + \
    && find /var/www/var -type f -exec rm -v {} + \
    && chown -Rv www-data:www-data /var/www/var
VOLUME ["/var/www/var"]

COPY ./docker/api/*.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/*.sh

WORKDIR /var/www

ENTRYPOINT [ "/usr/local/bin/startup.sh" ]
CMD [ "/usr/local/sbin/php-fpm", "-F", "-O" ]

