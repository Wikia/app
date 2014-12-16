# Helios #

## Development ##

Follow development progress and join the discussion:

* [app](https://github.com/Wikia/app/pull/5792)
* [config](https://github.com/Wikia/config/pull/789)

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

## Technical Details ##

### Global Variables ###

 * **`$wgHeliosBaseUri`** - the base URI of the Helios service in use, e.g. `http://auth.example.com/`,
    [[go to declaration]](https://github.com/Wikia/config/blob/helios-dev/CommonSettings.php).
 * **`$wgHeliosClientId`** - the client ID, so the service recognizes the application as a legit client, e.g. `321`,
    [[go to declaration]](https://github.com/Wikia/config/blob/helios-dev/CommonSettings.php).
 * **`$wgHeliosClientSecret`** - the client secret to authorize client's requests to the service, e.g. `d6ea3de3`,
    [[go to declaration]](https://github.com/Wikia/config/blob/helios-dev/CommonSettings.php).

### Classes ###

* **`\Wikia\Helios\Client`** - a simple shared client for the Helios service.
    [[go to declaration]](https://github.com/Wikia/app/tree/helios-dev/extensions/wikia/Helios/Client.class.php).