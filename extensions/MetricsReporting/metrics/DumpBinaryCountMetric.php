<?php

class DumpBinaryCountMetric extends ApiAnalyticsBase {

	public function getAllowedFilters() {
		return array(
			'selectprojects',
			'selectwikis',
		);
	}

	protected function getQueryInfo() {
		return array(
			'table' => array( 'binaries' ),
			'conds' => array(),
			'options' => array( 'GROUP BY' => 'date', ),
			'join_conds' => array(),
		);
	}

	protected function getQueryFields() {
		return array();
	}

	public function getDescription() {
		return 'All binary files (nearly all of which are multimedia files) available for download/article inclusion on a wiki';
	}

	public function getExamples() {
		return array(
			'api.php?action=analytics&metric=dumpbinarycount',
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: DumpBinaryCountMetric.php 91574 2011-07-06 18:09:34Z reedy $';
	}
}
