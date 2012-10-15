<?php

class SquidPageViewsMetric extends ApiAnalyticsBase {

	public function __construct( ApiBase $query, $moduleName ) {
		parent::__construct( $query->getMain(), $moduleName );

		$this->normaliseQueryParameters();
	}

	public function getAllowedFilters() {
		return array(
			'selectregions',
			'selectcountries',
			'selectwebproperties',
			'selectprojects',
			'selectwikis',
			'selectplatform',
		);
	}

	protected function getQueryInfo() {
		return array(
			'table' => array( 'page_views' ),
			'conds' => array(),
			'options' => array( 'GROUP BY' => array( 'date' ) ),
			'join_conds' => array(),
		);
	}

	protected $queryFields;

	protected function getQueryFields() {
		return $this->queryFields;
	}

	protected function canBeNormalised() {
		return true;
	}

	public function normaliseQueryParameters( $normalise = false ) {
		// TODO: Change fields/table to normalise data set returned
		// Swap page_views for page_views_v

		parent::normaliseQueryParameters( $normalise );
		if ( $normalise ) {
			$this->queryFields = array( 'date', 'SUM(views_mobile_normalized)', 'SUM(views_non_mobile_normalized)' );
		} else {
			$this->queryFields = array( 'date', 'SUM(views_mobile_raw)', 'SUM(views_non_mobile_raw)' );
		}
	}

	public function getDescription() {
		return array(
			'Total articles (htm component) requested from nearly all Wikimedia wikis (exceptions are mostly special purpose wikis, e.g. wikimania wikis)',
			'Totals are based on the archived 1:1000 sampled squid logs.',
		);
	}

	public function getExamples() {
		return array(
			'api.php?action=analytics&metric=squidpageviews',
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: SquidPageViewsMetric.php 95534 2011-08-25 21:53:32Z reedy $';
	}
}
