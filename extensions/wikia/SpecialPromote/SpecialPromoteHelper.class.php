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
			$mainImageName = $this->wikiInfo['images'][0];
			return $this->homePageHelper->getImageData($mainImageName, self::LARGE_IMAGE_WIDTH, self::LARGE_IMAGE_HEIGHT);
		} else {
			return false;
		}
	}

	public function getAdditionalImages() {
		$this->loadWikiInfo();
		if (!empty($this->wikiInfo ['images']) && !empty($this->wikiInfo['images'][0])) {
			$imagesNames = array_slice($this->wikiInfo['images'], 1);
			$images = array();
			foreach ($imagesNames as $imageName) {
				$images[] = $this->homePageHelper->getImageData($imageName, self::SMALL_IMAGE_WIDTH, self::SMALL_IMAGE_HEIGHT);
			}
			return $images;
		} else {
			return false;
		}
	}

	public function getAdditionalImagesNames() {
		$additionalImages = $this->getAdditionalImages();
		$out = [];
		if (!empty($additionalImages)) {
			foreach($additionalImages as $image) {
				$out[] = $image['image_filename'];
			}
		}
		return $out;
	}

	public function uploadImage( $upload ) {
		global $wgEnableUploads;

		$uploadStatus = array( "status" => "error" );

		if ( empty( $wgEnableUploads ) ) {
			$uploadStatus["errors"] = [ wfMessage( 'promote-upload-image-uploads-disabled' )->plain() ];
		} else {
			$upload->initializeFromRequest( $this->wg->request );
			$permErrors = $upload->verifyPermissions( $this->wg->user );

			if ( $permErrors !== true ) {
				$uploadStatus["errors"] = array( wfMessage( 'badaccess' )->plain() );
			} else {
				$details = $upload->verifyUpload();

				if ( $details['status'] != UploadBase::OK ) {
					$uploadStatus["errors"] = array( $this->getUploadErrorMessage( $details ) );
				} else {
					$warnings = $upload->checkWarnings();

					if ( ! empty( $warnings ) ) {
						$uploadStatus["errors"] = $this->getUploadWarningMessages( $warnings );
					} else {
						//save temp file
						$file = $upload->stashFile();

						$uploadStatus["status"] = "uploadattempted";
						if ( $file instanceof File ) {
							$uploadStatus["isGood"] = true;
							$uploadStatus["file"] = $file;
						} else {
							$uploadStatus["isGood"] = false;
						}
					}
				}
			}
		}

		return $uploadStatus;
	}

	private function getUploadErrorMessage($status) {
		global $wgFileExtensions, $wgLang;
		$msg = '';

		switch ($status['status']) {
			case UploadVisualizationImageFromFile::FILEDIMENSIONS_ERROR:
				$msg = wfMsg('promote-error-upload-dimensions-error');
				break;
			case UploadVisualizationImageFromFile::FILETYPE_ERROR:
				$msg = wfMsg('promote-error-upload-filetype-error');
				break;
			case UploadBase::MIN_LENGTH_PARTNAME:
				$msg = wfMsg('minlength1');
				break;
			case UploadBase::ILLEGAL_FILENAME:
				$msg = wfMsgExt(
					'illegalfilename',
					'parseinline',
					$status['filtered']
				);
				break;
			case UploadBase::OVERWRITE_EXISTING_FILE:
				$msg = wfMsgExt(
					$status['overwrite'],
					'parseinline'
				);
				break;
			case UploadBase::FILETYPE_MISSING:
				$msg = wfMsgExt(
					'filetype-missing',
					'parseinline'
				);
				break;
			case UploadBase::EMPTY_FILE:
				$msg = wfMsgHtml('emptyfile');
				break;
			case UploadBase::FILETYPE_BADTYPE:
				$finalExt = $status['finalExt'];

				$msg = wfMsgExt(
					'filetype-banned-type',
					array('parseinline'),
					htmlspecialchars($finalExt),
					implode(
						wfMsgExt(
							'comma-separator',
							array('escapenoentities')
						),
						$wgFileExtensions
					),
					$wgLang->formatNum(count($wgFileExtensions))
				);
				break;
			case UploadBase::VERIFICATION_ERROR:
				unset($status['status']);
				$code = array_shift($status['details']);
				$msg = wfMsgExt(
					$code,
					'parseinline',
					$status['details']
				);
				break;
			case UploadBase::HOOK_ABORTED:
				if (is_array($status['error'])) { # allow hooks to return error details in an array
					$args = $status['error'];
					$error = array_shift($args);
				} else {
					$error = $status['error'];
					$args = null;
				}

				$msg = wfMsgExt($error, 'parseinline', $args);
				break;
			default:
				throw new MWException(__METHOD__ . ": Unknown value `{$status['status']}`");
		}

		return $msg;
	}

	private function getUploadWarningMessages($warnings) {
		$ret = array();

		foreach ($warnings as $warning => $args) {
			if ($args === true) {
				$args = array();
			} elseif (!is_array($args)) {
				$args = array($args);
			}

			$ret[] = wfMsgExt($warning, 'parseinline', $args);
		}

		return $ret;
	}

	public function removeTempImage($imageName) {
		global $wgEnableUploads;

		if ( empty( $wgEnableUploads ) ) {
			throw new Exception('promote-upload-image-uploads-disabled');
		}

		try {
			$file = RepoGroup::singleton()->getLocalRepo()->getUploadStash()->getFile( $imageName );

			if ( $file instanceof File ) {
				$file->remove();
				return true;
			}
		} catch ( Exception $e ) {
			return false;
		}

		return false;
	}

	public function removeImage($imageName) {
		PromoImage::fromPathname($imageName)->deleteImage();
	}

	public function saveVisualizationData($data, $langCode) {
		global $wgEnableUploads;

		wfProfileIn(__METHOD__);

		if ( empty( $wgEnableUploads ) ) {
			throw new Exception('promote-upload-image-uploads-disabled');
		}

		$cityId = $this->wg->cityId;
		$files = array('additionalImages' => array());
		$promoImages = array();

		$visualizationModel = new CityVisualization();
		$isCorpLang = $visualizationModel->isCorporateLang($langCode);

		foreach ($data as $fileType => $dataContent) {
			switch ($fileType) {
				case 'mainImageName':
					$fileName = $dataContent;
					// uploaded fileName that matches through infer type, means that
					// file was not really uploaded, and was already present in DB
					// FIXME: this mechanism is hacky, it should be more durable than string matching

					$promoMainImage = PromoImage::fromPathname($fileName);

					if ($promoMainImage->isType(PromoImage::MAIN)) {
						//check if file exists on current wiki
						$file = GlobalFile::newFromText($promoMainImage->getPathname(), $cityId);
						if ($file->exists()){
							array_push($promoImages, $promoMainImage);
						}
					} else {
						$promoMainImage = new PromoImage(PromoImage::MAIN, $this->wg->DBname);
						$promoMainImage->processUploadedFile($fileName);
						array_push($promoImages, $promoMainImage);
					}

					break;
				case 'additionalImagesNames':
					$additionalImagesNames = $dataContent;
					$additionalImages= $this->saveAdditionalFiles($additionalImagesNames);

					$promoImages = array_merge($promoImages, $additionalImages);
					break;
				case 'headline':
					$headline = $dataContent;
					break;
				case 'description':
					$description = $dataContent;
					break;
				}
		}

		//attempt to cleanup if there used to be a promo main image
		if (empty($promoMainImage)){
			$promoMainImage = new PromoImage(PromoImage::MAIN, $this->wg->DBname);
			if ($promoMainImage->corporateFileByLang($this->wg->ContLanguageCode)->exists()){
				$promoMainImage->deleteImageFromCorporate();
			}
		}

		$updateData = array(
			'city_lang_code' => $langCode,
			'city_headline' => $headline,
			'city_description' => $description
		);

		$additionalImageNames = array();
		$modifiedImageNames = array();

		foreach($promoImages as $promoImage){
			if ($promoImage->isType(PromoImage::MAIN)){
				if (!$promoImage->wasRemoved()){
					$updateData['city_main_image'] = $promoImage->getPathname();
				} else {
					$updateData['city_main_image'] = null;
				}
			} else {
				if (!$promoImage->wasRemoved()){
					array_push($additionalImageNames, $promoImage->getPathname());
				}
			}

			if ($promoImage->isFileChanged() and !$promoImage->wasRemoved()){
				array_push($modifiedImageNames, $promoImage->getPathname());
			}
		}
		$updateData['city_images'] = json_encode($additionalImageNames);

		WikiaLogger::instance()->debug( "SpecialPromote", ['method' => __METHOD__, 'files' => $files, 'data'=> $data,
				'updateData' => $updateData, 'cityId' => $cityId]);

		$visualizationModel->saveVisualizationData($cityId, $updateData, $langCode);

		if (!empty($modifiedImageNames)) {
			$imageReviewState = $isCorpLang
				? ImageReviewStatuses::STATE_UNREVIEWED
				: ImageReviewStatuses::STATE_AUTO_APPROVED;
			$visualizationModel->saveImagesForReview($cityId, $langCode, $modifiedImageNames, $imageReviewState);
		}

		$visualizationModel->updateWikiPromoteDataCache($cityId, $langCode, $updateData);

		// clear memcache so it's visible on site after edit
		$helper = new WikiGetDataForVisualizationHelper();
		$corpWikiId = $visualizationModel->getTargetWikiId($langCode);
		// wiki info cache
		$this->wg->memc->delete($helper->getMemcKey($cityId, $langCode));
		$this->wg->memc->delete((new WikiGetDataForPromoteHelper())->getMemcKey($cityId, $langCode));
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

	protected function saveAdditionalFiles($additionalImagesNames) {
		$unchangedTypes = array();
		$imagesToProcess = array();
		$allFiles = array();
		foreach($additionalImagesNames as $singleFileName) {
			$promoImage= PromoImage::fromPathname($singleFileName);

			if (!$promoImage->isType(PromoImage::INVALID)){
				// check if file exists, if not do not add it to processed files, effectively removing it
				$file = GlobalFile::newFromText($promoImage->getPathname(), $this->wg->cityId);
				if ($file->exists()){
					array_push($promoImages, $promoImage);
				}

				if (in_array($unchangedTypes, $promoImage->getType())){
					WikiaLogger::instance()->info("SpecialPromote additional files duplicated type", ['method' => __METHOD__, 'type_duplicated' => $promoImage->getType()]);

				} else {
					array_push($unchangedTypes, $promoImage->getType());
				}
				array_push($allFiles, $promoImage);
			} else {
				array_push($imagesToProcess, $singleFileName);
			}
		}

		$freeImageTypeSlots = array_diff(PromoImage::listAllAdditionalTypes(), $unchangedTypes);
		foreach($imagesToProcess as $uploadedImageFileName) {
			$imageType = array_shift($freeImageTypeSlots);

			if (!empty($imageType)) {
				$promoImage = new PromoImage($imageType, $this->wg->DBname);
				$promoImage->processUploadedFile($uploadedImageFileName);
				array_push($allFiles, $promoImage);
			} else {
				WikiaLogger::instance()->info("SpecialPromote too many uploaded files", ['method' => __METHOD__]);
				break;
			}
		}

		// attempt to Delete Leftover image types from corporate wiki
		foreach($freeImageTypeSlots as $imageType){
			$promoImage = new PromoImage($imageType, $this->wg->DBname);
			if ($promoImage->corporateFileByLang($this->wg->ContLanguageCode)->exists()){
				$promoImage->deleteImageFromCorporate();
			}
		}

		return $allFiles;
	}

	public function getImageUrl($imageFile, $requestedWidth, $requestedHeight) {
		return $this->homePageHelper->getImageUrlFromFile($imageFile, $requestedWidth, $requestedHeight);
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
		//FIXME: ...
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
