<?php

class DumpArticleCountMetric extends ApiAnalyticsBase {

	public function getAllowedFilters() {
		return array(
			'selectprojects',
			'selectwikis',
		);
	}

	protected function getQueryInfo() {
		return array(
			'table' => array( 'comscore' ),
			'conds' => array(),
			'options' => array( 'GROUP BY' => 'date', ),
			'join_conds' => array(),
		);
	}

	protected function getQueryFields() {
		return array( 'reach' );
	}

	public function getDescription() {
		return 'All namespace 0 pages which contain an internal link minus redirect pages (for some projects extra namespaces qualify)';
	}

	public function getExamples() {
		return array(
			'api.php?action=analytics&metric=dumparitclecount',
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: DumpArticleCountMetric.php 92626 2011-07-20 11:44:32Z reedy $';
	}
}
