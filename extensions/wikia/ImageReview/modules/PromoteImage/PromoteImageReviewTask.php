<?php

/**
 * TaskManager task to go through a list of images and delete them.
 */

class PromoteImageReviewTask extends BatchTask {
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
	protected $model; /** @var CityVisualization $model */
	protected $corporatePagesIds = array();
	protected $dbNamesToBeSkipped = array();

	function __construct($params = array()) {
		$this->mType = 'promoteimagereview';
		$this->mVisible = false; // do not show form for this task
		$this->mParams = $params;
		$this->mTTL = 86400; // 24 hours
		$this->records = 1000; // TODO: needed?
		$this->initializeSkippedWikiList();

		parent::__construct();
	}

	protected function initializeSkippedWikiList() {
		$cityVisualization = new CityVisualization();
		$corporateSites = $cityVisualization->getVisualizationWikisData();

		$dbNames = array();
		foreach ($corporateSites as $site) {
			$dbNames[] = $site['db'];
		}

		$this->dbNamesToBeSkipped = $dbNames;
	}

	function execute($params = null) {
		$this->mTaskID = $params->task_id;
		$oUser = User::newFromId($params->task_user_id);

		if( $oUser instanceof User ) {
			$oUser->load();
			$this->mUser = $oUser->getId();
		} else {
		//if task was added by import script it has WikiaBot user's id passed
			$this->log(__CLASS__ . ' / ' . __METHOD__ . ": Invalid user #1 - task_user_id: " . $params->task_user_id);
			$oUser = User::newFromName('WikiaBot');

			if( $oUser instanceof User ) {
				$oUser->load();
				$this->mUser = $oUser->getId();
			} else {
				$this->log(__CLASS__ . ' / ' . __METHOD__ . ": Invalid user #2 - task_user_id: " . $params->task_user_id);
			}

			return true;
		}

		/** @var WikiGetDataForVisualizationHelper $this->helper  */
		$this->helper = new WikiGetDataForVisualizationHelper();
		/** @var WikiGetDataForVisualizationHelper $this->model  */
		$this->model = new CityVisualization();
		$this->corporatePagesIds = $this->model->getVisualizationWikisIds();

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

	/**
	 * @desc This method uploads images from a wiki to corporate wiki (i.e. wikia.com or de.wikia.com) but also it can upload images from corporate wiki to target wikis
	 *
	 * @param $targetWikiId
	 * @param $wikis
	 * @return bool
	 */
	function uploadImages($targetWikiId, $wikis) {
		$targetWikiLang = WikiFactory::getVarValueByName('wgLanguageCode', $targetWikiId);

		foreach($wikis as $sourceWikiId => $images) {
			$sourceWikiLang = WikiFactory::getVarValueByName('wgLanguageCode', $sourceWikiId);

			$uploadedImages = array();
			foreach($images as $image) {
				$result = $this->uploadSingleImage($image['id'], $image['name'], $targetWikiId, $sourceWikiId);

				if( $result['status'] === 0 ) {
					$uploadedImages[] = array(
						'id' => $result['id'],
						'name' => $result['name'],
					);
				}
			}

			if( !empty($uploadedImages) && !in_array($sourceWikiId, $this->corporatePagesIds) ) {
			//if images uploaded but not from import script
				$updateData = $this->getImagesToUpdateInDb($sourceWikiId, $sourceWikiLang, $uploadedImages);

				if( !empty($updateData) ) {
					//updating city_visualization table
					$this->model->saveVisualizationData(
						$sourceWikiId,
						$updateData,
						$sourceWikiLang
					);

					//purging interstitial cache
					$memcKey = $this->helper->getMemcKey($sourceWikiId, $sourceWikiLang);
					F::app()->wg->Memc->set($memcKey, null);
				}
			}
		}

		if( !empty($uploadedImages) && in_array($sourceWikiId, $this->corporatePagesIds) ) {
		//if images uploaded but not from import script
			//saving changes in city_visualization_images table and purging cache
			$this->addImagesToPromoteDb($targetWikiId, $targetWikiLang, $uploadedImages);
			$this->model->purgeWikiPromoteDataCache($targetWikiId, $targetWikiLang);
		}

		if( !empty($uploadedImages) ) {
		//if wikis have been added by import script or regularly by Special:Promote
			$this->model->purgeVisualizationWikisListCache($targetWikiId, $targetWikiLang);
			return true;
		}

		return false;
	}

	function uploadSingleImage($imageId, $destinationName, $targetWikiId, $sourceWikiId) {
		global $IP, $wgWikiaLocalSettingsPath;

		$retval = "";

		$dbname = WikiFactory::IDtoDB($sourceWikiId);
		$imageTitle = GlobalTitle::newFromId($imageId, $sourceWikiId);

		$sourceImageUrl = null;
		if($imageTitle instanceof GlobalTitle) {
			$param = array(
				'action' => 'query',
				'titles' => $imageTitle->getPrefixedText(),
				'prop' => 'imageinfo',
				'iiprop' => 'url',
			);

			$response = ApiService::foreignCall($dbname, $param);

			if( !empty($response["query"]["pages"][$imageId])
				&&( !empty($response["query"]["pages"][$imageId]["imageinfo"][0]["url"])) ) {
				$sourceImageUrl = wfReplaceImageServer($response["query"]["pages"][$imageId]["imageinfo"][0]["url"]);
			}
		}

		if( empty($sourceImageUrl) ) {
			$this->log('Apparently the image ' . $dbname . '/' . $param['titles'] . ' is unaccessible');
			return array('status' => 1);
		}

		$city_url = WikiFactory::getVarValueByName("wgServer", $targetWikiId);
		if( empty($city_url) ) {
			$this->log('Apparently the server for ' . $targetWikiId . ' is not available via WikiFactory');
			return array('status' => 1);
		}

		$dbname = WikiFactory::IDtoDB($sourceWikiId);
		$destinationName = $this->getNameWithWiki($destinationName, $dbname);

		$sCommand = "SERVER_ID={$targetWikiId} php $IP/maintenance/wikia/ImageReview/PromoteImage/upload.php";
		$sCommand .= " --originalimageurl=" . escapeshellarg($sourceImageUrl);
		$sCommand .= " --destimagename=" . escapeshellarg($destinationName);
		$sCommand .= " --wikiid=" . escapeshellarg( $sourceWikiId );
		$sCommand .= " --conf {$wgWikiaLocalSettingsPath}";

		$output = wfShellExec($sCommand, $retval);

		if( $retval ) {
			$this->log('Upload error! (' . $city_url . '). Error code returned: ' . $retval . ' Error was: ' . $output);
		} else {
			$this->log('Upload successful: '.$output);
		}

		$output = json_decode($output);

		return array(
			'status' => $retval,
			'name' => $output->name,
			'id' => $output->id, //page_id
		);
	}

	public function removeImages($corpWikiLang, $wikis) {
		$app = F::app();
		$corpWikiId = $this->model->getTargetWikiId($corpWikiLang);

		foreach($wikis as $sourceWikiId => $images) {
			$sourceWikiLang = WikiFactory::getVarValueByName('wgLanguageCode', $sourceWikiId);
			$sourceWikiDbName = WikiFactory::IDtoDB($sourceWikiId);

			if( !empty($images) ) {
				$removedImages = array();
				foreach($images as $image) {
					$imageName = $this->getNameWithWiki($image['name'], $sourceWikiDbName);
					$result = $this->removeSingleImage($corpWikiId, $imageName);

					if( $result['status'] === 0 || $app->wg->DevelEnvironment ) {
					//almost all the time on devboxes images aren't removed because of no permissions
					//when we run maintenance/wikia/ImageReview/PromoteImage/remove.php with sudo it works
						$removedImages[] = $imageName;
					}
				}
			}

			if( !empty($removedImages) ) {
				$memcKey = $this->helper->getMemcKey($sourceWikiId, $sourceWikiLang);
				$updateData = $this->syncAdditionalImages($sourceWikiId, $sourceWikiLang, $removedImages);

				//update in db
				if( !empty($updateData) ) {
					//updating city_visualization table
					$this->model->saveVisualizationData(
						$sourceWikiId,
						$updateData,
						$sourceWikiLang
					);

					//purging interstitial cache
					$app->wg->Memc->set($memcKey, null);
				}
			}
		}

		//since an admin can't delete main image we don't purge visualization list cache
		//as it happens during uploads
		return true;
	}

	function removeSingleImage($targetWikiId, $imageName) {
		global $IP, $wgWikiaLocalSettingsPath;

		$retval = -1;

		$sCommand = "SERVER_ID={$targetWikiId} php $IP/maintenance/wikia/ImageReview/PromoteImage/remove.php";
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
		if( $retval != 0 ) {
			$this->log('Remove error! (' . $city_url . '). Error code returned: ' . $retval . ' Error was: ' . $output);
		} else {
			$this->log('Removal successful: <a href="' . $city_url . $city_path . '?title=' . wfEscapeWikiText($output) . '">' . $city_url . $city_path . '?title=' . $output . '</a>');
		}

		return array(
			'status' => $retval,
			'title' => $output,
		);
	}

	protected function getNameWithWiki($destinationName, $wikiDBname) {
		if( !in_array($wikiDBname, $this->dbNamesToBeSkipped) ) {
			$destinationFileNameArr = explode('.', $destinationName);
			$destinationFileExt = array_pop($destinationFileNameArr);

			array_splice($destinationFileNameArr, 1, 0, array(',', $wikiDBname));

			return implode('', $destinationFileNameArr).'.'.$destinationFileExt;
		} else {
			return $destinationName;
		}
	}

	protected function getImagesToUpdateInDb($sourceWikiId, $sourceWikiLang, $images) {
		$data = array();

		$wikiData = $this->model->getWikiData($sourceWikiId, $sourceWikiLang, $this->helper);
		$currentImages = $wikiData['images'];

		if( !empty($currentImages) ) {
			foreach($currentImages as $imageName) {
				if( $this->getImageType($imageName) === 'additional' && !in_array($imageName, $images) ) {
					$data['city_images'][] = $imageName;
				}
			}
		}

		foreach($images as $image) {
			$imageName = $image['name'];
			if( $this->getImageType($imageName) === 'main' ) {
				$data['city_main_image'] = $imageName;
			}

			if( $this->getImageType($imageName) === 'additional' ) {
				$data['city_images'][] = $imageName;
			}
		}

		if( !empty($data['city_images']) ) {
            asort($data['city_images']);
            $data['city_images'] = array_unique($data['city_images']);
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
		if(!empty($wikiData['images'])) {
			$currentImages = $wikiData['images'];

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

	/**
	 * @desc Adding data of wikis imported on wikia.com by import script
	 *
	 * @param $targetWikiId
	 * @param $targetWikiLang
	 * @param $images
	 */
	protected function addImagesToPromoteDb($targetWikiId, $targetWikiLang, $images) {
		global $wgExternalSharedDB;

		foreach( $images as $image ) {
			$imageData = new stdClass();

			$imageName = $image['name'];
			$imageIndex = 0;
			$matches = array();
			if( preg_match('/Wikia-Visualization-Add-([0-9])\.*/', $imageName, $matches) ) {
				$imageIndex = intval($matches[1]);
			}

			$imageData->city_id = $targetWikiId;
			$imageData->page_id = $image['id'];
			$imageData->city_lang_code = $targetWikiLang;
			$imageData->image_index = $imageIndex;
			$imageData->image_name = $imageName;
			$imageData->image_review_status = ImageReviewStatuses::STATE_APPROVED;
			$imageData->last_edited = date('Y-m-d H:i:s');
			$imageData->review_start = null;
			$imageData->review_end = null;
			$imageData->reviewer_id = null;

			$imagesToAdd[] = $imageData;
		}
		$dbm = wfGetDB(DB_MASTER, array(), $wgExternalSharedDB);

		$deleteArray = array();
		$insertArray = array();
		foreach( $imagesToAdd as $image ) {
			$tmpArr = array();
			foreach( $image as $field => $value ) {
				$tmpArr[$field] = $value;
			}
			$insertArray[] = $tmpArr;
			$deleteArray[] = $image->page_id;
		}

		$dbm->begin(__METHOD__);
		$sql = 'DELETE FROM city_visualization_images WHERE page_id IN (' . $dbm->makeList($deleteArray) . ') AND city_id = \'' . $targetWikiId . '\'';

		$dbm->query($sql);
		$dbm->commit(__METHOD__);

		$dbm->begin(__METHOD__);
		$dbm->insert(
			'city_visualization_images',
			$insertArray
		);
		$dbm->commit(__METHOD__);
	}

	function getForm($title, $errors = false) {
	}

	function submitForm() {
	}
}
