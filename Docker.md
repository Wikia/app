Docker
======

This file describes how to run Wikia's MediaWiki app using Docker container.

## How to run Wikia app Docker container

We assume that you have `app` and `config` repository cloned in the same directory and that you have an empty `cache` directory at the same level (it will be used to store localisation cache).

```sh
# 1. build a container using Dockerfile from this repository
docker build -t php-wikia-base .

# 2. you can now run eval.php
docker run -it --rm --dns 10.14.30.130 -h localhost -e 'SERVER_ID=165' -e 'WIKIA_DATACENTER=poz' -e 'WIKIA_ENVIRONMENT=dev' -v "$PWD":/usr/wikia/slot1/current/src -v "`realpath $PWD/../config`":/usr/wikia/slot1/current/config -v "`realpath $PWD/../cache`":/usr/wikia/slot1/current/cache/messages php-wikia-base php maintenance/eval.php
```

## How to set up Docker on your devbox

```sh
# Uninstall old versions
sudo apt-get remove docker docker-engine docker.io

wget -qO- https://get.docker.com/ | sh

# be able to run docker as non-root user
sudo usermod -aG docker ${LOGNAME}

# verify the steps above
docker -v
```

#### Troubleshooting

If docker service fails to start run the following to diagnose the problem:

```sh
sudo dockerd
```
