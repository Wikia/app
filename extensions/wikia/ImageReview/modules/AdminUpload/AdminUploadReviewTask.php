<?php

/**
 * TaskManager task to go through a list of images and delete them.
 */

class AdminUploadReviewTask extends BatchTask {
	var $mType,
		$mVisible,
		$mArguments,
		$mMode,
		$mAdmin,
		$records,
		$title,
		$namespace,
		$mUser,
		$mUsername;

	function __construct($params = array()) {
		$this->mType = 'adminuploadreview';
		$this->mVisible = false; // do not show form for this task
		$this->mParams = $params;
		$this->mTTL = 86400; // 24 hours
		$this->records = 1000; // TODO: needed?
		parent::__construct();
	}

	function execute($params = null) {
		$this->mTaskID = $params->task_id;
		$oUser = F::build('User', array($params->task_user_id), 'newFromId');

		if( $oUser instanceof User ) {
			$oUser->load();
			$this->mUser = $oUser->getId();
		} else {
			$this->log(__CLASS__ . ' / ' . __METHOD__ . ": Invalid user - id: " . $params->task_user_id);
			return true;
		}

		$data = unserialize($params->task_arguments);
		if( isset($data['upload_list']) ) {
			foreach( $data['upload_list'] as $targetWikiId => $wikis ) {
				$uploadResult = $this->uploadImages($targetWikiId, $wikis);
			}
		}

		if( isset($data['deletion_list']) ) {
			foreach( $data['deletion_list'] as $wikis ) {
				$deleteResult = $this->removeSingleImage($wikis);
			}
		}

		if( $uploadResult || $deleteResult ) {
			return true;
		}

		return false;
	}

	function uploadImages($targetWikiId, $wikis) {
		$targetWikiLang = WikiFactory::getVarValueByName('wgLanguageCode', $targetWikiId);
		$cityVisualizationModel = F::build('CityVisualization');
		$fileNamespace = MWNamespace::getCanonicalName(NS_FILE);

		foreach($wikis as $sourceWikiId => $images) {
			$sourceWikiLang = WikiFactory::getVarValueByName('wgLanguageCode', $sourceWikiId);

			foreach($images as $image) {
				$result = $this->uploadSingleImage($image['id'], $image['name'], $targetWikiId, $sourceWikiId);

				if( $result['status'] === 0 ) {
					$uploadedImgName = str_replace( $fileNamespace.':', '', $result['title']);
					$uploadedImages[] = $uploadedImgName;
				}
			}

			if( !empty($uploadedImages) ) {
				//update in db
				$cityVisualizationModel->saveVisualizationData(
					$sourceWikiId,
					$this->getImagesToUpdateInDb($uploadedImages),
					$sourceWikiLang
				);
				$cityVisualizationModel->purgeWikiDataCache($sourceWikiId, $sourceWikiLang);
			}
		}

		if( !empty($uploadedImages) ) {
			$cityVisualizationModel->purgeVisualizationWikisListCache($targetWikiLang);
			return true;
		}

		return false;
	}

