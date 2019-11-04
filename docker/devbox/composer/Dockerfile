#We want to use the same base as the application image in order to make dependencies consistent across them
FROM artifactory.wikia-inc.com/sus/php-wikia-base:0b02db1c1f7

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php \
    && php -r "unlink('composer-setup.php');" \
    && mv composer.phar /usr/bin/composer \
    && chmod +x /usr/bin/composer \
    && apt-get update \
    && apt-get install -y git zip unzip\
    && pecl install yaml-2.0.4 xdebug-2.7.2 \
    && docker-php-ext-enable yaml xdebug \
    && apt-get install gosu

VOLUME /usr/wikia/slot1/current/src
VOLUME /usr/wikia/slot1/current/config

ENTRYPOINT ["docker/devbox/composer/wrapper.sh"]
CMD ["composer"]
