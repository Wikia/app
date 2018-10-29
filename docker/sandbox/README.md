## Deploy app and config code to Kubernetes sandbox instance

Use Jenkins Pipeline. Read more on https://wikia-inc.atlassian.net/wiki/spaces/SUS/pages/378994735/Jenkins+Pipeline+-+deploy+mediawiki+to+sandbox


## Sandbox shell access

Use `sandbox_shell.sh` helper script:

```
$ ./sandbox_shell.sh sandbox-sus2
```

## Logs

Search for `appname:"mediawiki" AND kubernetes.labels.app: "mediawiki-sandbox-XXX"` in `logstash-mediawiki-*` index.

## Naming

Sandboxes deployed to k8s have `-k8s` suffix applied automatically if needed.
- if you name your sandbox `sandbox-s1`, then it should be used as `sandbox-s1-k8s` in URLs
- if you name your sandbox `sandbox-s2-k8s` additional suffix won't be added, use it as `sandbox-s2-k8s`
