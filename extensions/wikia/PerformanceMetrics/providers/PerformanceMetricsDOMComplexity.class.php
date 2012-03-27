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

		$report['metrics'] = $this->getDOMDepthReport($dom);

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

	/**
	 * Calculate DOM nodes depth
	 *
	 * @param DOMDocument $dom parsed HTML
	 * @return mixed report
	 */
	private function getDOMDepthReport(DOMDocument $dom) {
		$depthReport = array(
			'numberOfNodes' => 0,
			'numberOfElements' => 0,

			// temporary array depth of each node is pushed to
			'depth' => array(),
		);

		// starting counting child nodes of <body>
		$body = $dom->getElementsByTagName('body');

		if (!empty($body)) {
			$this->handleNode($body->item(0), $depthReport);

			$count = $depthReport['numberOfElements'];

			// calculate an maximum nodes depth
			$depthReport['maxElementsDepth'] =  max($depthReport['depth']);

			// calculate an average nodes depth
			$depthReport['avgElementsDepth'] = round(array_sum($depthReport['depth']) / $count, 4);

			// calculate the median of nodes depth
			sort($depthReport['depth']);
			$pos = intval($count / 2);
			$depthReport['medElementsDepth'] = ($pos % 2 == 1) ? $depthReport['depth'][$pos] : (($depthReport['depth'][$pos] + $depthReport['depth'][$pos-1]) / 2);

			// cleanup
			unset($depthReport['depth']);
		}
		else {
			$depthReport = false;
		}

		return $depthReport;
	}

	/**
	 * Handle child nodes in the process of calculating DOM nodes depth
	 *
	 * This method is called recursively
	 *
	 * @param DOMElement $node current DOM node
	 * @param Array $depthReport current report state (passed as a reference)
	 * @param int $depth current depth
	 */
	private function handleNode(DOMElement $node, Array &$depthReport, $depth = 0) {
		if($node->hasChildNodes()) {
			$nodes = $node->childNodes;
			$depth++;

			// count each HTML element
			$depthReport['numberOfNodes']++;
			$depthReport['numberOfElements']++;

			// add to the stack
			$depthReport['depth'][] = $depth;

			// recursively parse each HTML child element
			foreach($nodes as $childNode) {
				if ($childNode->nodeType == XML_ELEMENT_NODE) {
					$this->handleNode($childNode, $depthReport, $depth);
				}
				else {
					$depthReport['numberOfNodes']++;
				}
			}
		}
	}
}
