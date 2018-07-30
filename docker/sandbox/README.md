## Deploy app and config code to Kubernetes sandbox instance

Use Jenkins Pipeline. Read more on https://wikia-inc.atlassian.net/wiki/spaces/SUS/pages/378994735/Jenkins+Pipeline+-+deploy+mediawiki+to+sandbox


## Console access to Kubernetes container

```sh
$ kubectl --context kube-sjc-prod -n prod get pods | grep mediawiki-sandbox
```

```sh
$ kubectl --context kube-sjc-prod -n prod exec --container php -it mediawiki-sandbox-xxxxxx-xxxxx bash
nobody@mediawiki-sandbox-xxxxxx-xxxxx:/usr/wikia/slot1/current/src$
```
