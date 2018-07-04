## Deploy app and config code to Kubernetes sandbox instance

Use Jenkins Pipeline. Read more on https://wikia-inc.atlassian.net/wiki/spaces/SUS/pages/378994735/Jenkins+Pipeline+-+deploy+mediawiki+to+sandbox

## Building images for Kubernetes sandbox instance

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

## Console access to Kubernetes container

```
$ kubectl --context kube-sjc-prod -n prod get pods | grep mediawiki-sandbox
mediawiki-sandbox-c7dff75b9-25xvb                          3/3       Running            0          12m
mediawiki-sandbox-c7dff75b9-58ztx                          3/3       Running            0          12m
mediawiki-sandbox-c7dff75b9-fzx68                          3/3       Running            0          12m
mediawiki-sandbox-c7dff75b9-jrb9q                          3/3       Running            0          12m
mediawiki-sandbox-c7dff75b9-khdbw                          3/3       Running            0          12m
```

```
$ kubectl --context kube-sjc-prod -n prod exec --container php -it mediawiki-sandbox-c7dff75b9-25xvb bash
nobody@mediawiki-sandbox-c7dff75b9-25xvb:/usr/wikia/slot1/current/src$
```
