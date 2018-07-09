## Building maintenance image for cron jobs
note: examples are run from /docker directory

1. build base image:
```
docker build -f base/Dockerfile -t artifactory.wikia-inc.com/sus/php-wikia-base ./base
```
2. build maintenance image:
```
docker build -f ./maintenance/Dockerfile -t artifactory.wikia-inc.com/sus/php-wikia-maintenance ../../
```
3. tag maintenance image. 1.01 should be replaced by next version tag:
```
docker tag artifactory.wikia-inc.com/sus/php-wikia-maintenance artifactory.wikia-inc.com/sus/php-wikia-maintenance:1.01
```
4. push image to artifactory
```
docker push artifactory.wikia-inc.com/sus/php-wikia-maintenance:1.01
```

## Adding new Cron Job


to apply new cron job run:

```
kubectl --context kube-sjc-prod -n prod apply -f maintenance_cron_job_example.yaml
```

More about cron job yaml format on [kubernetes cron jobs](https://kubernetes.io/docs/concepts/workloads/controllers/cron-jobs/) page
