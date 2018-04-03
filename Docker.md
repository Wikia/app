Docker
======

This file describes how to run Wikia's MediaWiki app using Docker container.

## Install

```sh
# 1. build a container using Dockerfile from this repository
docker build -t wikia-mw-app .

# 2. you can now run eval.php
docker run -it --rm -h localhost -e 'SERVER_ID=177' -e 'WIKIA_DATACENTER=poz' -e 'WIKIA_ENVIRONMENT=dev' -v "$PWD":/usr/wikia/slot1/current/src -v "`realpath $PWD/../config`":/usr/wikia/slot1/current/config wikia-mw-app php maintenance/eval.php
```
