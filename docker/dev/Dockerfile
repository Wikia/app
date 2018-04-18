# This is a Docker image for  Wikia's MediaWiki app that can be used locally by a developer.
# Simply mount your app and config repositories clone (refer to README.md)
FROM artifactory.wikia-inc.com/sus/php-wikia-base:7.0.28-fpm

# install dev dependencies

# uopz extension / @see https://pecl.php.net/package/uopz
# XDebug extension / @see https://pecl.php.net/package/xdebug
# yaml extension / @see https://pecl.php.net/package/yaml / needed by db2yml.php
RUN pecl install uopz-5.0.2 xdebug-2.6.0 yaml-2.0.2 \
    && docker-php-ext-enable uopz xdebug yaml

ADD ./xdebug.ini /usr/local/etc/php/conf.d/

# we no longer need root's super-power
USER nobody
