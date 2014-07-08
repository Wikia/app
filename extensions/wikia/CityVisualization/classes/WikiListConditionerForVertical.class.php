<?php

class WikiListConditionerForVertical implements WikiListConditioner {
	private $contentLang;
	private $verticalId;

	public function __construct($contentLang, $verticalId) {
		$this->contentLang = $contentLang;
		$this->verticalId = $verticalId;
	}

	public function getCondition() {
		return [
			'city_list.city_public' => 1,
			CityVisualization::CITY_VISUALIZATION_TABLE_NAME . '.city_lang_code' => $this->contentLang,
			CityVisualization::CITY_VISUALIZATION_TABLE_NAME . '.city_vertical' => $this->verticalId,
			'(' . CityVisualization::CITY_VISUALIZATION_TABLE_NAME . '.city_flags & ' . WikisModel::FLAG_BLOCKED . ') != ' . WikisModel::FLAG_BLOCKED,
		];
	}

	public function getPromotionCondition( $isPromoted ) {
		return $isPromoted;
	}
}
