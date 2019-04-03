# This is a base Docker image used by Wikia's MediaWiki app. It uses base PHP image provided by Docker with additional
# production dependencies installed.
FROM php:7.3.3-fpm-stretch

# set locale as required by MediaWiki / Perl
ENV LANG C.UTF-8
ENV LC_ALL C.UTF-8

# add jessie-backports repo (required to install libsass-dev package)
RUN apt-get update && apt-get install -y \
    autoconf \
    automake \
    libbz2-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    # needed by memcached
    libmemcached-dev \
    libpng-dev \
    libxml2-dev \
    # needed by wikidiff2
    libthai-dev \
    libtool \
    libyaml-dev \
    locales \
    # needed by Timeline extension
    ploticus \
    wget \
    # needed by php tidy extension
    libtidy-dev \
    # needed by php intl extension
    libicu-dev \
    # needed by php luasandbox extension
    liblua5.1-0-dev \
    # SUS-5500 | provides mysqldump needed by dumpStarters.php script
    default-mysql-client \
    # SUS-5807 | required by DumpsOnDemandTask
    p7zip-full \
    # needed by sass, this installs libsass-3.4.3, matches with https://github.com/absalomedia/sassphp/releases/tag/0.5.10
    && apt-get install -y libsass-dev \
    # cleanup
    && rm -rf /var/lib/apt/lists/* \
    #
    # sassphp extension / @see https://github.com/absalomedia/sassphp fork
    && cd /tmp \
    && wget https://github.com/Wikia/sassphp/archive/0.5.10.tar.gz -O sassphp.tar.gz \
    && mkdir -p /tmp/sassphp \
    && tar -xf sassphp.tar.gz -C /tmp/sassphp --strip-components=1 \
    && docker-php-ext-configure /tmp/sassphp \
    && docker-php-ext-install /tmp/sassphp \
    #
    # libmustache / @see https://github.com/jbboehr/libmustache
    && cd /tmp \
    && wget https://github.com/Wikia/libmustache/archive/v0.5.0.tar.gz -O libmustache.tar.gz \
    && mkdir -p /tmp/libmustache \
    && tar -xf libmustache.tar.gz -C /tmp/libmustache --strip-components=1 \
    && cd /tmp/libmustache \
    && autoreconf -fiv && ./configure --without-mustache-spec \
    && make && make install \
    #
    # mustache extension / @see https://github.com/jbboehr/php-mustache
    && cd /tmp \
    && wget https://github.com/Wikia/php-mustache/archive/v0.8.1.tar.gz -O mustache.tar.gz \
    && mkdir -p /tmp/mustache \
    && tar -xf mustache.tar.gz -C /tmp/mustache --strip-components=1 \
    && docker-php-ext-configure /tmp/mustache \
    && docker-php-ext-install /tmp/mustache \
    #
    # wikidiff2 extension / @see https://www.mediawiki.org/wiki/Extension:Wikidiff2#Manually
    && cd /tmp \
    && wget https://github.com/Wikia/wikidiff2/archive/1.4.1.tar.gz -O wikidiff2.tar.gz \
    && mkdir -p /tmp/wikidiff2 \
    && tar -xf wikidiff2.tar.gz -C /tmp/wikidiff2 --strip-components=1 \
    && docker-php-ext-configure /tmp/wikidiff2 \
    && docker-php-ext-install /tmp/wikidiff2 \
    #
    # tideways extension / @see https://tideways.com/
    && cd /tmp \
    && wget https://github.com/Wikia/php-xhprof-extension/archive/v4.1.7.tar.gz -O php-xhprof-extension.tar.gz \
    && mkdir -p /tmp/php-xhprof-extension \
    && tar -xf php-xhprof-extension.tar.gz -C /tmp/php-xhprof-extension --strip-components=1 \
    && docker-php-ext-configure /tmp/php-xhprof-extension \
    && docker-php-ext-install /tmp/php-xhprof-extension \
    #
    # luasandbox extension / @see https://www.mediawiki.org/wiki/LuaSandbox
    && cd /tmp \
    && wget https://github.com/Wikia/mediawiki-php-luasandbox/archive/3.0.1.tar.gz -O php-luasandbox-extension.tar.gz \
    && mkdir -p /tmp/php-luasandbox-extension \
    && tar -xf php-luasandbox-extension.tar.gz -C /tmp/php-luasandbox-extension --strip-components=1 \
    && docker-php-ext-configure /tmp/php-luasandbox-extension \
    && docker-php-ext-install /tmp/php-luasandbox-extension \
    #
    # SUS-5855 | redis pecl extension requied by Wikia\Metrics\Collector
    && pecl install --onlyreqdeps --force redis \
    && docker-php-ext-enable redis \
    #
    # install PHP extensions required by MediaWiki that are provided by Docker base PHP image helper
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install \
    bz2 \
    gd \
    mysqli \
    opcache \
    # simplexml: SimpleXMLElement is used by DesignSystem and PortableInfoboxBuilder extensions
    simplexml \
    # required by PortableInfobox
    tidy \
    # needed by RabbitMQ client
    bcmath \
    # RecentChange::notifyRC2UDP uses socket_create
    sockets \
    # used to read localisation cache data from CDB files
    dba \
    # needed by multithread scripts
    pcntl \
    # needed by IcuCollation class
    intl \
    # required by Exif.php class to render file's metdata
    exif \
    # remove no longer needed dependencies
    && apt-get remove -y \
        automake \
        wget \
    && apt-get autoremove -y \
    && rm -rf /tmp/*

# setup php.ini globally
ADD ./php.ini /usr/local/etc/php/php.ini

# add and validate PHP FPM configuration
ADD ./php-fpm.conf /usr/local/etc/php-fpm.d/zz-www.conf
RUN php-fpm --test

# expose volumes for app and config repositories clones
ENV WIKIA_DOCROOT=/usr/wikia/slot1/current/src
ENV WIKIA_CONFIG_ROOT=/usr/wikia/slot1/current/config

# run "sha1sum * | sha1sum" to update this value when this file (or any other in this directory) changes
ENV WIKIA_BASE_IMAGE_HASH=3c14b4f

WORKDIR /usr/wikia/slot1/current/src
