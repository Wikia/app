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
		$this->homePageHelper = F::build('WikiaHomePageHelper');
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

	public function loadWikiInfo() {
		$this->wikiInfo = $this->homePageHelper->getWikiInfoForSpecialPromote($this->wg->cityId, $this->wg->contLang->getCode());
	}

	public function getWikiHeadline() {
		if (!empty($this->wikiInfo['name'])) {
			return $this->wikiInfo['name'];
		} else {
			return false;
		}
	}

	public function getWikiDesc() {
		if (!empty($this->wikiInfo['description'])) {
			return $this->wikiInfo['description'];
		} else {
			return false;
		}
	}

	public function getMainImage() {
		if (!empty($this->wikiInfo['images']) && !empty($this->wikiInfo['images'][0])) {
			$mainImageName = $this->wikiInfo['images'][0];
			return $this->homePageHelper->getImageData($mainImageName, self::LARGE_IMAGE_WIDTH, self::LARGE_IMAGE_HEIGHT);
		} else {
			return false;
		}
	}

	public function getAdditionalImages() {
		if (!empty($this->wikiInfo ['images']) && !empty($this->wikiInfo['images'][0])) {
			$images = array();
			$imagesNames = array_slice($this->wikiInfo['images'], 1);
			foreach ($imagesNames as $imageName) {
				$images[] = $this->homePageHelper->getImageData($imageName, self::SMALL_IMAGE_WIDTH, self::SMALL_IMAGE_HEIGHT);
			}
			return $images;
		} else {
			return false;
		}
	}

	public function getImage() {

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
					$status = $upload->performUpload();

					$uploadStatus["status"] = "uploadattempted";
					$uploadStatus["isGood"] = $status->isGood();
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
		if ($this->isTempImageFile($imageName)) {
			$this->removeImage($imageName);
		}
	}

	public function removeImage($imageName) {
		$title = F::build('Title', array($imageName, NS_FILE), 'newFromText');
		$file = F::build('LocalFile', array($title, RepoGroup::singleton()->getLocalRepo()));

		if ($file->exists()) {
			/* @var $file LocalFile */
			$file->delete('no longer needed');
		}
	}

	public function isTempImageFile($imageName) {
		if (strpos($imageName, 'Temp_file_') === 0) {
			return true;
		}
		return false;
	}

	public function isVisualizationFile($imageName) {
		$uploader = F::build('UploadVisualizationImageFromFile');
		if ($uploader->isVisualizationImageName($imageName)) {
			return true;
		}
		return false;
	}

	public function saveVisualizationData($data, $langCode) {
		$this->wf->ProfileIn(__METHOD__);
		$cityId = $this->wg->cityId;
		$files = array('additionalImages' => array());

		foreach ($data as $fileType => $dataContent) {

			switch ($fileType) {
				case 'mainImageName':
					$fileName = $dataContent;
					if (strpos($fileName, 'Temp_file_') === 0) {
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
			'city_description' => $description,
		);

		$visualizationModel = F::build('CityVisualization');
		$visualizationModel->saveVisualizationData($cityId, $updateData, $langCode);
		$visualizationModel->saveImagesForReview($cityId, $langCode, $files);

		$updateData['city_main_image'] = $files['mainImage']['name'];
		if ($files['additionalImages']) {
			$additionalImageNames = array();
			foreach ($files['additionalImages'] as $image) {
				$additionalImageNames []= $image['name'];
			}

			$updateData['city_images'] = json_encode($additionalImageNames);
		}

		$visualizationModel->updateWikiPromoteDataCache($cityId, $langCode, $updateData);
		$this->wf->ProfileOut(__METHOD__);
	}

	protected function saveAdditionalFiles($additionalImagesNames) {
		$files = array();

		for ($count = 0; $count < 9; $count++) {
			$key = $count + 1;
			$dstFileName = implode('-',
				array(
					UploadVisualizationImageFromFile::VISUALIZATION_ADDITIONAL_IMAGES_BASE_NAME,
					($key),
				)
			) . UploadVisualizationImageFromFile::VISUALIZATION_ADDITIONAL_IMAGES_EXT;
			if (!empty($additionalImagesNames[$count])) {
				$singleFileName = $additionalImagesNames[$count];
				if (strpos($singleFileName, 'Temp_file_') === 0) {
					$file = $this->moveTmpFile($singleFileName, $dstFileName);
					$files[$key] = array(
						'name' => $file['name'],
						'modified' => true
					);
				} else {
					$files[$key] = array(
						'name' => $singleFileName,
						'modified' => false
					);
				}
			} else {
				$this->removeImage($dstFileName);
			}
		}

		return $files;
	}

	protected function moveTmpFile($fileName, $dstFileName) {
		$temp_file_title = F::build('Title', array($fileName, NS_FILE), 'newFromText');
		$dst_file_title = F::build('Title', array($dstFileName, NS_FILE), 'newFromText');

		$temp_file = F::build('LocalFile', array($temp_file_title, RepoGroup::singleton()->getLocalRepo()));
		$file = F::build('LocalFile', array($dst_file_title, RepoGroup::singleton()->getLocalRepo()));

		$file->upload($temp_file->getPath(), '', '');
		$temp_file->delete('');

		$data = array(
			'url' => $file->getURL(),
			'name' => $file->getName()
		);

		return $data;
	}

	public function getImageUrl($imageName, $requestedWidth, $requestedHeight) {
		return $this->homePageHelper->getImageUrl($imageName, $requestedWidth, $requestedHeight);
	}

}
