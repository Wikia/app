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
		// form command to be executed
		$dir = dirname(__FILE__);
		$cookiesFile = escapeshellcmd(tempnam(wfTempDir(), 'phantom'));
		$urlEscaped = escapeshellcmd($url);

		$cmd = "phantomjs --cookies-file={$cookiesFile} {$dir}/phantomjs/metrics.js {$urlEscaped}";

		// support for logged-in metrics
		if (!empty($options['loggedIn'])) {
			$account = $this->getCredentials();
			$cmd .= ' --username=' . escapeshellcmd($account['username']);
			$cmd .= ' --password=' . escapeshellcmd($account['password']);
		}

		// support for A/B testing
		if (!empty($options['abGroup'])) {
			$cmd .= ' --abGroup=' . $options['abGroup'];
		}

		exec($cmd, $output, $retVal);

		// decode the last line
		$report = json_decode(end($output), true);
		return $report;
	}
}
