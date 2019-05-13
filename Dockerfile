FROM php:7.2-fpm

ENV APP_DIR /app

# Adds the application code to the image
ADD . ${APP_DIR}

# Define current working directory.
WORKDIR ${APP_DIR}

# Cleanup
RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

#RUN composer install \
#    && php bin/build.php \
#    && vendor/bin/phpunit tests

EXPOSE 80