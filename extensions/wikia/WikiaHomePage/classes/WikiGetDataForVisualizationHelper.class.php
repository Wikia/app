<?php

class WikiGetDataForVisualizationHelper implements WikiGetDataHelper {
	public function getMemcKey($wikiId, $langCode) {
		/** @var $adminUploadReviewHelper AdminUploadReviewHelper */
		$adminUploadReviewHelper = F::build('AdminUploadReviewHelper');

		/** @var $visualization CityVisualization */
		$visualization = F::build('CityVisualization');

		return $visualization->getWikiDataCacheKey($adminUploadReviewHelper->getTargetWikiId($langCode), $wikiId, $langCode);
	}

	public function getImages($wikiId, $langCode, $wikiRow) {
		return json_decode($wikiRow->city_images);
	}
}
