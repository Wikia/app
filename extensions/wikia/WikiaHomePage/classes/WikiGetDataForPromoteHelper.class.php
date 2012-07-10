<?php

class WikiGetDataForPromoteHelper implements WikiGetDataHelper {
	public function getMemcKey($wikiId, $langCode) {
		$visualization = F::build('CityVisualization');
		return $visualization->getWikiPromoteDataCacheKey($wikiId, $langCode);
	}

	public function getImages($wikiId, $langCode, $wikiRow) {
		return (array)json_decode($wikiRow->city_images);
	}
}
