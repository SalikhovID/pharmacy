FROM php:8.1-fpm
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN apt-get update && apt-get install -y
RUN chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions calendar exif ffi gd gettext pcntl pdo_pgsql pgsql shmop sockets sysvmsg sysvsem sysvshm xdebug xsl intl
WORKDIR /var/www