<?php

class InsightsUncategorizedModel extends InsightsQuerypageModel {
	const INSIGHT_ID = 'uncategorized';

	public $settings = [
		'template' => 'subpageList',
	];

	public function getDataProvider() {
		return new UncategorizedPagesPage();
	}

	public function getInsightId() {
		return self::INSIGHT_ID;
	}
}
