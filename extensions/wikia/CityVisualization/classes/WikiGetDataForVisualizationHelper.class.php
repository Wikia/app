<?php

class WikiGetDataForVisualizationHelper implements WikiGetDataHelper {
	public function getMemcKey($wikiId, $langCode) {
		$visualization = new CityVisualization();
		$model = new WikiaCorporateModel();

		return $visualization->getWikiDataCacheKey($model->getCorporateWikiIdByLang($langCode), $wikiId, $langCode);
	}

	public function getImages($wikiId, $langCode, $wikiRow) {
		return json_decode($wikiRow->city_images);
	}

	/**
	 * @param $wikiId int
	 * @param $langCode String
	 * @param $imageSource object (city_visualization row)
	 * @param $currentData array
	 * @return bool
	 */
	public function getMainImage($wikiId, $langCode, $imageSource, &$currentData) {
 		return $imageSource->city_main_image;
 	}
}
