#!/usr/bin/env bash

# Add local user
# Either use the LOCAL_USER_ID if passed in at runtime or
# fallback

USER_ID=${LOCAL_USER_ID:-9001}

echo "Starting with UID : $USER_ID"
adduser --home /usr/wikia/slot1/current/src --shell /bin/bash --disabled-login --uid $USER_ID --system docker_user
export HOME=/app

set -Eeo pipefail

php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php composer-setup.php
php -r "unlink('composer-setup.php');"

chown -R docker_user .

gosu docker_user "$@"
rm composer.phar
