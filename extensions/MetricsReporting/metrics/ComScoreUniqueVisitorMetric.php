<?php

class ComScoreUniqueVisitorMetric extends ApiAnalyticsBase {

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
			'join_conds' => array( 'comscore_regions' => array( 'LEFT JOIN', 'comscore.region_code = comscore_regions.region_code' )
			),
		);
	}

	protected function getQueryFields() {
		return array(
			'date', 'country_code', /* 'country_name', */ 'comscore.region_code',
			'region_name', 'web_property', 'project_code', 'reach', 'visitors'
		);
	}

	protected function takesReportLanguage(){
		return true;
	}

	public function getDescription() {
		return 'Unique persons that visited one of the Wikimedia wikis at least once in a certain month';
	}

	public function getExamples() {
		return array(
			'api.php?action=analytics&metric=comscoreuniquevisitors',
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: ComScoreUniqueVisitorMetric.php 91574 2011-07-06 18:09:34Z reedy $';
	}
}
