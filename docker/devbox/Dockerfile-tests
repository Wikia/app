# This is a Docker image for  Wikia's MediaWiki app that can be used on devboxes.
# Simply mount your app and config repositories clone (refer to README.md)
FROM artifactory.wikia-inc.com/sus/php-wikia-base:959312e

# install dev dependencies

# yaml extension / @see https://pecl.php.net/package/yaml / needed by db2yml.php
#
# these require autoconf package to be present

RUN pecl install yaml-2.0.4 uopz-6.0.1 \
    && docker-php-ext-enable yaml uopz

# Configure dev opcache
ADD ./opcache.ini /usr/local/etc/php/conf.d/docker-php-ext-opcache.ini

# Configure uopz, make sure exit function is not disabled
ADD ./uopz.ini /usr/local/etc/php/conf.d/docker-php-ext-uopz.ini

# Overwrite production php.ini settings on dev environment
ADD ./phpdev.ini /usr/local/etc/php/conf.d/

WORKDIR /usr/wikia/slot1/current/src/

# Mount the source and messages cache

VOLUME /usr/wikia/slot1/current/src
VOLUME /usr/wikia/slot1/current/config
VOLUME /usr/wikia/slot1/current/cache/messages

# we no longer need root's super-power
USER nobody


