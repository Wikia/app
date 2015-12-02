The pico-framework that handles performance A/B testing.

[PLATFORM-1246](https://wikia-inc.atlassian.net/browse/PLATFORM-1246)

### Criteria

Performance experiments can be enabled based on the following criteria:

*  `wikis`: enable on a fraction of wikis (each bucket is 0.1% of all wikis - uses `$wgCityId`)
* `traffic`: enable site-wide on a fraction of traffic (each bucket is 0.1% of all clients - uses `beacon_id`)
* `oasisArticles`: if provided with the value of `true` will cause the experiment to be run on Oasis content namespace articles only

**Only up to one experiment can be run for the same request**. The first match will be used. The name of the selected experiment will be reported to Universal Analytics (via custom variable) and to InfluxDB (via Transaction parameter - for both backend and frontend related metrics).

```js
wgTransactionContext.perf_test
"backend_delay_a"
```

### Experiments config

All performance experiments are defined in `$wgAbPerformanceTestingExperiments` global array with a single entry as follows:

```php
$wgAbPerformanceTestingExperiments['backend_delay_b'] = [
	'handler' => 'Wikia\\AbPerformanceTesting\\Experiments\\BackendDelay',
	'params' => [
		'delay' => 50,
	],
	'criteria' => [
		'oasisArticles' => true,
		'traffic' => 1,
	]
];
```

* `handler` is a class name that will be instantiated when the experiment criteria are matched (`params` array will be passed as constructor arguments).
* `criteria`: criteria to be met

### Experiments implemented

* `BackendDelay` - add a small delay at the end of the request.
* `FrontendDelay` - add a small delay before onDOMReady events is handled by jQuery

### Traffic handling

In order to start the A/B testing experiment a client (either an anon or logged-in) needs to hit the backend. In such case the criteria are checked, matching experiment is started and **the PHP session is initialized**.
Starting the session allows to us to bypass CDN caching for subsequent requests from the client that has the experiment enabled.

### Experiments tracking

Requests with performance experiments enabled are tracked using:

* **Universal Analytics** via `dimension20` custom variable
* **xhprof** via `perf_test` transaction parameter
