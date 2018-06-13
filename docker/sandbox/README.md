### Building images for Kubernetes sandbox instance

Go to app's repository root directory:

```
docker build . -f docker/sandbox/Dockerfile-nginx -t artifactory.wikia-inc.com/sus/mediawiki-sandbox-nginx:latest
docker build .. -f docker/sandbox/Dockerfile-php -t artifactory.wikia-inc.com/sus/mediawiki-sandbox-php:latest
```

```
docker push artifactory.wikia-inc.com/sus/mediawiki-sandbox-nginx:latest
docker push artifactory.wikia-inc.com/sus/mediawiki-sandbox-php:latest
```