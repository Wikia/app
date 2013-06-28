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
			'city_visualization.city_main_image is not null',
			'city_visualization.city_lang_code' => $this->contentLang,
			'city_visualization.city_vertical' => $this->verticalId,
			'(city_visualization.city_flags & ' . WikisModel::FLAG_BLOCKED . ') != ' . WikisModel::FLAG_BLOCKED,
		];
	}

	public function getPromotionCondition( $isPromoted ) {
		return $isPromoted;
	}
}
