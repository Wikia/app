## Dockerized MW on Devboxes

### Overview

These docker containers allow us to run mediawiki on kvm devboxes. The idea is to have setup similar to production, which
means containerized mediawiki&nginx. But also to have the flexibility of "old" devboxes, where one could easily
modify the source code and just refresh the page without rebuilding any images.
General overview of the setup:
* app and config repos are stored somewhere in the kvm devbox filesystem
* docker compose is used to run nginx server, php-fpm and fluentd containers
* nginx binds to port 80 of the host
* `app` and `config` folders and mounted as docker volumes when containers are started

Since we are pushing all the logs from the nginx and mediawiki to elastic search all of them have to pass through fluentd.
This means that whenever your fluentd is misconfigured or dead you'll see no logs in kibana and/or stdout.

Additionally to pass nginx logs to fluentd we are using shared volume that is mounted on your host (see: [docker-compose.yml](docker-compose.yml)).
You can safely purge this folder to reclaim the disk space if needed.
 
### Usage

1. Clone the app and config repos, this readme file assumes those repos are stored in you home dir root.

2. Rebuild the localization cache
	```bash
	mkdir ~/cache && chmod 0777 ~/cache
    docker run -it --rm -e "SERVER_ID=177" -e "WIKIA_DEV_DOMAIN=$WIKIA_DEV_DOMAIN" -e "WIKIA_ENVIRONMENT=$WIKIA_ENVIRONMENT" -e "WIKIA_DATACENTER=$WIKIA_DATACENTER" -e "LOG_STDOUT_ONLY=yes" -v "$HOME/app":/usr/wikia/slot1/current/src:ro -v "$HOME/config":/usr/wikia/slot1/current/config:ro -v "$HOME/cache":/usr/wikia/slot1/current/cache/messages artifactory.wikia-inc.com/platform/php-wikia-devbox:latest php maintenance/rebuildLocalisationCache.php --primary
    chmod 775 ~/cache
    ``` 
4. Setup environment variables
	```bash
		echo "HOSTNAME_OVERRIDE=`hostname`" >> .env
	```
4. Starting mediawiki
Use docker compose in order to start the nginx&php. Use something like the `screen` command if you want it to keep 
running the the background.

	```bash
	cd app/docker/devbox
	docker-compose up
	```

5. Stopping mediawiki
	Usually the best option is to stop it with Ctrl+C and then run `docker-compose down`.

### Running eval.php
```bash
docker run -it --rm -e "SERVER_ID=177" -e "WIKIA_DEV_DOMAIN=$WIKIA_DEV_DOMAIN" -e "WIKIA_ENVIRONMENT=$WIKIA_ENVIRONMENT" -e "WIKIA_DATACENTER=$WIKIA_DATACENTER" -e "LOG_STDOUT_ONLY=yes" -e "HOSTNAME_OVERRID=`hostname`" -v "$HOME/app":/usr/wikia/slot1/current/src:ro -v "$HOME/config":/usr/wikia/slot1/current/config:ro -v "$HOME/cache":/usr/wikia/slot1/current/cache/messages artifactory.wikia-inc.com/platform/php-wikia-devbox:latest php maintenance/eval.php
```
Replace `SERVER_ID` with any other city identifier.

### Opcache

For performance reasons the opcache is enabled, but it checks for file updates every 10 seconds.
So you should see your code changes shortly after uploading them to your devbox.

### Tests

Our tests rely on the uopz extension when mocking static methods and constructors. Unfortunately uopz is not compatible
with xdebug (https://github.com/krakjoe/uopz/issues/110). That's why a dedicated docker images has to be used:

```bash
$ docker run -it --rm -e "SERVER_ID=177" -e "WIKIA_DEV_DOMAIN=$WIKIA_DEV_DOMAIN" -e "WIKIA_ENVIRONMENT=$WIKIA_ENVIRONMENT" -e "WIKIA_DATACENTER=$WIKIA_DATACENTER" -e "LOG_STDOUT_ONLY=yes" -e "HOSTNAME_OVERRID=`hostname`" -v "$HOME/app":/usr/wikia/slot1/current/src:ro -v "$HOME/config":/usr/wikia/slot1/current/config:ro -v "$HOME/cache":/usr/wikia/slot1/current/cache/messages artifactory.wikia-inc.com/platform/php-wikia-tests:latest bash
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
### Xdebug

The Xdebug extension is enabled and configured to connect to port 9000 of the docker host. In order to use xdebug follow
this article: https://wikia-inc.atlassian.net/wiki/spaces/EN/pages/35723807/Debugging+with+Xdebug+and+Charles. 

In a nutshell:
1. Forward port 9000 to your laptop by running this command in the terminal:
    ```sh
    ssh -o ServerAliveInterval=20 -R 9000:localhost:9000 dev-<devboxname>-18
    ```
2. When mapping the paths is PhpStorm, please keep in mind that use should use `/usr/wikia/slot1/current/` as the remote 
path instead of the path on your devbox. That is the path that sources are mounted at in the docker
container.
3. Enable the `Listen for debug connections` button in PhpStorm
4. Add `XDEBUG_SESSION_START=1` query parameter to the request

### Rebuilding docker images

nginx image:
```bash
docker build -f Dockerfile-nginx -t artifactory.wikia-inc.com/platform/nginx-wikia-devbox:latest .
 ```
 
php-fpm image:
 ```bash
docker build -t artifactory.wikia-inc.com/platform/php-wikia-devbox:latest .
 ```

php-tests images:
 ```bash
docker build -f Dockerfile-tests -t artifactory.wikia-inc.com/platform/php-wikia-tests:latest .
 ```
