FROM php:7.2-fpm

ENV APP_DIR /app

RUN apt-get update \
  && apt-get install -y libzip-dev zip \
  && docker-php-ext-configure zip --with-libzip \
  && docker-php-ext-install zip

RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer && \
    composer global require hirak/prestissimo --no-plugins --no-scripts

# Adds the application code to the image
ADD . ${APP_DIR}

# Define current working directory.
WORKDIR ${APP_DIR}

RUN composer install \
    && bin/build.php
#    && vendor/bin/phpunit tests

EXPOSE 80