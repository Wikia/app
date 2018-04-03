FROM php:7.0.28-cli-jessie

# add jessie-backports repo (required to install libsass-dev package)
RUN echo 'deb http://ftp.debian.org/debian jessie-backports main' > /etc/apt/sources.list.d/backports.list

# install make (reuired by unit tests)
# and install PHP extensions required by MediaWiki
RUN apt-get update && apt-get install -y \
    autoconf \
    automake \
    libtool \
    make \
    wget \
    && docker-php-ext-install \
    mysqli


# sassphp extension / @see https://github.com/absalomedia/sassphp fork
RUN wget https://github.com/absalomedia/sassphp/archive/0.5.10.tar.gz -O sassphp.tar.gz \
    && mkdir -p /tmp/sassphp \
    && tar -xf sassphp.tar.gz -C /tmp/sassphp --strip-components=1 \
    # this installs libsass-3.4.3, matches with https://github.com/absalomedia/sassphp/releases/tag/0.5.10
    && apt-get -t jessie-backports install -y libsass-dev \
    && docker-php-ext-configure /tmp/sassphp \
    && docker-php-ext-install /tmp/sassphp \
    && rm -r /tmp/sassphp


# libmustache / @see https://github.com/jbboehr/libmustache
RUN wget https://github.com/jbboehr/libmustache/archive/v0.4.4.tar.gz -O libmustache.tar.gz \
    && mkdir -p /tmp/libmustache \
    && tar -xf libmustache.tar.gz -C /tmp/libmustache --strip-components=1 \
    && cd /tmp/libmustache \
    && autoreconf -fiv && ./configure --without-mustache-spec \
    && make && make install \
    && rm -r /tmp/libmustache

# mustache extension / @see https://github.com/jbboehr/php-mustache
RUN wget https://github.com/jbboehr/php-mustache/archive/v0.7.3.tar.gz -O mustache.tar.gz \
    && mkdir -p /tmp/mustache \
    && tar -xf mustache.tar.gz -C /tmp/mustache --strip-components=1 \
    && docker-php-ext-configure /tmp/mustache \
    && docker-php-ext-install /tmp/mustache \
    && rm -r /tmp/mustache


# expose volumes for app and config repositories clones
ENV WIKIA_DOCROOT=/usr/wikia/slot1/current/src
ENV WIKIA_CONFIG_ROOT=/usr/wikia/slot1/current/config

VOLUME /usr/wikia/slot1/current/src
VOLUME /usr/wikia/slot1/current/config

WORKDIR /usr/wikia/slot1/current/src
