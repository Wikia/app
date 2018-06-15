### Building images for Kubernetes sandbox instance

Go to app's repository root directory:

```
docker build . -f docker/sandbox/Dockerfile-nginx -t artifactory.wikia-inc.com/sus/mediawiki-sandbox-nginx:latest
docker build .. -f docker/sandbox/Dockerfile-php -t artifactory.wikia-inc.com/sus/mediawiki-sandbox-php:latest
```

Push updated images to Artifactory:

```
docker push artifactory.wikia-inc.com/sus/mediawiki-sandbox-nginx:latest
docker push artifactory.wikia-inc.com/sus/mediawiki-sandbox-php:latest
```

Push to Kubernetes:

```
kubectl --context kube-sjc-prod -n prod apply -f sandbox-sus2.yaml
```
