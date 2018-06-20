FROM artifactory.wikia-inc.com/sus/php-wikia-base:latest

RUN apt-get update && apt-get install -y \
    perl \
    libmysqlclient-dev \
    libtry-tiny-perl \
    libclass-dbi-perl \
    libcompress-raw-zlib-perl \
    libcrypt-ssleay-perl \
    libdatetime-perl \
    libdbd-mysql-perl \
    libjson-perl \
    libmediawiki-api-perl \
    libtheschwartz-perl \
    libyaml-perl \
    libcache-memcached-perl \
    libcommon-sense-perl \
    libdata-types-perl \
    libjson-xs-perl \
    libmime-lite-perl \
    libmoosex-singleton-perl \
    libparallel-forkmanager-perl \
    libphp-serialization-perl \
    libthread-pool-simple-perl \
    libyaml-libyaml-perl \
    libipc-run-perl \
    libmoosex-getopt-perl \
    libarchive-zip-perl \
    libmoosex-role-parameterized-perl \
    libdevel-nytprof-perl \
    libbit-vector-perl \
    libplack-perl \
    libdancer-perl \
    libmoose-perl \
    libimage-librsvg-perl \
    libimage-info-perl \
    libnamespace-autoclean-perl \
    libfile-libmagic-perl \
    libimager-perl \
    libmath-round-perl \
    libgraphics-magick-perl \
    perlmagick \
    dh-make-perl \
    liblocal-lib-perl \
    perl-doc \
    libxml-simple-perl \
    libdbi-perl \
    libterm-readkey-perl \
    libterm-readline-perl-perl \
    libspreadsheet-parseexcel-perl \
    libdate-manip-perl \
    libdata-dump-perl \
    libunicode-string-perl \
    libterm-progressbar-perl \
    libstring-shellquote-perl \
    libmoosex-types-json-perl \
    libnet-twitter-lite-perl \
    libnet-twitter-perl \
    libmodern-perl-perl \
    libdbd-csv-perl \
    libtext-csv-xs-perl \
    libproc-daemon-perl \
    libproc-pid-file-perl \
    libnet-smtp-ssl-perl \
    libemail-valid-perl \
    libauthen-sasl-perl \
    libdbd-sqlite3-perl \
    libmail-pop3client-perl \
    libcache-memcached-fast-perl \
    libswitch-perl

WORKDIR /usr/wikia/slot1/current/src

# install cpanm installer
RUN wget http://cpanmin.us -O cpanmin && cat cpanmin | perl - App::cpanminus

# install libs for perl backends scripts
RUN cpanm --notest common::sense \
    && cpanm --notest Cache::Memcached \
    && cpanm --configure-timeout=600 --notest Memcached::libmemcached \
    && cpanm --configure-timeout=600 --notest Cache::Memcached::libmemcached \
    && cpanm --notest Class::Accessor \
    && cpanm --notest Data::UUID \
    && cpanm --notest Data::Types \
    && cpanm --notest DateTime::Locale \
    && cpanm --notest DateTime \
    && cpanm --notest DBD::mysql \
    && cpanm --notest DBI::Profile \
    && cpanm --notest IPC::Run \
    && cpanm --notest JSON \
    && cpanm --notest MooseX::Singleton \
    && cpanm --notest Net::SNMP \
    && cpanm --notest Parallel::ForkManager \
    && cpanm --notest Sys::Proctitle \
    && cpanm --notest Try::Tiny \
    && cpanm --notest YAML::XS

ADD app /usr/wikia/slot1/current/src
ADD config /usr/wikia/slot1/current/config
ADD backend /usr/wikia/slot1/current/backend

ENV WIKIA_DATACENTER="poz"
ENV WIKIA_ENVIRONMENT="dev"

RUN mkdir -p /usr/wikia/slot1/current/cache/messages && \
    chmod 777 /usr/wikia/slot1/current/cache/messages && \
    SERVER_ID=177 php maintenance/rebuildLocalisationCache.php --threads=4

USER nobody
