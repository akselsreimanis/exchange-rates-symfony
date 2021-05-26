FROM php:7.4-fpm-alpine

RUN set -ex \
  && apk --no-cache add \
    postgresql-dev

RUN docker-php-ext-install pdo pdo_pgsql

## Install composer
RUN wget https://getcomposer.org/installer && \
    php installer --install-dir=/usr/local/bin/ --filename=composer && \
    rm installer

## Install symfony cli
RUN set -xe && \
    apk update && \
    apk add --no-cache \
        bash \
        ca-certificates \
        git && \
    curl -sS https://get.symfony.com/cli/installer | bash && \
    mv /root/.symfony/bin/symfony /usr/local/bin/symfony && \
    chmod +x /usr/local/bin/symfony && \
    addgroup -S _www && \
    adduser -S _www -G _www

## Install node and yarn
RUN set -xe && \
    apk update && \
    apk add --no-cache \
        nodejs-lts \
        yarn \
        npm && \
    rm -rf /tmp/*


