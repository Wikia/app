<?php

class WikiDataGetterForVisualization extends WikiDataGetter {
	public function getWikiData($wikiId, $langCode) {
		$visualization = new CityVisualization();
		$wikiData = $visualization->getWikiDataForVisualization($wikiId, $langCode);
		return $this->sanitizeWikiData($wikiData);
	}
}
