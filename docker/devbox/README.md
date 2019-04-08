## Dockerized MW on Devboxes

### Overview

These docker containers allow us to run mediawiki on kvm devboxes. The idea is to have setup similar to production, which
means containerized mediawiki&nginx. But also to have the flexibility of "old" devboxes, where one could easily
modify the source code and just refresh the page without rebuilding any images.
General overview of the setup:
* app and config repos are stored somewhere in the kvm devbox filesystem
* docker compose is used to run nginx server and php-fpm container
* nginx binds to port 80 of the host
* `app` and `config` folders and mounted as docker volumes when containers are started

### Usage

1. Clone the app and config repos, this readme file assumes those repos are stored in you home dir root.

2. Rebuild the localization cache
	```bash
	mkdir ~/cache && chmod 0777 ~/cache
    docker run -it --rm -e "SERVER_ID=177" -e "WIKIA_DEV_DOMAIN=$WIKIA_DEV_DOMAIN" -e "WIKIA_ENVIRONMENT=$WIKIA_ENVIRONMENT" -e "WIKIA_DATACENTER=$WIKIA_DATACENTER" -e "LOG_STDOUT_ONLY=yes" -v "$HOME/app":/usr/wikia/slot1/current/src:ro -v "$HOME/config":/usr/wikia/slot1/current/config:ro -v "$HOME/cache":/usr/wikia/slot1/current/cache/messages artifactory.wikia-inc.com/platform/php-wikia-devbox:latest php maintenance/rebuildLocalisationCache.php --primary
    chmod 775 ~/cache
    ``` 
3. Starting mediawiki
Use docker compose in order to start the nginx&php. Use something like the `screen` command if you want it to keep 
running the the background.

	```bash
	cd app/docker/devbox
	docker-compose up
	```

4. Stopping mediawiki
	Usualy the best option is to stop it with Ctrl+C and then run `docker-compose down`.

### Running eval.php
```bash
docker run -it --rm -e "SERVER_ID=177" -e "WIKIA_DEV_DOMAIN=$WIKIA_DEV_DOMAIN" -e "WIKIA_ENVIRONMENT=$WIKIA_ENVIRONMENT" -e "WIKIA_DATACENTER=$WIKIA_DATACENTER" -e "LOG_STDOUT_ONLY=yes" -v "$HOME/app":/usr/wikia/slot1/current/src:ro -v "$HOME/config":/usr/wikia/slot1/current/config:ro -v "$HOME/cache":/usr/wikia/slot1/current/cache/messages artifactory.wikia-inc.com/platform/php-wikia-devbox:latest php maintenance/eval.php
```
Replace `SERVER_ID` with any other city identifier.

### Logging

Right now the logs are sent to console in JSON format. We may add Kibana logger later on.

### Opcache

For performance reasons the opcache is enabled, but it checks for file updates every 10 seconds.
So you should see your code changes shortly after uploading them to your devbox.

### Tests (in progress)

You can still start a container with MediaWiki/PHP:

```bash
$ docker run -it --rm -e "SERVER_ID=177" -e "WIKIA_DEV_DOMAIN=$WIKIA_DEV_DOMAIN" -e "WIKIA_ENVIRONMENT=$WIKIA_ENVIRONMENT" -e "WIKIA_DATACENTER=$WIKIA_DATACENTER" -e "LOG_STDOUT_ONLY=yes" -v "$HOME/app":/usr/wikia/slot1/current/src:ro -v "$HOME/config":/usr/wikia/slot1/current/config:ro -v "$HOME/cache":/usr/wikia/slot1/current/cache/messages artifactory.wikia-inc.com/platform/php-wikia-devbox:latest bash
```

Then you can run a single test:
```bash
nobody@2d25d207a7a7:/usr/wikia/slot1/current/src$ cd tests
nobody@2d25d207a7a7:/usr/wikia/slot1/current/src/tests$ SERVER_DBNAME=firefly php run-test.php ../includes/wikia/tests/WikiaForceBaseDomainTest.php
PHPUnit 6.5.8 by Sebastian Bergmann and contributors.

.........                                                           9 / 9 (100%)

Time: 328 ms, Memory: 16.00MB
```

Or run the whole test suite:
```bash
nobody@2d25d207a7a7:/usr/wikia/slot1/current/src$ cd tests
nobody@2d25d207a7a7:/usr/wikia/slot1/current/src/tests$ SERVER_DBNAME=firefly php run-test.php --stderr --configuration=phpunit.xml --exclude-group Infrastructure,Integration,ExternalIntegration,ContractualResponsibilitiesValidation
nobody@2d25d207a7a7:/usr/wikia/slot1/current/src/tests$ SERVER_DBNAME=firefly php run-test.php --stderr --configuration=phpunit.xml --group Integration
```

### Rebuilding docker images

nginx image:
```bash
docker build -f Dockerfile-nginx -t artifactory.wikia-inc.com/platform/nginx-wikia-devbox:latest .
 ```
 
php-fpm image:
 ```
docker build -t artifactory.wikia-inc.com/platform/php-wikia-devbox:latest .
 ```
