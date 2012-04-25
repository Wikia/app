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
			$instances[] = F::build($providerName);
		}

		return $instances;
	}

	/**
	 * Returns aggregated metrics from all available metrics providers
	 *
	 * @param string $url page URL
	 * @param array $options additional parameters, can contains:
	 * 							$providers arrau list of providers to get data from (defaults to all providers)
	 * 							$loggedIn boolean should the metrics be aggregated for loggged-in version of the site
	 * @return mixed report
	 */
	public function getReport($url, Array $options = array()) {
		$instances = $this->getProviders( !empty($options['providers']) ? $options['providers'] : $this->wg->PerformanceMetricsProviders );
		$metrics = array();

		foreach($instances as $provider) {
			$report = $provider->getReport($url, $options);

			if (!empty($report)) {
				$metrics = array_merge_recursive($metrics, $report);
			}
		}

		if (is_array($metrics['url'])) {
			$metrics['url'] = reset($metrics['url']);
		}
		return $metrics;
	}
}
