<?php
class MarketingToolboxExploreModel extends WikiaModel {
	const FORM_SECTION_LIMIT = 4;
	const FORM_SECTION_LINKS_LIMIT = 4;
	
	const FORM_IMAGE_WIDTH = 155;

	public function getFormSectionsLimit() {
		return self::FORM_SECTION_LIMIT;
	}

	public function getLinksLimit() {
		return self::FORM_SECTION_LINKS_LIMIT;
	}

	public function getImageWidth() {
		return self::FORM_IMAGE_WIDTH;
	}
	
}