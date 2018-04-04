Docker
======

This file describes how to run Wikia's MediaWiki app using Docker container.

## Install

```sh
# 1. build a container using Dockerfile from this repository
docker build -t php-wikia-base .

# 2. you can now run eval.php
docker run -it --rm --dns 10.14.30.130 -h localhost -e 'SERVER_ID=165' -e 'WIKIA_DATACENTER=poz' -e 'WIKIA_ENVIRONMENT=dev' -v "$PWD":/usr/wikia/slot1/current/src -v "`realpath $PWD/../config`":/usr/wikia/slot1/current/config php-wikia-base php maintenance/eval.php
```
