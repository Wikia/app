<?php
class MarketingToolboxExploreModel extends WikiaModel {
	const FORM_SECTION_LIMIT = 4;
	const FORM_SECTION_LINKS_LIMIT = 5;

	const MAX_IMAGE_WIDTH = 142;
	const MAX_IMAGE_HEIGHT = 200;

	public function getFormSectionsLimit() {
		return self::FORM_SECTION_LIMIT;
	}

	public function getLinksLimit() {
		return self::FORM_SECTION_LINKS_LIMIT;
	}
}
