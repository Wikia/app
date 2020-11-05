## How to run Wikia app Docker container

We assume that you have `app` and `config` repository cloned in the same directory and that you have an empty `cache` directory at the same level (it will be used to store localisation cache).

```sh
# 1. build a base image
docker build -f base/Dockerfile -t artifactory.wikia-inc.com/sus/php-wikia-base:0b02db1c1f7 ./base
docker push artifactory.wikia-inc.com/sus/php-wikia-base:0b02db1c1f7

# 2. and then dev image
docker build -f dev/Dockerfile -t php-wikia-dev ./dev
docker build -f dev/Dockerfile-nginx -t nginx-wikia-dev ./dev

# 3. you can now run eval.php (execute this from root directory of app repo clone)
docker run -it --rm -h localhost -e 'SERVER_ID=165' -e 'WIKIA_ENVIRONMENT=dev' -e 'WIKIA_DATACENTER=poz' -v "$PWD":/usr/wikia/slot1/current/src -v "$PWD/../config":/usr/wikia/slot1/current/config -v "$PWD/../cache":/usr/wikia/slot1/current/cache/messages artifactory.wikia-inc.com/sus/php-wikia-dev php maintenance/eval.php

# 4. in order to run service locally use docker-compose
docker-compose -f ./dev/docker-compose.yml up

# 5. then you can use `docker exec` to take a look inside the container
docker exec -it dev_php-wikia_1 bash
```

### Resolving domains

In order to run service locally you need to configure hosts. Add below line to `/etc/hosts`

```
127.0.0.1	wikia-local.com dev.wikia-local.com muppet.dev.wikia-local.com
```

## Deploy Pipeline (deprecated)

This section describe how to deploy mediawiki to various environments, how they work and how to introduce changes to it.

There are 2 main parts of all deployments:
1. Jenkins job that is defined in jenkins-jobs repository that accepts needed parameters to deploy to a given environment
2. a jenkins file that is in this repo that is being executed by Jenkins as a pipeline job

### How to deploy to sandbox (deprecated)

1. Open [mediawiki-deploy-sandbox](http://jenkins.wikia-prod:8080/blue/organizations/jenkins/mediawiki-deploy-sandbox/activity)
2. Press run button, fill in the form and submit the form
3. Profit!

#### Backstage
- jenkins file: https://github.com/Wikia/app/blob/dev/docker/sandbox/Jenkinsfile


### How to deploy to preview

This job is ran by [daily-release-cut](http://jenkins.wikia-prod:8080/blue/organizations/jenkins/daily-release-cut/activity) but if you need to deploy manually:

1. Open [mediawiki-deploy-preview](http://jenkins.wikia-prod:8080/blue/organizations/jenkins/mediawiki-deploy-preview/activity)
2. Press run button, fill in the form
	1. new release - will create new release branch, new release tag and push that to preview
	2. hotfix - will checkout a release branch that is currently on preview and if there are any changes on this branch against the tag that is deployed - it will create new tag and push that to preview
	3. latest - fetch a latest tag that is on github and push that to preview
3. Submit the form
4. This job will wait for your input on stage 'Fetch version' - if you won't press Proceed it will be aborted

Please keep in mind that preview deployment will automatically start all functional tests.

### how to deploy to prod
1. Open [mediawiki-deploy-prod](http://jenkins.wikia-prod:8080/blue/organizations/jenkins/mediawiki-deploy-prod/activity)
2. Press run button, fill in the form
	1. preview - fetch a version from preview environment and push the same to prod
	2. hotfix - will checkout a release branch that is currently on prod and if there are any changes on this branch against the tag that is deployed - it will create new tag and push that to prod

### Where are the jobs configured
All 3 jobs are defined in [jenkins-jobs](https://github.com/Wikia/jenkins-jobs) repo in this file [mediawiki-deployment-pipeline](https://github.com/Wikia/jenkins-jobs/blob/master/jobs/mediawiki/mediawiki-deployment-pipeline.yaml)

The jenkins files are taken from dev branch, so if you want to introduce changes to the deployment pipeline make sure they are merged to dev branch.

### how to introduce changes to the deploy pipeline

1. Create a branch in app repository and change a Jenkinsfile
2. Create a branch in [jenkins-jobs](https://github.com/Wikia/jenkins-jobs) and change
	1. name of the job - so you can push it to jenkins for testing purposes
	2. branch from where the Jenkinsfile is fetched to the branch when your changes are
3. Push the job to jenkins for tesing purposes
4. If all is functioning properly - merge branch in app repository
5. In jenkins-jobs repo - change back the name of a job, branch to dev and merge it

### FAQ
#### Are docker images rebuilt always? On every deployment?
No, docker images have app and config commit hashes in an image name. So if you push the same app and config combo - docker image won't be rebuilt.


## How to set up Docker on your machine

> https://docs.docker.com/install/

## Troubleshooting

### Permissions

To run unit tests set up the `app/tests/build` directory to be owned by `nobody:nogroup`.

To rebuild localisation cache you need to have `cache` directory created at the same level as `app` and `config` git clones.
`cache` directory should have `777` rights set up and have an empty file touched there.

### Localisation cache

If localisation cache is missing, regenerate it by running `SERVER_ID=177 php maintenance/rebuildLocalisationCache.php` within the container

### DNS issues

If you have problems with DNS host names resolution in your Docker container, you need to [disable `dnsmasq` on your machine](https://askubuntu.com/questions/320921/having-dns-issues-when-connected-to-a-vpn-in-ubuntu-13-04).

### Docker service fails

If docker service fails to start run the following to diagnose the problem:

```sh
sudo dockerd
```

#### Setting up `kubectl`

Follow [these instructions](https://wikia-inc.atlassian.net/wiki/spaces/OPS/pages/401440847/Kubernetes+access+for+Engineers).
