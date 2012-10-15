<?php

class ComScoreReachPercentageMetric extends ApiAnalyticsBase {

	public function getAllowedFilters() {
		return array(
			'selectregions',
			'selectcountries',
		);
	}

	protected function getQueryInfo() {
		return array(
			'table' => array( 'comscore', 'comscore_regions' ),
			'conds' => array(),
			'options' => array( 'GROUP BY' => 'comscore.region_code, date', 'ORDER BY' => 'comscore.region_code, date' ),
			'join_conds' => array( 'comscore_regions' => array( 'LEFT JOIN', "comscore.region_code = comscore_regions.region_code" )
			),
		);
	}

	protected function getQueryFields() {
		return array( 'date', 'reach', 'comscore.region_code', 'region_name' );
	}

	protected function takesReportLanguage(){
		return true;
	}

	public function getDescription() {
		return 'Percentage of total unique visitors to any web property which also visited a Wikimedia Wiki';
	}

	public function getExamples() {
		return array(
			'api.php?action=analytics&metric=comscorereachpercentage',
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: ComScoreReachPercentageMetric.php 93027 2011-07-24 23:12:40Z reedy $';
	}
}
