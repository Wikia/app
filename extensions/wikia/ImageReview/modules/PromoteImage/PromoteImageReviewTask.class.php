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

	public function upload($wikiList) {
		global $wgCityId, $wgLanguageCode;

		$isError = false;

		foreach($wikiList as $sourceWikiId => $images) {
			$sourceWikiLang = WikiFactory::getVarValueByName('wgLanguageCode', $sourceWikiId);

			$uploadedImages = array();
			foreach ($images as $image) {
				$result = $this->uploadSingleImage($image['id'], $image['name'], $wgCityId, $sourceWikiId);

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
			$this->addImagesToPromoteDb($uploadedImages);
			$this->model->purgeWikiPromoteDataCache($wgCityId, $wgLanguageCode);
		}

		if( !empty($uploadedImages) ) {
			//if wikis have been added by import script or regularly by Special:Promote
			$this->model->purgeVisualizationWikisListCache($wgCityId, $wgLanguageCode);
		}

		return !$isError;
	}

	public function delete($wikiList) {
		$app = F::app();

		foreach($wikiList as $sourceWikiId => $images) {
			$sourceWikiLang = WikiFactory::getVarValueByName('wgLanguageCode', $sourceWikiId);

			if( !empty($images) ) {
				$removedImages = array();
				foreach($images as $imageName) {
					if (PromoImage::fromPathname($imageName)->isValid()) {
						$result = $this->removeSingleImage($imageName);

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

	/**
	 * @param $imageId
	 * @param $destinationName
	 * @param mixed $_ unused variable, kept to maintain compatibility with legacy task. TODO: remove this param.
	 * @param $sourceWikiId
	 * @return array
	 * @throws \Exception
	 */
	public function uploadSingleImage($imageId, $destinationName, $_, $sourceWikiId) {
		global $wgEnableUploads, $wgServer;

		$imageTitle = \GlobalTitle::newFromId($imageId, $sourceWikiId);
		$sourceImageUrl = null;
		$sourceFile = \GlobalFile::newFromText($imageTitle->getText(), $sourceWikiId);

		if ($sourceFile->exists()){
			$sourceImageUrl = $sourceFile->getUrl();
		} else {
			$this->log('Apparently the image from city_id=' . $sourceWikiId . ' ' . $imageTitle->getText() . ' is unaccessible');
			return ['status' => 1];
		}

		$destinationName = PromoImage::fromPathname($destinationName)->ensureCityIdIsSet($sourceWikiId)->getPathname();
		$user = \User::newFromName('WikiaBot');

		if (!($user instanceof \User)) {
			return ['status' => 2];
		} elseif (empty($sourceImageUrl)) {
			return ['status' => 3];
		} elseif (empty($destinationName)) {
			return ['status' => 4];
		} elseif ($sourceWikiId <= 0) {
			return ['status' => 5];
		} elseif (empty($wgEnableUploads)) {
			return ['status' => 6];
		}

		$imageData = (object) [
			'name' => $destinationName,
			'description' => wfMsg('wikiahome-image-auto-uploaded-comment'),
			'comment' => wfMsg('wikiahome-image-auto-uploaded-comment'),
		];

		$uploadResult = \ImagesService::uploadImageFromUrl($sourceImageUrl, $imageData, $user);
		if ($uploadResult['status'] === true) {
			$result = [
				'status' => 0,
				'id' => $uploadResult['page_id'],
				'name' => $destinationName
			];
		} elseif (!empty($uploadResult['errors'][0]['message']) &&
				$uploadResult['errors'][0]['message'] === 'backend-fail-alreadyexists') {
			$result = [
				'status' => 0,
				'id' => $uploadResult['page_id'],
				'name' => $destinationName,
				'notice' => 'The file already existed. It was replaced.',
			];
		} else {
			$result = [
				'status' => 7,
			];
			$this->log("Upload error! ({$wgServer}). Error code returned: {$result['status']}");
		}

		return $result;
	}

	private function removeSingleImage($imageName) {
		global $wgEnableUploads;

		$createdBy = $this->createdBy();
		$user = empty($createdBy) ? \User::newFromName('WikiaBot') : \User::newFromId($createdBy);

		if (!($user instanceof \User)) {
			return [
				'status' => 2,
				'title' => 'Error: Could not get bot user object',
			];
		} elseif (!$user->isAllowed('delete')) {
			return [
				'status' => 3,
				'title' => 'Error: You do not have the right permissions',
			];
		} elseif (empty($imageName)) {
			return [
				'status' => 4,
				'title' => 'Error: Invalid image name',
			];
		}

		$imageTitle = \Title::newFromText($imageName, NS_FILE);
		if (!($imageTitle instanceof \Title)) {
			return [
				'status' => 5,
				'title' => 'Error: Could not get title object',
			];
		} elseif (empty($wgEnableUploads)) {
			return [
				'status' => 6,
				'title' => 'Error: File uploads disabled',
			];
		}

		$file = wfFindFile($imageTitle);
		if ($file instanceof \File && $file->exists()) {
			$status = $file->delete('automated deletion');
		} else {
			$status = [
				'ok' => false,
			];
		}

		if ($status['ok']) {
			return [
				'status' => 0,
			];
		} else {
			return [
				'status' => 6,
				'title' => 'Error: File has not been deleted',
			];
		}
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
	 * @param $images
	 */
	private function addImagesToPromoteDb($images) {
		global $wgCityId, $wgLanguageCode, $wgExternalSharedDB;

		$imagesToAdd = [];

		foreach( $images as $image ) {
			$imageData = new stdClass();

			$promoImage = PromoImage::fromPathname($image['name'])->ensureCityIdIsSet($wgCityId);

			$imageData->city_id = $wgCityId;
			$imageData->page_id = $image['id'];
			$imageData->city_lang_code = $wgLanguageCode;
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

			(new \WikiaSQL())
				->DELETE('city_visualization_images')
				->WHERE('page_id')->IN($deleteArray)
					->AND_('city_id')->EQUAL_TO($wgCityId)
				->run($dbm);

			(new \WikiaSQL())
				->INSERT('city_visualization_images', array_keys($insertArray[0]))
				->VALUES($insertArray)
				->run($dbm);
		}
	}

	private function finalizeImageUploadStatus($imageId, $sourceWikiId, $status) {
		global $wgExternalSharedDB;

		(new \WikiaSQL())
			->UPDATE('city_visualization_images')
				->SET('reviewer_id', 'null', true)
				->SET('image_review_status', $status)
			->WHERE('city_id')->EQUAL_TO($sourceWikiId)
				->AND_('page_id')->EQUAL_TO($imageId)
				->AND_('image_review_status')->EQUAL_TO(ImageReviewStatuses::STATE_APPROVED_AND_TRANSFERRING)
			->run(wfGetDB(DB_MASTER, array(), $wgExternalSharedDB));
	}
}
