<?php

class PerformanceMetrics extends WikiaObject {

	public function __construct() {
		parent::__construct();
	}

	/**
	 * Returns instances of all available metrics providers
	 *
	 * @return mixed array of PerformanceMetricsProvider instances
	 */
	public function getAllProviders() {
		$providers =$this->wg->PerformanceMetricsProviders;
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
	 * @return mixed report
	 */
	public function getReport($url) {
		$providers = $this->getAllProviders();
		$metrics = array();

		foreach($providers as $provider) {
			$report = $provider->getReport($url);

			if (!empty($report)) {
				$metrics = array_merge_recursive($metrics, $report);
			}
		}

		return $metrics;
	}
}
