<?php

/**
 * Subclass this, pass the table name to the constructor, then just override
 * the getDescription and getExamples functions
 *
 * Then add it to the loader
 */
abstract class GenericMetricBase extends ApiAnalyticsBase {

	protected $tableName;

	/**
	 * @param $query ApiBase
	 * @param $moduleName
	 * @return GenericMetricBase
	 *
	 */
	function __construct( ApiBase $query, $moduleName ) {
		parent::__construct( $query->getMain(), $moduleName );
	}

	public function getAllowedFilters() {
		return array(
			'selectprojects',
			'selectcountries',
		);
	}

	protected function getQueryInfo() {
		$params = $this->extractRequestParams();

		if ( $params['selectcountries'] || $params['selectproject'] ) {
			$items = array();
			if ( $params['selectproject'] ) {
				$items[] = $params['selectproject'];
			}
			if ( $params['selectcountries'] ) {
				$items[] = $params['selectcountries'];
			}
			$string = explode( ',', $items );
			$options = array( 'GROUP BY' => $string, 'ORDER BY' => $string );
		} else {
			// Fallback to date
			$options = array( 'GROUP BY' => 'date', 'ORDER BY' => 'date' );
		}
		return array(
			'table' => array( $this->tableName ),
			'conds' => array(),
			'options' => $options,
			'join_conds' => array(),
		);
	}

	protected function getQueryFields() {
		return array( 'date', 'language_code', 'project_code', 'country_code', 'SUM(value)' );
	}

	public function getDescription() {
		throw new Exception( "Not implemented" );
	}

	public function getExamples() {
		throw new Exception( "Not implemented" );
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: GenericMetricBase.php 97630 2011-09-20 14:59:06Z reedy $';
	}
}