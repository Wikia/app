Maintenance
===========

This directory contains definition of all maintenance scripts that should be run periodically.
Before the migration to Kubernetes these were run via `crontab` on `cron-s1`.

### Generating YAML files

To generate YAML for one cron job:

```sh
./create-cronjob-yaml.sh one-time-job-example.yaml
```

In YAML describing a cron job there are two required fields: schedule and args
Optionally you can pass server_id
Name of cronjob is derived from a file name with a 'mediawiki-' prefix

e.g.
```yaml
schedule: "35 20 * * *" # required
server_id: 3434 # optional, default: 177
args: # required
- php
- path/to/maintenance.php
- --param=1

```

To generate YAML for ALL cron jobs (except ones that start with 'example'):

```sh
./cronjobs-generator.sh
```


### Applying YAML files

> [Set up `kubectl`](https://wikia-inc.atlassian.net/wiki/spaces/OPS/pages/208011308/Kubernetes+access+for+Engineers)

In order to apply descriptor you need to map directory with YAML files to kubectl container.

Like so:

```sh
docker run -v ~/app/docker/maintenance:/maintenance -it artifactory.wikia-inc.com/ops/k8s-deployer:0.0.12 ./maintenance/create-cronjob-yaml.sh one-time-job-example.yaml | kubectl --context kube-sjc-prod -n prod apply -f -
```

Or when running `kubectl` as a binary (run from app directory root):

```sh
./maintenance/create-cronjob-yaml.sh one-time-job-example.yaml | kubectl --context kube-sjc-prod -n prod apply -f -
```

To apply all jobs defined run
```sh
./maintenance/cronjobs-generator.sh | kubectl --context kube-sjc-prod -n prod apply -f -
```

### Current list of cronjobs

To check what cronjobs are currently scheduled:

```sh
kubectl --context kube-sjc-prod -n prod get jobs
```
