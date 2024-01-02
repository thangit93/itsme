FROM php:5.6-fpm-alpine

WORKDIR /

RUN apk update && apk add \
  wget \
  libpng-dev \
  libzip-dev \
  freetype \
  freetype-dev \
  jpeg-dev \
  zip \
  unzip

RUN docker-php-ext-install gd && \
  docker-php-ext-install opcache && \
  docker-php-ext-configure zip && \
  docker-php-ext-install zip && \
  docker-php-ext-install pdo_mysql pcntl

ARG DOCKER_UID
ARG DOCKER_GID
RUN if [ ${DOCKER_UID:-0} -ne 0 ] && [ ${DOCKER_GID:-0} -ne 0 ]; then \
    deluser www-data &&\
    if getent group www-data ; then delgroup www-data; fi &&\
    addgroup -g ${DOCKER_GID} www-data &&\
    adduser -u ${DOCKER_UID} -G www-data www-data --disabled-password &&\
    install -d -m 0755 -o www-data -g www-data /home/www-data \
;fi

COPY ./docker/app/docker-entrypoint.sh /docker-entrypoint.sh
RUN chmod +x /docker-entrypoint.sh
COPY . /app
WORKDIR /app
