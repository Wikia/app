Kubernetes configuration
========================

[Set up `kubectl` tool](https://wikia-inc.atlassian.net/wiki/spaces/OPS/pages/208011308/Kubernetes+access+for+Engineers)

Pushing configuration to k8s:

```
kubectl --context kube-poz-dev -n dev apply -f poz-dev.yaml
kubectl --context kube-sjc-dev -n dev apply -f sjc-dev.yaml
```

### Building images for Kubernetes dev instances

Go to app's repository root directory:

```
docker build . -f docker/dev/k8s/Dockerfile-nginx -t artifactory.wikia-inc.com/sus/mediawiki-dev-nginx:latest
docker build .. -f docker/dev/k8s/Dockerfile-php -t artifactory.wikia-inc.com/sus/mediawiki-dev-php:latest
```

```
docker push artifactory.wikia-inc.com/sus/mediawiki-dev-nginx:latest
docker push artifactory.wikia-inc.com/sus/mediawiki-dev-php:latest
```