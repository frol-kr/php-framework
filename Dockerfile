FROM php:7.2-fpm

ENV APP_DIR /app

# Adds the application code to the image
ADD . ${APP_DIR}

# Define current working directory.
WORKDIR ${APP_DIR}

RUN composer install \
    && bin/build.php
#    && vendor/bin/phpunit tests

EXPOSE 80