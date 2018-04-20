Kubernetes configuration
===

Pushing configuration to k8s:

```
docker run -it --rm -v $(pwd)/poz-dev.yaml:/poz-dev.yaml artifactory.wikia-inc.com/ops/k8s-deployer:0.0.12 kubectl --context kube-poz-dev -n dev apply -f /poz-dev.yaml
```

