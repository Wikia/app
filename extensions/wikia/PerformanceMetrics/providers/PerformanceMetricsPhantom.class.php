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
	 * @param array $options additional options
	 * @return mixed report
	 */
	public function getReport($url, Array $options = array()) {
		$report = array(
			'metrics' => array(),
		);

		// form command to be executed
		$dir = dirname(__FILE__);
		$urlEscaped = escapeshellcmd($url);
		$cmd = "phantomjs {$dir}/phantomjs/metrics.js {$urlEscaped}";

		// support for logged-in metrics
		if (!empty($options['loggedIn'])) {
			$account = $this->getCredentials();
			$cmd .= ' ' . escapeshellcmd("{$account['username']} {$account['password']}");
		}

		exec($cmd, $output, $retVal);

		// decode the last line
		$report = json_decode(end($output), true);
		return $report;
	}
}
