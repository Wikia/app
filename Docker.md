Docker
======

This file describes how to run Wikia's MediaWiki app using Docker container.

## How to run Wikia app Docker container

We assume that you have `app` and `config` repository cloned in the same directory and that you have an empty `cache` directory at the same level (it will be used to store localisation cache).

```sh
# 1. build a container using Dockerfile from this repository
docker build -t php-wikia-base .

# 2. you can now run eval.php
docker run -it --rm --dns 10.14.30.130 -h localhost -e 'SERVER_ID=165' -e 'WIKIA_DATACENTER=poz' -e 'WIKIA_ENVIRONMENT=dev' -v "$PWD":/usr/wikia/slot1/current/src -v "$PWD/../config":/usr/wikia/slot1/current/config -v "$PWD/../cache":/usr/wikia/slot1/current/cache/messages php-wikia-base php maintenance/eval.php
```

## How to push base image to Wikia's repository

```sh
docker tag php-wikia-base php-wikia-base:7.0.28

docker tag php-wikia-base artifactory.wikia-inc.com/sus/php-wikia-base
docker tag php-wikia-base artifactory.wikia-inc.com/sus/php-wikia-base:7.0.28

docker push artifactory.wikia-inc.com/sus/php-wikia-base
docker push artifactory.wikia-inc.com/sus/php-wikia-base:7.0.28
```

## How to set up Docker on your machine

> https://docs.docker.com/install/

#### Troubleshooting

If docker service fails to start run the following to diagnose the problem:

```sh
sudo dockerd
```
