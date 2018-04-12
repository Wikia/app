# This is a Docker image for  Wikia's MediaWiki app that can be used locally by a developer.
# Simply mount your app and config repositories clone (refer to README.md)
FROM php-wikia-base

# install dev dependencies

# uopz extension / @see https://pecl.php.net/package/uopz
# yaml extension / @see https://pecl.php.net/package/yaml / needed by db2yml.php
RUN pecl install uopz-5.0.2 yaml-2.0.2 \
    && docker-php-ext-enable uopz yaml

# XDebug extension / @see https://pecl.php.net/package/xdebug
RUN yes | pecl install xdebug \
    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_autostart=off" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_port=9090" >> /usr/local/etc/php/conf.d/xdebug.ini

ENV XDEBUG_CONFIG="remote_host=host.config.internal"

# set environment variables
ENV SERVER_ID=165
ENV WIKIA_DATACENTER=poz
ENV WIKIA_ENVIRONMENT=dev
ENV WIKIA_DEV_DOMAIN=dsobczak.wikia-dev.pl

# we no longer need root's super-power
USER nobody
