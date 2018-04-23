Kubernetes configuration
===

Pushing configuration to k8s:

```
docker run -it --rm -v $(pwd)/poz-dev.yaml:/poz-dev.yaml artifactory.wikia-inc.com/ops/k8s-kubectl --context kube-poz-dev -n dev apply -f /poz-dev.yaml
docker run -it --rm -v $(pwd)/sjc-dev.yaml:/sjc-dev.yaml artifactory.wikia-inc.com/ops/k8s-kubectl --context kube-sjc-dev -n dev apply -f /sjc-dev.yaml
```

