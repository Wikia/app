<?php

abstract class PerformanceMetricsProvider extends WikiaObject {

	public function __construct() {
		parent::__construct();
	}

	/**
	 * Returns metrics report from a given provider
	 *
	 * @param string $url page URL
	 * @return mixed report
	 */
	abstract public function getReport($url);
}
