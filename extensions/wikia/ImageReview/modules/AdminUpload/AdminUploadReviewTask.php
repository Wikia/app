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

		if ($oUser instanceof User) {
			$oUser->load();
			$this->mUser = $oUser->getName();
		} else {
			$this->log(__CLASS__ . ' / ' . __METHOD__ . ": Invalid user - id: " . $params->task_user_id);
			return true;
		}

		$data = unserialize($params->task_arguments);

		foreach ($data['upload_list'] as $targetWikiId => $images) {
			$this->uploadImages($targetWikiId,$images);
		}
		foreach ($data['deletion_list'] as $image) {
			$this->removeSingleImage($image);
		}
	}
	function uploadImages($targetWikiId ,$images) {
		foreach($images as $sourceWikiId => $image) {
			$this->uploadSingleImage($image['id'], $image['name'], $targetWikiId, $sourceWikiId);
		}
	}

	function uploadSingleImage($imageId, $destinationName, $targetWikiId, $sourceWikiId) {
		global $IP, $wgWikiaLocalSettingsPath;

		$retval = "";

		$sourceImageUrl = ImagesService::getImageSrc($sourceWikiId,$imageId,WikiaHomePageHelper::INTERSTITIAL_LARGE_IMAGE_WIDTH);

		if (empty($sourceImageUrl['src'])) {
			$this->log('Apparently the image is unaccessible');
			return false;
		}

		$city_url = WikiFactory::getVarValueByName("wgServer", $sourceWikiId);
		if (empty($city_url)) {
			$this->log('Apparently the server is not available via WikiFactory');
			return false;
		}

		$city_path = WikiFactory::getVarValueByName("wgScript", $targetWikiId);

		$dbname = WikiFactory::IDtoDB($sourceWikiId);
		$destinationName = $this->getNameWithWiki($destinationName,$dbname);

		$sCommand = "SERVER_ID={$targetWikiId} php $IP/maintenance/wikia/ImageReview/AdminUpload/upload.php";
		$sCommand .= "--originalimageurl=" . escapeshellarg($sourceImageUrl) . " ";
		$sCommand .= "--destimagename=" . escapeshellarg($destinationName) . " ";
		$sCommand .= "--user " . escapeshellarg( $this->mUser ) . " ";
		$sCommand .= "--conf {$wgWikiaLocalSettingsPath}";

		$actual_title = wfShellExec($sCommand, $retval);

		if ($retval) {
			$this->log('Upload error! (' . $city_url . '). Error code returned: ' . $retval . ' Error was: ' . $actual_title);
		} else {
			$this->log('Upload successful: <a href="' . $city_url . $city_path . '?title=' . wfEscapeWikiText($actual_title) . '">' . $city_url . $city_path . '?title=' . $actual_title . '</a>');
		}

		return true;
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
		$nameToRemove = $this->getNameWithWiki($imageName,$dbname);

		$sCommand = "SERVER_ID={$targetWikiId} php $IP/maintenance/wikia/ImageReview/AdminUpload/remove.php";
		$sCommand .= "--imagename=" . escapeshellarg($nameToRemove) . " ";
		$sCommand .= "--userid=" . escapeshellarg( $this->mUser ) . " ";
		$sCommand .= "--conf {$wgWikiaLocalSettingsPath}";

		$actual_title = wfShellExec($sCommand, $retval);

		$city_url = WikiFactory::getVarValueByName("wgServer", $targetWikiId);
		if (empty($city_url)) {
			$this->log('Apparently the server is not available via WikiFactory');
			return false;
		}

		$city_path = WikiFactory::getVarValueByName("wgScript", $targetWikiId);

		if ($retval) {
			$this->log('Remove error! (' . $city_url . '). Error code returned: ' . $retval . ' Error was: ' . $actual_title);
		} else {
			$this->log('Removal successful: <a href="' . $city_url . $city_path . '?title=' . wfEscapeWikiText($actual_title) . '">' . $city_url . $city_path . '?title=' . $actual_title . '</a>');
		}

		return true;
	}

	function getForm($title, $errors = false) {
	}

	function submitForm() {
	}
}
