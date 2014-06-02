<?php
/**
 * PromoteImageReviewTask
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

namespace Wikia\Tasks\Tasks;

use PromoImage as PromoImage;
use WikiFactory as WikiFactory;
use WikiGetDataForVisualizationHelper as WikiGetDataForVisualizationHelper;
use CityVisualization as CityVisualization;
use ImageReviewStatuses as ImageReviewStatuses;
use F as F;
use stdClass as stdClass;

class PromoteImageReviewTask extends BaseTask {
	/** @var WikiGetDataForVisualizationHelper */
	private $helper;

	/** @var CityVisualization */
	private $model;

	/** @var array */
	private $corporatePageIds;

	public function init() {
		parent::init();

		$this->helper = new WikiGetDataForVisualizationHelper();
		$this->model = new CityVisualization();
		$this->corporatePageIds = $this->model->getVisualizationWikisIds();
	}


	public function upload($list) {
		$result = true;
		foreach ($list as $targetWikiId => $wikis) {
			$result = $this->uploadImages($targetWikiId, $wikis);
		}

		return $result;
	}

	public function delete($list) {
		$result = true;
		foreach ($list as $corpWikiLang => $wikis) {
			$result = $this->deleteImages($corpWikiLang, $wikis);
		}

		return $result;
	}

	private function finalizeImageUploadStatus($imageId, $sourceWikiId, $status){
		$db = wfGetDB(DB_MASTER, array(), F::app()->wg->ExternalSharedDB);

		(new \WikiaSQL())
			->UPDATE('city_visualization_images')
			->SET('reviewer_id', 'null', true)
				->SET('image_review_status', $status)
			->WHERE('city_id')->EQUAL_TO($sourceWikiId)
				->AND_('page_id')->EQUAL_TO($imageId)
				->AND_('image_review_status', ImageReviewStatuses::STATE_APPROVED_AND_TRANSFERRING)
			->run($db);
	}

	private function uploadImages($targetWikiId, $wikis) {
		$isError = false;
		$targetWikiLang = WikiFactory::getVarValueByName('wgLanguageCode', $targetWikiId);

		foreach($wikis as $sourceWikiId => $images) {
			$sourceWikiLang = WikiFactory::getVarValueByName('wgLanguageCode', $sourceWikiId);

			$uploadedImages = array();
			foreach ($images as $image) {
				$result = $this->uploadSingleImage($image['id'], $image['name'], $targetWikiId, $sourceWikiId);

				if ($result['status'] === 0) {
					$uploadedImages[] = ['id' => $result['id'], 'name' => $result[ 'name' ]];
					$this->finalizeImageUploadStatus($image['id'], $sourceWikiId, ImageReviewStatuses::STATE_APPROVED);
				} else {
					//on error move image back to review, so that upload could be retried
					$this->finalizeImageUploadStatus($image['id'], $sourceWikiId, ImageReviewStatuses::STATE_UNREVIEWED);
					$isError = true;
				}
			}

			if(!empty($uploadedImages) && !in_array($sourceWikiId, $this->corporatePageIds)) {
				//if images uploaded but not from import script
				$updateData = $this->getImagesToUpdateInDb($sourceWikiId, $sourceWikiLang, $uploadedImages);

				if(!empty($updateData)) {
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

		if(!empty($uploadedImages) && in_array($sourceWikiId, $this->corporatePageIds)) {
			//if images uploaded but not from import script
			//saving changes in city_visualization_images table and purging cache
			$this->addImagesToPromoteDb($targetWikiId, $targetWikiLang, $uploadedImages);
			$this->model->purgeWikiPromoteDataCache($targetWikiId, $targetWikiLang);
		}

		if( !empty($uploadedImages) ) {
			//if wikis have been added by import script or regularly by Special:Promote
			$this->model->purgeVisualizationWikisListCache($targetWikiId, $targetWikiLang);
		}

		return $isError;
	}

	public function uploadSingleImage($imageId, $destinationName, $targetWikiId, $sourceWikiId) {
		global $IP, $wgWikiaLocalSettingsPath;

		$retval = "";
		$imageTitle = \GlobalTitle::newFromId($imageId, $sourceWikiId);

		$sourceImageUrl = null;

		$sourceFile = \GlobalFile::newFromText($imageTitle->getText(), $sourceWikiId);
		if ($sourceFile->exists()){
			$sourceImageUrl = $sourceFile->getUrl();
		} else {
			$this->log('Apparently the image from city_id=' . $sourceWikiId . ' ' . $imageTitle->getText() . ' is unaccessible');
			return array('status' => 1);
		}

		$city_url = WikiFactory::getVarValueByName("wgServer", $targetWikiId);
		if( empty($city_url) ) {
			$this->log('Apparently the server for ' . $targetWikiId . ' is not available via WikiFactory');
			return array('status' => 1);
		}

		$destinationName = PromoImage::fromPathname($destinationName)->ensureCityIdIsSet($sourceWikiId)->getPathname();

		$sCommand = "SERVER_ID={$targetWikiId} php $IP/maintenance/wikia/ImageReview/PromoteImage/upload.php";
		$sCommand .= " --originalimageurl=" . escapeshellarg($sourceImageUrl);
		$sCommand .= " --destimagename=" . escapeshellarg($destinationName);
		$sCommand .= " --wikiid=" . escapeshellarg( $sourceWikiId );
		$sCommand .= " --conf {$wgWikiaLocalSettingsPath}";

		$logdata = [
			'command' => $sCommand,
			'city_url' => $city_url
		];

		$output = wfShellExec($sCommand, $retval);

		$logdata['output'] = $output;
		$logdata['retval'] = $retval;

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

	private function deleteImages($corpWikiLang, $wikis) {
		$app = F::app();
		$corpWikiId = $this->model->getTargetWikiId($corpWikiLang);

		foreach($wikis as $sourceWikiId => $images) {
			$sourceWikiLang = WikiFactory::getVarValueByName('wgLanguageCode', $sourceWikiId);

			if( !empty($images) ) {
				$removedImages = array();
				foreach($images as $imageName) {
					if (PromoImage::fromPathname($imageName)->isValid()) {
						$result = $this->removeSingleImage($corpWikiId, $imageName);

						if( $result['status'] === 0 ) {
							//almost all the time on devboxes images aren't removed because of no permissions
							//when we run maintenance/wikia/ImageReview/PromoteImage/remove.php with sudo it works
							$removedImages[] = $imageName;
						}
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

	private function removeSingleImage($targetWikiId, $imageName) {
		global $IP, $wgWikiaLocalSettingsPath;

		$retval = -1;

		$sCommand = "SERVER_ID={$targetWikiId} php $IP/maintenance/wikia/ImageReview/PromoteImage/remove.php";
		$sCommand .= " --imagename=" . escapeshellarg($imageName);
		$sCommand .= " --userid=" . escapeshellarg($this->createdBy());
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

	private function getImagesToUpdateInDb($sourceWikiId, $sourceWikiLang, $images) {
		$data = array();

		$wikiData = $this->model->getWikiData($sourceWikiId, $sourceWikiLang, $this->helper);
		$currentImages = $wikiData['images'];

		if (!empty($currentImages)) {
			foreach ($currentImages as $imageName) {
				$promoImage = PromoImage::fromPathname($imageName);
				if ($promoImage->isAdditional() && !in_array($promoImage->getPathname(), $images)) {
					$data['city_images'][] = $promoImage->getPathname();
				}
			}
		}

		foreach($images as $image) {
			$promoImage = PromoImage::fromPathname($image['name']);

			if ($promoImage->isType(PromoImage::MAIN)) {
				$data['city_main_image'] = $promoImage->getPathname();
			} elseif ($promoImage->isAdditional()) {
				$data['city_images'][] = $promoImage->getPathname();
			}
		}

		if (!empty($data['city_images'])) {
			asort($data['city_images']);
			$data['city_images'] = array_unique($data['city_images']);
			$data['city_images'] = json_encode($data['city_images']);
		}

		return $data;
	}

	private function syncAdditionalImages($sourceWikiId, $sourceWikiLang, $deletedImages) {
		$data = array();

		$wikiData = $this->model->getWikiData($sourceWikiId, $sourceWikiLang, $this->helper);
		if(!empty($wikiData['images'])) {
			$currentImages = $wikiData['images'];

			foreach($currentImages as $imageName) {
				$promoImage = PromoImage::fromPathname($imageName);
				if( $promoImage->isAdditional() && !in_array($promoImage->getPathname(), $deletedImages) ) {
					$data['city_images'][] = $promoImage->getPathname();
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
	private function addImagesToPromoteDb($targetWikiId, $targetWikiLang, $images) {
		global $wgExternalSharedDB;

		$imagesToAdd = [];

		foreach( $images as $image ) {
			$imageData = new stdClass();

			$promoImage = PromoImage::fromPathname($image['name'])->ensureCityIdIsSet($targetWikiId);

			$imageData->city_id = $targetWikiId;
			$imageData->page_id = $image['id'];
			$imageData->city_lang_code = $targetWikiLang;
			$imageData->image_index =  $promoImage->getType();
			$imageData->image_name = $promoImage->getPathname();
			$imageData->image_review_status = ImageReviewStatuses::STATE_APPROVED;
			$imageData->last_edited = date('Y-m-d H:i:s');
			$imageData->review_start = null;
			$imageData->review_end = null;
			$imageData->reviewer_id = null;

			$imagesToAdd[] = $imageData;
		}

		if (count($imagesToAdd) > 0) {
			$dbm = wfGetDB(DB_MASTER, array(), $wgExternalSharedDB);

			$deleteArray = [];
			$insertArray = [];
			foreach( $imagesToAdd as $image ) {
				$tmpArr = array();
				foreach( $image as $field => $value ) {
					$tmpArr[$field] = $value;
				}
				$insertArray[] = $tmpArr;
				$deleteArray[] = $image->page_id;
			}

			$dbm->begin();
			(new \WikiaSQL())
				->DELETE('city_visualization_images')
				->WHERE('page_id')->IN($deleteArray)
					->AND_('city_id')->EQUAL_TO($targetWikiId)
				->run($dbm);

			(new \WikiaSQL())
				->INSERT('city_visualization_images', array_keys($insertArray[0]))
				->VALUES($insertArray)
				->run($dbm);
			$dbm->commit();
		}
	}
}
