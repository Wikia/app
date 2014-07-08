<?php

/**
 * Admin Upload Tool Helper
 *
 * @author Andrzej 'nAndy' Łukaszewski
 * @author Marcin Maciejewski
 * @author Sebastian Marzjan
 *
 */

use \Wikia\Logger\WikiaLogger;


class SpecialPromoteHelper extends WikiaObject {
	const MIN_HEADER_LENGTH = 20;
	const MAX_HEADER_LENGTH = 75;
	const MIN_DESCRIPTION_LENGTH = 300;
	const MAX_DESCRIPTION_LENGTH = 2000;
	const LARGE_IMAGE_WIDTH = 560;
	const LARGE_IMAGE_HEIGHT = 374;
	const SMALL_IMAGE_WIDTH = 180;
	const SMALL_IMAGE_HEIGHT = 100;

	/**
	 * @var WikiaHomePageHelper
	 */
	protected $homePageHelper;
	protected $wikiInfo;

	public function __construct() {
		parent::__construct();
		$this->homePageHelper = new WikiaHomePageHelper();
	}

	public function getMinHeaderLength() {
		return self::MIN_HEADER_LENGTH;
	}

	public function getMaxHeaderLength() {
		return self::MAX_HEADER_LENGTH;
	}

	public function getMinDescriptionLength() {
		return self::MIN_DESCRIPTION_LENGTH;
	}

	public function getMaxDescriptionLength() {
		return self::MAX_DESCRIPTION_LENGTH;
	}

	protected function loadWikiInfo() {
		if (empty($this->wikiInfo)) {
			$this->wikiInfo = $this->homePageHelper->getWikiInfoForSpecialPromote($this->wg->cityId, $this->wg->contLang->getCode());
		}
	}

	public function getWikiHeadline() {
		$this->loadWikiInfo();
		if (!empty($this->wikiInfo['headline'])) {
			return $this->wikiInfo['headline'];
		} else {
			return false;
		}
	}

	public function getWikiDesc() {
		$this->loadWikiInfo();
		if (!empty($this->wikiInfo['description'])) {
			return $this->wikiInfo['description'];
		} else {
			return false;
		}
	}

	public function getMainImage() {
		$this->loadWikiInfo();

		if (!empty($this->wikiInfo['images']) && !empty($this->wikiInfo['images'][0])) {
			$mainImage = $this->wikiInfo['images'][0];
			return $this->homePageHelper->getImageData($mainImage, self::LARGE_IMAGE_WIDTH, self::LARGE_IMAGE_HEIGHT);
		} else {
			return false;
		}
	}

	public function getAdditionalImages() {
		$this->loadWikiInfo();
		if (!empty($this->wikiInfo ['images']) && !empty($this->wikiInfo['images'][0])) {
			$imagesList = array_slice($this->wikiInfo['images'], 1, null, true);
			$images = array();
			foreach ($imagesList as $image) {
				$images[] = $this->homePageHelper->getImageData($image, self::SMALL_IMAGE_WIDTH, self::SMALL_IMAGE_HEIGHT);
			}
			return $images;
		} else {
			return false;
		}
	}

	public function saveVisualizationData($data, $langCode) {
		wfProfileIn(__METHOD__);

		$cityId = $this->wg->cityId;
		$files = array('additionalImages' => array());

		$visualizationModel = new CityVisualization();
		$isCorpLang = $visualizationModel->isCorporateLang($langCode);

		foreach ($data as $fileType => $dataContent) {
			switch ($fileType) {
				case 'mainImageName':
					$mainFileName = $dataContent;
					break;
				case 'additionalImagesNames':
					$additionalImagesNames = $dataContent;
					break;
				case 'headline':
					$headline = $dataContent;
					break;
				case 'description':
					$description = $dataContent;
					break;
				}
		}

		$updateData = array(
			'city_lang_code' => $langCode,
			'city_headline' => $headline,
			'city_description' => $description
		);

		WikiaLogger::instance()->debug( "SpecialPromote", ['method' => __METHOD__, 'files' => $files, 'data'=> $data,
				'updateData' => $updateData, 'cityId' => $cityId]);

		$visualizationModel->saveVisualizationData($cityId, $updateData, $langCode);

		$promoImages = array_merge([$mainFileName],empty($additionalImagesNames)?[]:$additionalImagesNames);

		if (!empty($promoImages)) {
			$imageReviewState = $isCorpLang
				? ImageReviewStatuses::STATE_UNREVIEWED
				: ImageReviewStatuses::STATE_AUTO_APPROVED;
			$visualizationModel->saveImagesForReview($cityId, $langCode, $promoImages, $imageReviewState);
		}

		$visualizationModel->updateWikiPromoteDataCache($cityId, $langCode, $updateData);

		// clear memcache so it's visible on site after edit

		$corpWikiId = $visualizationModel->getTargetWikiId($langCode);

		// wiki info cache
		$visualizationModel->purgePromotionImageCacheEverywhere($cityId, $langCode);

		// wiki list cache
		$this->wg->memc->delete(
			$visualizationModel->getVisualizationWikisListDataCacheKey($corpWikiId, $langCode)
		);
		// batches cache
		$this->wg->memc->delete(
			$visualizationModel->getVisualizationBatchesCacheKey($corpWikiId, $langCode)
		);

		wfProfileOut(__METHOD__);
	}

