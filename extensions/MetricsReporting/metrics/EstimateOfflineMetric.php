<?php

class EstimateOfflineMetric extends ApiAnalyticsBase {

	public function getAllowedFilters() {
		return array();
	}

	protected function getQueryInfo() {
		return array(
			'table' => 'offline',
			'conds' => array(),
			'options' => array( 'GROUP BY' => 'date' ),
			'join_conds' => array(),
		);
	}

	protected function getQueryFields() {
		return array(
			'date', 'SUM(readers)',
		);
	}

	public function getDescription() {
		return 'Estimated number of people whom access Wikipedia through an offline reader';
	}

	public function getExamples() {
		return array(
			'api.php?action=analytics&metric=estimateoffline',
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: EstimateOfflineMetric.php 98322 2011-09-28 16:03:39Z reedy $';
	}
}
