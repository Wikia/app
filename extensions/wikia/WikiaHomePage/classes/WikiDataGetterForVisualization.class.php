<?php

class WikiDataGetterForVisualization extends WikiDataGetter {
	public function getWikiData($wikiId, $langCode) {
		$visualization = F::build('CityVisualization');
		$wikiData = $visualization->getWikiDataForVisualization($wikiId, $langCode);
		return $this->sanitizeWikiData($wikiData);
	}
}
