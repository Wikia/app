Docker
======

This file describes how to run Wikia's MediaWiki app using Docker container.

## How to run Wikia app Docker container

We assume that you have `app` and `config` repository cloned in the same directory and that you have an empty `cache` directory at the same level (it will be used to store localisation cache).

```sh
# 1. build a base image
docker build -f base/Dockerfile -t artifactory.wikia-inc.com/sus/php-wikia-base:da4390f ./base
docker push artifactory.wikia-inc.com/sus/php-wikia-base:da4390f

# 2. and then dev image
docker build -f dev/Dockerfile -t php-wikia-dev ./dev

# 3. you can now run eval.php (execute this from root directory of app repo clone)
docker run -it --rm -h localhost -e 'SERVER_ID=165' -e 'WIKIA_ENVIRONMENT=dev' -e 'WIKIA_DATACENTER=poz' -v "$PWD":/usr/wikia/slot1/current/src -v "$PWD/../config":/usr/wikia/slot1/current/config -v "$PWD/../cache":/usr/wikia/slot1/current/cache/messages artifactory.wikia-inc.com/sus/php-wikia-dev php maintenance/eval.php

# 4. in order to run service locally use docker-compose
docker-compose -f ./dev/docker-compose.yml up

# 5. then you can use `docker exec` to take a look inside the container
docker exec -it dev_php-wikia_1 bash
```

### Resolving domains

In order to run service locally you need to configure hosts. Add below line to `/etc/hosts`

```
127.0.0.1	wikia-local.com dev.wikia-local.com muppet.dev.wikia-local.com
```


## How to set up Docker on your machine

> https://docs.docker.com/install/

## Troubleshooting

### Permissions

To run unit tests set up the `app/tests/build` directory to be owned by `nobody:nogroup`.

To rebuild localisation cache you need to have `cache` directory created at the same level as `app` and `config` git clones.
`cache` directory should have `777` rights set up and have an empty file touched there.

### Localisation cache

If localisation cache is missing, regenerate it by running `SERVER_ID=177 php maintenance/rebuildLocalisationCache.php` within the container

### DNS issues

If you have problems with DNS host names resolution in your Docker container, you need to [disable `dnsmasq` on your machine](https://askubuntu.com/questions/320921/having-dns-issues-when-connected-to-a-vpn-in-ubuntu-13-04).

### Docker service fails

If docker service fails to start run the following to diagnose the problem:

```sh
sudo dockerd
```

#### Setting up `kubectl`

Follow [these instructions](https://wikia-inc.atlassian.net/wiki/spaces/OPS/pages/401440847/Kubernetes+access+for+Engineers).
