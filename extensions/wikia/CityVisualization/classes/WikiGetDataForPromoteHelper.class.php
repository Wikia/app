<?php

class WikiGetDataForPromoteHelper implements WikiGetDataHelper {
	protected $visualization;

	/**
	 * @return CityVisualization
	 */
	protected function getVisualization() {
		if(empty($this->visualization)) {
			$this->visualization = new CityVisualization();
		}
		return $this->visualization;
	}

	public function getMemcKey($wikiId, $langCode) {
		$visualization = $this->getVisualization();
		return $visualization->getWikiPromoteDataCacheKey($wikiId, $langCode);
	}

	public function getImages($wikiId, $langCode, $wikiRow) {
		$visualization = $this->getVisualization();
		return $visualization->getWikiImageNames($wikiId, $langCode, ImageReviewStatuses::STATE_ANY);
	}

	/**
	 * @param $wikiId int
	 * @param $langCode String
	 * @param $imageSource object (city_visualization row)
	 * @param $currentData array
	 * @return bool
	 */
	public function getMainImage($wikiId, $langCode, $imageSource, &$currentData) {
 		if(!empty($currentData['images']) && !empty($currentData['images'][0])) {
			$mainImage = array_shift($currentData['images']);
 			return $mainImage;
 		}
 		return false;
 	}
}
