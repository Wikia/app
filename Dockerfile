FROM php:7.0.28-cli-jessie

# add jessie-backports repo (required to install libsass-dev package)
RUN echo 'deb http://ftp.debian.org/debian jessie-backports main' > /etc/apt/sources.list.d/backports.list

# install make (reuired by unit tests)
RUN apt-get update && apt-get install -y \
    autoconf \
    automake \
    libbz2-dev \
    # needed by wikidiff2
    libthai-dev \
    libtool \
    libyaml-dev \
    locales \
    make \
    wget \
    # needed by sass
    && apt-get -t jessie-backports install -y libsass-dev

# set locale as required by MediaWiki / Perl
ENV LANG C.UTF-8
ENV LC_ALL C.UTF-8


# sassphp extension / @see https://github.com/absalomedia/sassphp fork
RUN wget https://github.com/Wikia/sassphp/archive/0.5.10.tar.gz -O sassphp.tar.gz \
    && mkdir -p /tmp/sassphp \
    && tar -xf sassphp.tar.gz -C /tmp/sassphp --strip-components=1 \
    # this installs libsass-3.4.3, matches with https://github.com/absalomedia/sassphp/releases/tag/0.5.10
    && apt-get -t jessie-backports install -y libsass-dev \
    && docker-php-ext-configure /tmp/sassphp \
    && docker-php-ext-install /tmp/sassphp \
    && rm -r /tmp/sassphp


# libmustache / @see https://github.com/jbboehr/libmustache
RUN wget https://github.com/Wikia/libmustache/archive/v0.4.4.tar.gz -O libmustache.tar.gz \
    && mkdir -p /tmp/libmustache \
    && tar -xf libmustache.tar.gz -C /tmp/libmustache --strip-components=1 \
    && cd /tmp/libmustache \
    && autoreconf -fiv && ./configure --without-mustache-spec \
    && make && make install \
    && rm -r /tmp/libmustache

# mustache extension / @see https://github.com/jbboehr/php-mustache
RUN wget https://github.com/Wikia/php-mustache/archive/v0.7.3.tar.gz -O mustache.tar.gz \
    && mkdir -p /tmp/mustache \
    && tar -xf mustache.tar.gz -C /tmp/mustache --strip-components=1 \
    && docker-php-ext-configure /tmp/mustache \
    && docker-php-ext-install /tmp/mustache \
    && rm -r /tmp/mustache


# wikidiff2 extension / @see https://www.mediawiki.org/wiki/Extension:Wikidiff2#Manually
RUN wget https://github.com/Wikia/wikidiff2/archive/1.4.1.tar.gz -O wikidiff2.tar.gz \
    && mkdir -p /tmp/wikidiff2 \
    && tar -xf wikidiff2.tar.gz -C /tmp/wikidiff2 --strip-components=1 \
    && docker-php-ext-configure /tmp/wikidiff2 \
    && docker-php-ext-install /tmp/wikidiff2 \
    && rm -r /tmp/wikidiff2

# install PHP extensions required by MediaWiki that are provided by Docker base PHP image helper
RUN docker-php-ext-install \
    bz2 \
    mysqli \
    opcache

# TODO: move below dependencies to dev app image
# uopz extension / @see https://pecl.php.net/package/uopz
# XDebug extension / @see https://pecl.php.net/package/xdebug
# yaml extension / @see https://pecl.php.net/package/yaml / needed by db2yml.php
RUN pecl install uopz-5.0.2 xdebug-2.6.0 yaml-2.0.2 \
    && docker-php-ext-enable uopz xdebug yaml

# expose volumes for app and config repositories clones
ENV WIKIA_DOCROOT=/usr/wikia/slot1/current/src
ENV WIKIA_CONFIG_ROOT=/usr/wikia/slot1/current/config

VOLUME /usr/wikia/slot1/current/src
VOLUME /usr/wikia/slot1/current/config
VOLUME /usr/wikia/slot1/current/cache/messages

WORKDIR /usr/wikia/slot1/current/src
