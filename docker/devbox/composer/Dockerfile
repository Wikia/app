#We want to use the same base as the application image in order to make dependencies consistent across them
FROM artifactory.wikia-inc.com/sus/php-wikia-base:da4390f

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php \
    && php -r "unlink('composer-setup.php');" \
    && apt-get update \
    && apt-get install -y git zip unzip\
    && pecl install yaml-2.0.2 xdebug-2.6.0 \
    && docker-php-ext-enable yaml xdebug

ADD . /usr/wikia/slot1/current/src

CMD ["php composer.phar"]
