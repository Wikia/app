# Helios #

## Branching ##

The `helios-dev` branch is considered to be the main branch where the source code of `HEAD` always reflects a *stable*
state. The `dev` branch is an upstream branch.

* [app](https://github.com/Wikia/app/tree/helios-dev)
* [config](https://github.com/Wikia/config/tree/helios-dev)

## Deployment to Sandbox ##

To deploy the latest stable version of Helios to `sandbox-s4` run the following commands on `deploy-s3`:

```
dt prep --env sandbox-s4 --app wikia --repo app@helios-dev --repo config@helios-dev
dt push --env sandbox-s4 --app wikia
```

## Contact ##

* Artur Klajnerok <[artur.klajnerok@wikia-inc.com](mailto:artur.klajnerok@wikia-inc.com)>
* Michał Roszka <[michal@wikia-inc.com](mailto:michal@wikia-inc.com)>