# This is a Docker image for  Wikia's MediaWiki app that can be used locally by a developer.
# Simply mount your app and config repositories clone (refer to README.md)
FROM artifactory.wikia-inc.com/sus/php-wikia-base:225a68a

# install dev dependencies

# uopz extension / @see https://pecl.php.net/package/uopz
# XDebug extension / @see https://pecl.php.net/package/xdebug
# yaml extension / @see https://pecl.php.net/package/yaml / needed by db2yml.php
#
# these require autoconf package to be present
RUN pecl install uopz-6.0.1 xdebug-2.7.0 yaml-2.0.4 \
    && docker-php-ext-enable uopz xdebug yaml

# Disable php extensions not needed on dev
RUN cd /usr/local/etc/php/conf.d/ \
  && mkdir disabled \
  && mv docker-php-ext-opcache.ini disabled

# overwrite production php.ini settings on dev environment
ADD ./phpdev.ini /usr/local/etc/php/conf.d/

ADD ./xdebug.ini /usr/local/etc/php/conf.d/

VOLUME /usr/wikia/slot1/current/src
VOLUME /usr/wikia/slot1/current/config
VOLUME /usr/wikia/slot1/current/cache/messages

# we no longer need root's super-power
USER nobody
