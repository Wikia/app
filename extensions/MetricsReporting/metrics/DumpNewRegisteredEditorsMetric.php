<?php

class DumpNewRegisteredEditorsMetric extends ApiAnalyticsBase {

	public function getAllowedFilters() {
		return array(
			'selectprojects',
			'selectwikis',
		);
	}

	protected function getQueryInfo() {
		return array(
			'table' => array( 'wikistats' ),
			'conds' => array(),
			'options' => array( 'GROUP BY' => 'date', ),
			'join_conds' => array(),
		);
	}

	protected function getQueryFields() {
		return array( 'editors_new' );
	}

	public function getDescription() {
		return 'All registered editors that in a certain month for the first time crossed the threshold of 10 edits since signing up';
	}

	public function getExamples() {
		return array(
			'api.php?action=analytics&metric=dumpnewregisterededitors',
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: DumpNewRegisteredEditorsMetric.php 91574 2011-07-06 18:09:34Z reedy $';
	}
}