	function uploadSingleImage($imageId, $destinationName, $targetWikiId, $sourceWikiId) {
		global $IP, $wgWikiaLocalSettingsPath;

		$retval = "";

		$sourceImageUrl = ImagesService::getImageSrc($sourceWikiId, $imageId, WikiaHomePageHelper::INTERSTITIAL_LARGE_IMAGE_WIDTH);

		if( empty($sourceImageUrl['src']) ) {
			$this->log('Apparently the image is unaccessible');
			return false;
		} else {
			$sourceImageUrl = $sourceImageUrl['src'];
		}

		$city_url = WikiFactory::getVarValueByName("wgServer", $targetWikiId);
		if( empty($city_url) ) {
			$this->log('Apparently the server is not available via WikiFactory');
			return false;
		}

		$city_path = WikiFactory::getVarValueByName("wgScript", $targetWikiId);

		$dbname = WikiFactory::IDtoDB($sourceWikiId);
		$destinationName = $this->getNameWithWiki($destinationName, $dbname);

		$sCommand = "SERVER_ID={$targetWikiId} php $IP/maintenance/wikia/ImageReview/AdminUpload/upload.php";
		$sCommand .= " --originalimageurl=" . escapeshellarg($sourceImageUrl);
		$sCommand .= " --destimagename=" . escapeshellarg($destinationName);
		$sCommand .= " --userid=" . escapeshellarg( $this->mUser );
		$sCommand .= " --wikiid=" . escapeshellarg( $sourceWikiId );
		$sCommand .= " --conf {$wgWikiaLocalSettingsPath}";

		$output = wfShellExec($sCommand, $retval);

		if( $retval ) {
			$this->log('Upload error! (' . $city_url . '). Error code returned: ' . $retval . ' Error was: ' . $output);
		} else {
			$this->log('Upload successful: <a href="' . $city_url . $city_path . '/?title=' . wfEscapeWikiText($output) . '">' . $city_url . $city_path . '/?title=' . $output . '</a>');
		}

		return array(
			'status' => $retval,
			'title' => $output,
		);
	}

	function removeSingleImage($image) {
		global $IP, $wgWikiaLocalSettingsPath;

		$sourceWikiId = $image['cityId'];
		$imageName = $image['name'];

		/* @var $helper  AdminUploadReviewHelper */
		$helper = F::build('AdminUploadReviewHelper');
		$targetWikiId = $helper->getTargetWikiId($image['lang']);

		$retval = "";

		$dbname = WikiFactory::IDtoDB($sourceWikiId);
		$nameToRemove = $this->getNameWithWiki($imageName, $dbname);

		$sCommand = "SERVER_ID={$targetWikiId} php $IP/maintenance/wikia/ImageReview/AdminUpload/remove.php";
		$sCommand .= "--imagename=" . escapeshellarg($nameToRemove) . " ";
		$sCommand .= "--userid=" . escapeshellarg( $this->mUser ) . " ";
		$sCommand .= "--wikiid " . escapeshellarg( $sourceWikiId ) . " ";
		$sCommand .= "--conf {$wgWikiaLocalSettingsPath}";

		$actual_title = wfShellExec($sCommand, $retval);

		$city_url = WikiFactory::getVarValueByName("wgServer", $targetWikiId);
		if (empty($city_url)) {
			$this->log('Apparently the server is not available via WikiFactory');
			return false;
		}

		$city_path = WikiFactory::getVarValueByName("wgScript", $targetWikiId);

		if( $retval ) {
			$this->log('Remove error! (' . $city_url . '). Error code returned: ' . $retval . ' Error was: ' . $actual_title);
		} else {
			$this->log('Removal successful: <a href="' . $city_url . $city_path . '?title=' . wfEscapeWikiText($actual_title) . '">' . $city_url . $city_path . '?title=' . $actual_title . '</a>');
		}

		return true;
	}

	protected function getNameWithWiki($destinationName, $wikiDBname) {
		$destinationFileNameArr = explode('.', $destinationName);
		$destinationFileExt = array_pop($destinationFileNameArr);

		array_splice($destinationFileNameArr, 1, 0, array(',', $wikiDBname));

		return implode('', $destinationFileNameArr).'.'.$destinationFileExt;
	}

	protected function getImagesToUpdateInDb($images) {
		$data = array();

		foreach($images as $imageName) {
			if( $this->getImageType($imageName) === 'main' ) {
				$data['city_main_image'] = $imageName;
			}

			if( $this->getImageType($imageName) === 'additional' ) {
				$data['city_images'][] = $imageName;
			}
		}

		if( !empty($data['city_images']) ) {
			$data['city_images'] = json_encode($data['city_images']);
		}

		return $data;
	}

	protected function getImageType($imageName) {
		if( preg_match('/Wikia-Visualization-Add-([0-9])\.*/', $imageName) ) {
			return 'additional';
		}

		return 'main';
	}

	function getForm($title, $errors = false) {
	}

	function submitForm() {
	}
}
