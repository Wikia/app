<?php

class WikiDataGetterForSpecialPromote extends WikiDataGetter {
	public function getWikiData($wikiId, $langCode) {
		$visualization = new CityVisualization();
		$wikiData = $visualization->getWikiDataForPromote($wikiId, $langCode);
		return $this->sanitizeWikiData($wikiData);
	}
}