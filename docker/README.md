Docker
======

This file describes how to run Wikia's MediaWiki app using Docker container.

## How to run Wikia app Docker container

We assume that you have `app` and `config` repository cloned in the same directory and that you have an empty `cache` directory at the same level (it will be used to store localisation cache).

```sh
# 1. build a base image
docker build -f base/Dockerfile -t php-wikia-base .

# 2. and then dev image
docker build -f dev/Dockerfile -t php-wikia-dev dev

# 3. you can now run eval.php (execute this from root directory of app repo clone)
docker run -it --rm -h localhost -e 'SERVER_ID=165' -e 'WIKIA_DATACENTER=poz' -v "$PWD":/usr/wikia/slot1/current/src -v "$PWD/../config":/usr/wikia/slot1/current/config -v "$PWD/../cache":/usr/wikia/slot1/current/cache/messages artifactory.wikia-inc.com/sus/php-wikia-dev php maintenance/eval.php
```

## How to push base and dev images to Wikia's repository

```sh
docker tag php-wikia-base php-wikia-base:7.0.28

docker tag php-wikia-base artifactory.wikia-inc.com/sus/php-wikia-base
docker tag php-wikia-base artifactory.wikia-inc.com/sus/php-wikia-base:7.0.28

docker push artifactory.wikia-inc.com/sus/php-wikia-base
docker push artifactory.wikia-inc.com/sus/php-wikia-base:7.0.28


docker tag php-wikia-dev php-wikia-dev:7.0.28

docker tag php-wikia-dev artifactory.wikia-inc.com/sus/php-wikia-dev
docker tag php-wikia-dev artifactory.wikia-inc.com/sus/php-wikia-dev:7.0.28

docker push artifactory.wikia-inc.com/sus/php-wikia-dev
docker push artifactory.wikia-inc.com/sus/php-wikia-dev:7.0.28
```

## How to set up Docker on your machine

> https://docs.docker.com/install/

#### Troubleshooting

If docker service fails to start run the following to diagnose the problem:

```sh
sudo dockerd
```
