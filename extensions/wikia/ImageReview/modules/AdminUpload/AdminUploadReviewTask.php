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

	protected $helper;
	protected $model;

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

		/** @var WikiGetDataForVisualizationHelper $this->helper  */
		$this->helper = F::build('WikiGetDataForVisualizationHelper');
		/** @var WikiGetDataForVisualizationHelper $this->model  */
		$this->model = F::build('CityVisualization');

		$data = unserialize($params->task_arguments);
		if( isset($data['upload_list']) ) {
			foreach( $data['upload_list'] as $targetWikiId => $wikis ) {
				$uploadResult = $this->uploadImages($targetWikiId, $wikis);
			}
		}

		if( isset($data['deletion_list']) ) {
			foreach( $data['deletion_list'] as $corpWikiLang => $wikis ) {
				$deleteResult = $this->removeImages($corpWikiLang, $wikis);
			}
		}

		if( !empty($uploadResult) || !empty($deleteResult) ) {
			return true;
		}

		return false;
	}

	function uploadImages($targetWikiId, $wikis) {
		$targetWikiLang = WikiFactory::getVarValueByName('wgLanguageCode', $targetWikiId);
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
				$updateData = $this->getImagesToUpdateInDb($uploadedImages);

				if( !empty($updateData) ) {
					//update in db
					$this->model->saveVisualizationData(
						$sourceWikiId,
						$updateData,
						$sourceWikiLang
					);
					$memcKey = $this->helper->getMemcKey($sourceWikiId, $sourceWikiLang);

					F::app()->wg->Memc->set($memcKey, null);
				}
			}
		}

		if( !empty($uploadedImages) ) {
			$this->model->purgeVisualizationWikisListCache($targetWikiId, $targetWikiLang);
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
			return array('status' => 1);
		} else {
			$sourceImageUrl = $sourceImageUrl['src'];
		}

		$city_url = WikiFactory::getVarValueByName("wgServer", $targetWikiId);
		if( empty($city_url) ) {
			$this->log('Apparently the server is not available via WikiFactory');
			return array('status' => 1);
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

	public function removeImages($corpWikiLang, $wikis) {
		$app = F::app();
		$corpWikiId = $this->model->getTargetWikiId($corpWikiLang);
		$removedImages = array();

		foreach($wikis as $sourceWikiId => $images) {
			$sourceWikiLang = WikiFactory::getVarValueByName('wgLanguageCode', $sourceWikiId);
			$sourceWikiDbName = WikiFactory::IDtoDB($sourceWikiId);

			if( !empty($images) ) {
				foreach($images as $image) {
					$imageName = $this->getNameWithWiki($image['name'], $sourceWikiDbName);
					$result = $this->removeSingleImage($corpWikiId, $imageName);

					if( $result['status'] === 0 || $app->wg->DevelEnvironment ) {
					//almost all the time on devboxes images aren't removed because of no permissions
					//when we run maintenance/wikia/ImageReview/AdminUpload/remove.php with sudo it works
						$removedImages[] = $imageName;
					}
				}
			}

			if( !empty($removedImages) ) {
				$memcKey = $this->helper->getMemcKey($sourceWikiId, $sourceWikiLang);
				$updateData = $this->syncAdditionalImages($sourceWikiId, $sourceWikiLang, $removedImages);

				//update in db
				if( !empty($updateData) ) {
					$this->model->saveVisualizationData(
						$sourceWikiId,
						$updateData,
						$sourceWikiLang
					);
					$app->wg->Memc->set($memcKey, null);
				}
			}
		}

		//since an admin can't delete main image we don't purge visualization list cache
		//as it happens during uploads
	}

	function removeSingleImage($targetWikiId, $imageName) {
		global $IP, $wgWikiaLocalSettingsPath;

		$retval = "";

		$sCommand = "SERVER_ID={$targetWikiId} php $IP/maintenance/wikia/ImageReview/AdminUpload/remove.php";
		$sCommand .= " --imagename=" . escapeshellarg($imageName);
		$sCommand .= " --userid=" . escapeshellarg( $this->mUser );
		$sCommand .= " --conf {$wgWikiaLocalSettingsPath}";

		$output = wfShellExec($sCommand, $retval);

		$city_url = WikiFactory::getVarValueByName("wgServer", $targetWikiId);
		if( empty($city_url) ) {
			$this->log('Apparently the server is not available via WikiFactory');
			return array('status' => 1);
		}

		$city_path = WikiFactory::getVarValueByName("wgScript", $targetWikiId);
		if( $retval ) {
			$this->log('Remove error! (' . $city_url . '). Error code returned: ' . $retval . ' Error was: ' . $output);
		}

		$this->log('Removal successful: <a href="' . $city_url . $city_path . '?title=' . wfEscapeWikiText($output) . '">' . $city_url . $city_path . '?title=' . $output . '</a>');
		return array(
			'status' => $retval,
			'title' => $output,
		);
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

	protected function syncAdditionalImages($sourceWikiId, $sourceWikiLang, $deletedImages) {
		$data = array();

		$wikiData = $this->model->getWikiData($sourceWikiId, $sourceWikiLang, $this->helper);
		$currentImages = $wikiData['images'];

		if( !empty($currentImages) ) {
			foreach($currentImages as $imageName) {
				if( $this->getImageType($imageName) === 'additional' && !in_array($imageName, $deletedImages) ) {
					$data['city_images'][] = $imageName;
				}
			}
		}

		if( isset($data['city_images']) ) {
			$data['city_images'] = json_encode($data['city_images']);
		}

		return $data;
	}

	function getForm($title, $errors = false) {
	}

	function submitForm() {
	}
}
