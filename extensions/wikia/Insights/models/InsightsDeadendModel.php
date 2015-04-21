<?php

class InsightsDeadendModel extends InsightsQuerypageModel {
	const INSIGHT_ID = 'deadend';

	public function getDataProvider() {
		return new DeadendPagesPage();
	}

	public function getInsightId() {
		return self::INSIGHT_ID;
	}
}
