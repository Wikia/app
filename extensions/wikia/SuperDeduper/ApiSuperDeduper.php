<?php

class ApiSuperDeduper extends ApiBase {

	public function __construct($main, $action) {
		parent :: __construct($main, $action);
	}

	public function getCustomPrinter() {
		return $this->getMain()->createPrinterByName('json');
	}

	public function execute() {
		$params = $this->extractRequestParams();
		$lang = $params['lang'];
		$db = $params['db'];
		$query = $params['query'];
		$limit = $params['limit'];
		
		$this->getMain()->setCacheMaxAge( 3600 );

		$sd = new AwesomeDeduper( $lang, $db );
		$results = $sd->getRankedmatches( $query, $limit );
		$out = array();
		foreach( $results as $title => $rank ) {
			$out[] = array( 'title' => $title, 'rank' => $rank );
		}
		$this->getResult()->addValue( 'ResultSet', 'Result', $out );
	}

	public function getAllowedParams() {
		return array (
			'query' => null,
			'limit' => array (
				ApiBase :: PARAM_DFLT => 10,
				ApiBase :: PARAM_TYPE => 'integer',
				ApiBase :: PARAM_MIN => 1,
				ApiBase :: PARAM_MAX => 100,
				ApiBase :: PARAM_MAX2 => 100
			),
			'lang' => array(
				ApiBase :: PARAM_DFLT => 'en',
				ApiBase :: PARAM_TYPE => 'string',
			),
			'db' => array(
				ApiBase :: PARAM_DFLT => 'answers',
				ApiBase :: PARAM_TYPE => 'string',
			),
		);
	}

	public function getParamDescription() {
		return array (
			'query' => 'Search string',
			'limit' => 'Maximum amount of results to return',
			'lang' => 'Language',
			'db' => 'Database to query',
		);
	}

	public function getDescription() {
		return 'This module implements JSON interface to the super deduper for type-ahead completion';
	}

	protected function getExamples() {
		return array (
			'api.php?action=superdeduper&query=test'
		);
	}

	public function getVersion() {
		return __CLASS__ . ': v1.0';
	}
}
