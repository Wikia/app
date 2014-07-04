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

	/*
	* @deprecated
	*/
	public function getImagesMemcKey( $wikiId, $langCode ) {

	}

	public function getImages($wikiId, $langCode, $wikiRow = null) {
		global $wgExternalSharedDB;

		$db = wfGetDB(DB_SLAVE, [], $wgExternalSharedDB);

		$query = (new \WikiaSQL())
			->SELECT('image_name','image_index','image_review_status')
			->FROM(CityVisualization::CITY_VISUALIZATION_IMAGES_TABLE_NAME)
			->WHERE('city_id')->EQUAL_TO($wikiId)
			->AND_('image_type')->EQUAL_TO(PromoImage::ADDITIONAL)
			->AND_('city_lang_code')->EQUAL_TO($langCode)
			->AND_('image_review_status')->IN(
				ImageReviewStatuses::STATE_APPROVED,
				ImageReviewStatuses::STATE_APPROVED_AND_TRANSFERRING,
				ImageReviewStatuses::STATE_AUTO_APPROVED,
				ImageReviewStatuses::STATE_IN_REVIEW,
				ImageReviewStatuses::STATE_UNREVIEWED
			);

		$wikiImages = $query->run($db, function ($result) {
			$wikiImages = [];
			while ($row = $result->fetchObject($result)) {
				$parsed = WikiImageRowHelper::parseWikiImageRow($row);

				$promoImage = new PromoXWikiImage($parsed->name);
				$promoImage->setReviewStatus($parsed->review_status);
				$wikiImages[$parsed->index] = $promoImage;
			}
			return $wikiImages;
		});

		return $wikiImages;
	}

	/**
	 * @param $wikiId int
	 * @param $langCode String
	 * @param $imageSource object (city_visualization row)
	 * @param $currentData array
	 * @return bool
	 */
	public function getMainImage($wikiId, $langCode, $imageSource = null, &$currentData = null) {
		global $wgExternalSharedDB;

		$db = wfGetDB(DB_SLAVE, [], $wgExternalSharedDB);

		$query = (new \WikiaSQL())
			->SELECT('image_name','image_index','image_review_status')
			->FROM(CityVisualization::CITY_VISUALIZATION_IMAGES_TABLE_NAME)
			->WHERE('city_id')->EQUAL_TO($wikiId)
			->AND_('city_lang_code')->EQUAL_TO($langCode)
			->AND_('image_type')->EQUAL_TO(PromoImage::MAIN)
			->AND_('image_review_status')->IN(
				ImageReviewStatuses::STATE_APPROVED,
				ImageReviewStatuses::STATE_APPROVED_AND_TRANSFERRING,
				ImageReviewStatuses::STATE_AUTO_APPROVED,
				ImageReviewStatuses::STATE_IN_REVIEW,
				ImageReviewStatuses::STATE_UNREVIEWED
			);

		$promoImage = $query->run($db, function ($result) {
			while ($row = $result->fetchObject($result)) {
				$parsed = WikiImageRowHelper::parseWikiImageRow($row);

				$promoImage = new PromoXWikiImage($parsed->name);
				$promoImage->setReviewStatus($parsed->review_status);
				return $promoImage;
			}
		});

		return $promoImage;
 	}
}
