Maintenance
===========

This directory contains definition of all maintenance scripts that should be run periodically.
Before the migration to Kubernetes these were run via `crontab` on `cron-s1`.

### Applying YAML files

> [Set up `kubectl`](https://wikia-inc.atlassian.net/wiki/spaces/OPS/pages/208011308/Kubernetes+access+for+Engineers)

In order to apply descriptor you need to map directory with YAML files to kubectl container.

Like so:

```
docker run -v ~/app/docker/maintenance:/maintenance -it artifactory.wikia-inc.com/ops/k8s-deployer:0.0.12 kubectl --context kube-sjc-prod -n prod create -f maintenance/one-time-job-example.yaml
```

Or when running `kubectl` as a binary (run from app directory root):

```
kubectl --context kube-sjc-prod -n prod create -f maintenance/one-time-job-example.yaml
```

### Current list of cronjobs

To check what cronjobs are currently scheduled:

```
kubectl --context kube-sjc-prod -n prod get jobs
```
