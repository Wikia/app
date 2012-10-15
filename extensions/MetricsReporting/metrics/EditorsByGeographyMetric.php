<?php

/**
 *
 */
class EditorsByGeographyMetric extends GenericMetricBase {

	protected $tableName = 'editorsbygeography';

	public function getDescription() {
		return "Number of active unique registered editors by country";
	}

	public function getExamples() {
		return false;
	}
}
