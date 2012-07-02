<?php

class DumpActiveEditors5Metric extends ApiAnalyticsBase {

	protected $numberOfActiveEditors = 5;
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
			'options' => array( 'GROUP BY' => 'date', 'ORDER BY' => 'date' ),
			'join_conds' => array(),
		);
	}

	protected function getQueryFields() {
		return array( 'date', 'project_code', "SUM(editors_ge_{$this->numberOfActiveEditors})" );
	}

	public function getDescription() {
		return "All registered editors that made {$this->numberOfActiveEditors} or more edits in a certain month";
	}

	public function getExamples() {
		return array(
			"api.php?action=analytics&metric=dumpactiveeditors{$this->numberOfActiveEditors}",
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: DumpActiveEditors5Metric.php 91574 2011-07-06 18:09:34Z reedy $';
	}
}
