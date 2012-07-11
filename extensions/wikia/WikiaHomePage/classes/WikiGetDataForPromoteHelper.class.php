<?php

class WikiGetDataForPromoteHelper implements WikiGetDataHelper {
	public function getMemcKey($wikiId, $langCode) {
		$visualization = F::build('CityVisualization');
		return $visualization->getWikiPromoteDataCacheKey($wikiId, $langCode);
	}

	public function getImages($wikiId, $langCode, $wikiRow) {
		$visualization = F::build('CityVisualization');
		return $visualization->getWikiImageNames($wikiId, $langCode, ImageReviewStatuses::STATE_ANY);
	}
}
