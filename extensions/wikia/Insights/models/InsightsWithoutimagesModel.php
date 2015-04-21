<?php

class InsightsWithoutimagesModel extends InsightsQuerypageModel {
	const INSIGHT_ID = 'withoutimages';

	public function getDataProvider() {
		return new WithoutimagesPage();
	}

	public function getInsightId() {
		return self::INSIGHT_ID;
	}
}
