<?php
class WikiaHubsExploreModel extends WikiaModel {
	const FORM_SECTION_LIMIT = 4;
	const FORM_SECTION_LINKS_LIMIT = 5;

	public function getFormSectionsLimit() {
		return self::FORM_SECTION_LIMIT;
	}

	public function getLinksLimit() {
		return self::FORM_SECTION_LINKS_LIMIT;
	}
}