	protected function checkWikiStatus($wikiId, $langCode) {
		$wikiStatus = [
			'hasImagesRejected' => false,
			'hasImagesInReview' => false,
			'isApproved' => false,
			'isAutoApproved' => false
		];
		
		WikiaLogger::instance()->debug( "SpecialPromote", ['method' => __METHOD__, 'wikiId' => $wikiId, 'lang' => $langCode] );

		$visualization = new CityVisualization();
		$wikiDataVisualization = $visualization->getWikiDataForVisualization($wikiId, $langCode);
		$mainImage = $this->getMainImage();
		$additionalImages = $this->getAdditionalImages();

		if (!empty($wikiDataVisualization['main_image'])) {
			$wikiStatus['isApproved'] = true;
		}

		$imageStatuses = array();
		if($mainImage) {
			$imageStatuses []= $mainImage['review_status'];
		}
		if ($additionalImages) {
			foreach($additionalImages as $image) {
				$imageStatuses []= $image['review_status'];
			}
		}		
		foreach($imageStatuses as $status) {
			switch($status) {
				case ImageReviewStatuses::STATE_REJECTED:
					$wikiStatus['hasImagesRejected'] = true;
					break;
				case ImageReviewStatuses::STATE_UNREVIEWED:
				case ImageReviewStatuses::STATE_IN_REVIEW:
				case ImageReviewStatuses::STATE_QUESTIONABLE:
				case ImageReviewStatuses::STATE_QUESTIONABLE_IN_REVIEW:
				$wikiStatus['hasImagesInReview'] = true;
					break;
				case ImageReviewStatuses::STATE_AUTO_APPROVED:
					$wikiStatus['isAutoApproved'] = true;
					break;
			}
		}
		WikiaLogger::instance()->debug( "SpecialPromote", ['method' => __METHOD__, "imageStatuses" => $imageStatuses] );
		return $wikiStatus;
	}

	public function triggerReindexing() {
		// FIXME: currently reindexing of only SpecialPromote data is impossible, some page must be indexed with it
		// so MainPage took the bullet, if in future search reindexing would be more selective, attempt to reindex only SpecialPromote data
		$article = new Article(Title::newMainPage());
		ScribeEventProducerController::notifyPageHasChanged($article->getPage());
	}

	public function getWikiStatusMessage($WikiId, $langCode) {
		$wikiStatus = $this->checkWikiStatus($WikiId, $langCode);
		if ($wikiStatus['isAutoApproved']) {
			$wikiStatusMessage = wfMessage('promote-statusbar-auto-approved', $this->wg->Sitename)->parse();
		} else if ($wikiStatus["hasImagesRejected"]) {
			$wikiStatusMessage = wfMessage('promote-statusbar-rejected')->parse();
		} else if ($wikiStatus["hasImagesInReview"]) {
			$wikiStatusMessage = wfMessage('promote-statusbar-inreview')->parse();
		} else if ($wikiStatus["isApproved"]) {
			$wikiStatusMessage = wfMessage('promote-statusbar-approved', $this->wg->Sitename)->parse();
		} else {
			$wikiStatusMessage = null;
		}
		return $wikiStatusMessage;
	}
}
