<?php

class WikiGetDataForVisualizationHelper implements WikiGetDataHelper {
	public function getMemcKey($wikiId, $langCode) {
		$visualization = F::build('CityVisualization');
		return $visualization->getWikiDataCacheKey($wikiId, $langCode);
	}

	public function getImages($wikiId, $langCode, $wikiRow) {
		return json_decode($wikiRow->city_images);
	}
}
