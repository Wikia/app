<?php

class PerformanceMetrics extends WikiaObject {

	public function __construct() {
		parent::__construct();
	}

	/**
	 * Returns instances of given metrics providers
	 *
	 * @param array $providers list of providers to get instance of
	 * @return mixed array of PerformanceMetricsProvider instances
	 */
	public function getProviders(Array $providers) {
		$instances = array();

		foreach($providers as $providerName) {
			$instances[] = new $providerName;
		}

		return $instances;
	}

	/**
	 * Returns aggregated metrics from all available metrics providers
	 *
	 * @param string $url page URL
	 * @param array $options additional parameters, can contains:
	 * 							$noexternals boolean only load Wikia code
	 * 							$mobile boolean check wikiamobile skin
	 * 							$providers array list of providers to get data from (defaults to all providers)
	 * 							$loggedIn boolean should the metrics be aggregated for loggged-in version of the site
	 * @return mixed report
	 */
	public function getReport($url, Array $options = array()) {
		$providers = !empty($options['providers']) ? $options['providers'] : $this->wg->PerformanceMetricsProviders;
		$instances = $this->getProviders($providers);
		$metrics = array();

		// apply options
		if ($options['noexternals']) {
			$url .= (strpos($url, '?') !== false ? '&' : '?') . 'noexternals=1';
		}
		if ($options['mobile']) {
			$url .= (strpos($url, '?') !== false ? '&' : '?') . 'useskin=wikiamobile';
		}

		// run each provider
		foreach($instances as $provider) {
			$report = $provider->getReport($url, $options);

			if (!empty($report)) {
				$metrics = array_merge_recursive($metrics, $report);
			}
		}

		// each provider emits "url" entry, use only one of them
		if (is_array($metrics['url'])) {
			$metrics['url'] = reset($metrics['url']);
		}
		return $metrics;
	}
}
