FROM php:7.0.28-cli-alpine

# install PHP extensions required by MediaWiki
RUN docker-php-ext-install mysqli

# expose volumes for app and config repositories clones
ENV WIKIA_DOCROOT=/usr/wikia/slot1/current/src
ENV WIKIA_CONFIG_ROOT=/usr/wikia/slot1/current/config

VOLUME /usr/wikia/slot1/current/src
VOLUME /usr/wikia/slot1/current/config

WORKDIR /usr/wikia/slot1/current/src
