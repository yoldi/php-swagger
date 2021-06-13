FROM php:8.0-cli-alpine
RUN apk add -U --no-cache --virtual temp \
    autoconf g++ make
RUN pecl channel-update pecl.php.net && pecl install pcov
RUN docker-php-ext-enable pcov

ENV COMPOSER_ALLOW_SUPERUSER 1
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer --quiet --1 \
    && composer global require hirak/prestissimo --no-plugins --no-scripts \
    && rm -rf /root/.composer/cache