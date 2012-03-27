<?php

class PerformanceMetricsPhantom extends PerformanceMetricsProvider {

	function __construct() {
		parent::__construct();
	}

	/**
	 * Return metrics for given URL from phantomjs-powered JS script
	 *
	 * @see http://code.google.com/p/phantomjs/wiki/BuildInstructions
	 *
	 * @param string $url page URL
	 * @return mixed report
	 */
	public function getReport($url) {
		$report = array(
			'metrics' => array(),
		);

		// form command to be executed
		$dir = dirname(__FILE__);
		$urlEscaped = escapeshellcmd($url);
		$cmd = "phantomjs {$dir}/phantomjs/metrics.js {$urlEscaped}";

		exec($cmd, $output, $retVal);

		// decode the first line
		$json = json_decode(reset($output), true);

		if (!empty($json)) {
			$report['metrics'] = $json;
		}

		return $report;
	}
}
