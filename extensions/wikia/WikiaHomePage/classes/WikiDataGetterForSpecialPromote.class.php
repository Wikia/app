<?php

class WikiDataGetterForSpecialPromote extends WikiDataGetter {
	public function getWikiData($wikiId, $langCode) {
		$visualization = F::build('CityVisualization'); /** @var $visualization CityVisualization */
		$wikiData = $visualization->getWikiDataForPromote($wikiId, $langCode);
		return $this->sanitizeWikiData($wikiData);
	}
}