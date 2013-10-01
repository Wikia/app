<?php

/**
 * Admin Upload Tool Helper
 *
 * @author Andrzej 'nAndy' Łukaszewski
 * @author Marcin Maciejewski
 * @author Sebastian Marzjan
 *
 */

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

	public function uploadImage($upload) {
		$uploadStatus = array("status" => "error");

		$upload->initializeFromRequest($this->wg->request);
		$permErrors = $upload->verifyPermissions($this->wg->user);

		if ($permErrors !== true) {
			$uploadStatus["errors"] = array(wfMsg('badaccess'));
		} else {
			$details = $upload->verifyUpload();

			if ($details['status'] != UploadBase::OK) {
				$uploadStatus["errors"] = array($this->getUploadErrorMessage($details));
			} else {
				$warnings = $upload->checkWarnings();

				if (!empty($warnings)) {
					$uploadStatus["errors"] = $this->getUploadWarningMessages($warnings);
				} else {
					//save temp file
					$file = $upload->stashFile();

					$uploadStatus["status"] = "uploadattempted";
					if ($file instanceof File) {
						$uploadStatus["isGood"] = true;
						$uploadStatus["file"] = $file;
					} else {
						$uploadStatus["isGood"] = false;
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
		$file = RepoGroup::singleton()->getLocalRepo()->getUploadStash()->getFile($imageName);
		if ($file instanceof File) {
			$file->remove();
		}
	}

	public function removeImage($imageName) {
		$title = Title::newFromText($imageName, NS_FILE);
		$file = new LocalFile($title, RepoGroup::singleton()->getLocalRepo());

		$visualization = new CityVisualization();
		$visualization->removeImageFromReview($this->wg->cityId, $title->getArticleId(), $this->wg->contLang->getCode());

		if ($file->exists()) {
			$file->delete('no longer needed');
		}
	}

	public function saveVisualizationData($data, $langCode) {
		wfProfileIn(__METHOD__);
		$cityId = $this->wg->cityId;
		$contentLang = $this->wg->contLang->getCode();
		$files = array('additionalImages' => array());
		$originalAdditionImagesNames = $this->getAdditionalImagesNames();

		$visualizationModel = new CityVisualization();
		$isCorpLang = $visualizationModel->isCorporateLang($langCode);


		foreach ($data as $fileType => $dataContent) {
			switch ($fileType) {
				case 'mainImageName':
					$fileName = $dataContent;
					if (strpos($fileName, UploadVisualizationImageFromFile::VISUALIZATION_MAIN_IMAGE_NAME) === false) {
						$dstFileName = UploadVisualizationImageFromFile::VISUALIZATION_MAIN_IMAGE_NAME;
						$files['mainImage'] = $this->moveTmpFile($fileName, $dstFileName);
						$files['mainImage']['modified'] = true;
					} else {
						$files['mainImage']['name'] = $fileName;
						$files['mainImage']['modified'] = false;
					}
					break;
				case 'additionalImagesNames':
					$additionalImagesNames = $dataContent;
					$files['additionalImages'] = $this->saveAdditionalFiles($additionalImagesNames);
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

		$visualizationModel->saveVisualizationData($cityId, $updateData, $langCode);

		$modifiedFiles = $this->extractModifiedFiles($files);
		if (!empty($modifiedFiles)) {
			$imageReviewState = $isCorpLang
				? ImageReviewStatuses::STATE_UNREVIEWED
				: ImageReviewStatuses::STATE_AUTO_APPROVED;
			$visualizationModel->saveImagesForReview($cityId, $langCode, $modifiedFiles, $imageReviewState);
		}

		$updateData['city_main_image'] = $files['mainImage']['name'];
		if( $files['additionalImages'] ) {
			$additionalImageNames = array();
			foreach( $files['additionalImages'] as $image ) {
				if( empty($image['deleted']) ) {
					$additionalImageNames[] = $image['name'];
				} else if ( in_array($image['deletedname'], $originalAdditionImagesNames) ) {
					$deletedFiles[$contentLang][$cityId][] = array(
						'city_id' => $cityId,
						'name' => $image['deletedname']
					);
				}
			}

			$updateData['city_images'] = json_encode($additionalImageNames);
		}

		if( !empty($deletedFiles) ) {
			if ($isCorpLang) {
				$this->createRemovalTask($deletedFiles);
			}
			$visualizationModel->deleteImagesFromReview($cityId, $langCode, $deletedFiles);
		}

		$visualizationModel->updateWikiPromoteDataCache($cityId, $langCode, $updateData);

		// clear memcache so it's visible on site after edit
		$helper = new WikiGetDataForVisualizationHelper();
		$corpWikiId = $visualizationModel->getTargetWikiId($langCode);
		// wiki info cache
		$this->wg->memc->delete($helper->getMemcKey($cityId, $langCode));
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

	protected function extractModifiedFiles($files) {
		$modifiedFiles = array();

		if (!empty($files['mainImage']['modified'])) {
			$modifiedFiles [] = $files['mainImage']['name'];
		}
		foreach ($files['additionalImages'] as $image) {
			if (!empty($image['modified'])) {
				$modifiedFiles [] = $image['name'];
			}
		}
		return $modifiedFiles;
	}

	protected function saveAdditionalFiles($additionalImagesNames) {
		$files = array();
		$keys = array();
		$allKeys = array(1,2,3,4,5,6,7,8,9);

		// find all unchanged files
		foreach($additionalImagesNames as $singleFileName) {
			if (strpos($singleFileName, UploadVisualizationImageFromFile::VISUALIZATION_ADDITIONAL_IMAGES_BASE_NAME) === 0) {
				$key = str_replace(UploadVisualizationImageFromFile::VISUALIZATION_ADDITIONAL_IMAGES_BASE_NAME . '-','',
					str_replace(UploadVisualizationImageFromFile::VISUALIZATION_ADDITIONAL_IMAGES_EXT,'',$singleFileName)
				);

				$keys []= $key;
				$files[$key] = array(
					'name' => $singleFileName,
					'modified' => false
				);
			}
		}

		// find all new files
		$availableKeys = array_diff($allKeys,$keys);
		foreach($additionalImagesNames as $singleFileName) {
			if (strpos($singleFileName, UploadVisualizationImageFromFile::VISUALIZATION_ADDITIONAL_IMAGES_BASE_NAME) === false) {
				$key = array_shift($availableKeys);
				$dstFileName = $this->getAdditionalImageName($key);

				$file = $this->moveTmpFile($singleFileName, $dstFileName);
				$files[$key] = array(
					'name' => $file['name'],
					'modified' => true
				);
			}
		}

		foreach($availableKeys as $key) {
			$dstFileName = $this->getAdditionalImageName($key);

			$this->removeImage($dstFileName);

			$files[$key] = array(
				'deletedname' => $dstFileName,
				'deleted' => true
			);
		}

		ksort($files);

		return $files;
	}

	protected function getAdditionalImageName($index) {
		return implode('-',
			array(
				UploadVisualizationImageFromFile::VISUALIZATION_ADDITIONAL_IMAGES_BASE_NAME,
				($index),
			)
		) . UploadVisualizationImageFromFile::VISUALIZATION_ADDITIONAL_IMAGES_EXT;
	}


	protected function moveTmpFile($fileName, $dstFileName) {

		$dst_file_title = Title::newFromText($dstFileName, NS_FILE);

		$temp_file = RepoGroup::singleton()->getLocalRepo()->getUploadStash()->getFile($fileName);
		$file = new LocalFile($dst_file_title, RepoGroup::singleton()->getLocalRepo());

		$file->upload($temp_file->getPath(), '', '');
		$temp_file->remove();

		$data = array(
			'url' => $file->getURL(),
			'name' => $file->getName()
		);

		return $data;
	}

	public function getImageUrl($imageFile, $requestedWidth, $requestedHeight) {
		return $this->homePageHelper->getImageUrlFromFile($imageFile, $requestedWidth, $requestedHeight);
	}

	protected function createRemovalTask($taskDeletionList) {
		if (!empty($taskDeletionList) && class_exists('PromoteImageReviewTask')) {
			$task = new PromoteImageReviewTask();
			$task->createTask(
				array(
					'deletion_list' => $taskDeletionList,
				),
				TASK_QUEUED
			);
		}
	}

	protected function checkWikiStatus($WikiId, $langCode) {
		$wikiStatus = [
			'hasImagesRejected' => false,
			'hasImagesInReview' => false,
			'isApproved' => false,
			'isAutoApproved' => false
		];

		$visualization = new CityVisualization();
		$wikiDataVisualization = $visualization->getWikiDataForVisualization($WikiId, $langCode);
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

		return $wikiStatus;
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
