<?php

abstract class PerformanceMetricsProvider extends WikiaObject {

	public function __construct() {
		parent::__construct();
	}

	/**
	 * Get username and password for account used by metrics tools
	 */
	protected function getCredentials() {
		$account = $this->wg->WikiaBotUsers['staff'];

		return $account;
	}

	/**
	 * Returns metrics report from a given provider
	 *
	 * @param string $url page URL
	 * @param array $options additional options
	 * @return mixed report
	 */
	abstract public function getReport($url, Array $options = array());
}
