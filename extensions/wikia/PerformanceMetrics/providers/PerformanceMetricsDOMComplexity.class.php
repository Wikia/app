<?php

class PerformanceMetricsDOMComplexity extends PerformanceMetricsProvider {

	function __construct() {
		parent::__construct();
	}

	/**
	 * Return DOM complexity report for a given URL
	 *
	 * @see http://mir.aculo.us/dom-monster/
	 *
	 * @param string $url page URL
	 * @return mixed report
	 */
	public function getReport($url) {
		$report = array(
			'metrics' => array(),
		);

		// fetch the page ...
		$html = Http::get($url);

		if (empty($html)) {
			return false;
		}

		// ... and parse it
		$dom = $this->parseToDOM($html);

		if (empty($dom)) {
			return false;
		}

		$xpath = new DOMXPath($dom);

		$report['metrics']['numberOfDOMNodes'] = $xpath->query('//*')->length;
		$report['metrics']['numberOfTextNodes'] = $xpath->query('//text()')->length;

		// TODO
		$report['metrics']['maxNodeDepth'] = 0;
		$report['metrics']['avgNodesDepth'] = 0;
		$report['metrics']['medNodesDepth'] = 0;

		return $report;
	}

	/**
	 * Parse given HTML to DOM
	 */
	private function parseToDOM($html) {
		// parse the page
		$doc = new DOMDocument();

		wfSuppressWarnings();
		$doc->loadHTML($html);
		wfRestoreWarnings();

		return $doc;
	}
}
