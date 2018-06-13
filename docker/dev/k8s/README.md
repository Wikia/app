Kubernetes configuration
========================

[Set up `kubectl` tool](https://wikia-inc.atlassian.net/wiki/spaces/OPS/pages/208011308/Kubernetes+access+for+Engineers)

Pushing configuration to k8s:

```
kubectl --context kube-poz-dev -n dev apply -f poz-dev.yaml
kubectl --context kube-sjc-dev -n dev apply -f sjc-dev.yaml
```
