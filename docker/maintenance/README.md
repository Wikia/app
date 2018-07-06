In order to apply descriptor you need to map directory with yaml files to kubectl container.

Like so:
`docker run -v /Users/jakubjastrzebski/Projects/devbox/app/docker/maintenance:/maintenance -it artifactory.wikia-inc.com/ops/k8s-deployer:0.0.12 kubectl --context kube-sjc-prod -n prod create -f maintenance/one-time-job-example.yaml`

To check what cronjobs are currently scheduled: `kubectl --context kube-sjc-prod -n prod get jobs`