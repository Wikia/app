<?php
/**
 * PromoteImageReviewTask
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

namespace Wikia\Tasks\Tasks;

class PromoteImageReviewTask extends BaseTask {
	/** @var \WikiGetDataForVisualizationHelper */
	private $helper;

	/** @var \CityVisualization */
	private $model;

	/** @var array */
	private $corporatePageIds;

	public function init() {
		parent::init();

		$this->helper = new \WikiGetDataForVisualizationHelper();
		$this->model = new \CityVisualization();
		$this->corporatePageIds = $this->model->getVisualizationWikisIds();
	}

	public function upload( $targetWikiId, $wikiList ) {
		$isError = false;
		$targetWikiLang = \WikiFactory::getVarValueByName( 'wgLanguageCode', $targetWikiId );

		foreach ( $wikiList as $sourceWikiId => $images ) {
			$sourceWikiLang = \WikiFactory::getVarValueByName( 'wgLanguageCode', $sourceWikiId );

			$uploadedImages = array();
			foreach ( $images as $image ) {
				$result = $this->uploadSingleImage( $image['id'], $image['name'], $targetWikiId, $sourceWikiId );

				if ( $result['status'] === 0 ) {
					$uploadedImages[] = [
						'id' => $result['id'],
						'name' => $result['name']
					];
					$this->finalizeImageUploadStatus( $image['id'], $sourceWikiId, \ImageReviewStatuses::STATE_APPROVED );
				} else {
					// on error move image back to review, so that upload could be retried
					$this->finalizeImageUploadStatus( $image['id'], $sourceWikiId, \ImageReviewStatuses::STATE_UNREVIEWED );
					$isError = true;
				}
			}

			if ( !empty( $uploadedImages ) && !in_array( $sourceWikiId, $this->corporatePageIds ) ) {
				// if images uploaded but not from import script
				$updateData = $this->getImagesToUpdateInDb( $sourceWikiId, $sourceWikiLang, $uploadedImages );

				if ( !empty( $updateData ) ) {
					// updating city_visualization table
					$this->model->saveVisualizationData(
						$sourceWikiId,
						$updateData,
						$sourceWikiLang
					);

					// purging interstitial cache
					$memcKey = $this->helper->getMemcKey( $sourceWikiId, $sourceWikiLang );
					\F::app()->wg->Memc->set( $memcKey, null );
				}
			}
		}

		if ( !empty( $uploadedImages ) && in_array( $sourceWikiId, $this->corporatePageIds ) ) {
			// if images uploaded but not from import script
			// saving changes in city_visualization_images table and purging cache
			$this->addImagesToPromoteDb( $targetWikiId, $targetWikiLang, $uploadedImages );
			$this->model->purgeWikiPromoteDataCache( $targetWikiId, $targetWikiLang );
		}

		if ( !empty( $uploadedImages ) ) {
			// if wikis have been added by import script or regularly by Special:Promote
			$this->model->purgeVisualizationWikisListCache( $targetWikiId, $targetWikiLang );
		}

		return !$isError;
	}

	public function delete( $targetWikiId, $wikiList ) {
		$app = \F::app();

		foreach ( $wikiList as $sourceWikiId => $images ) {
			$sourceWikiLang = \WikiFactory::getVarValueByName( 'wgLanguageCode', $sourceWikiId );

			if ( !empty( $images ) ) {
				$removedImages = array();
				foreach ( $images as $imageName ) {
					if ( \PromoImage::fromPathname( $imageName )->isValid() ) {
						$result = $this->removeSingleImage( $targetWikiId, $imageName );

						if ( $result['status'] === 0 ) {
							$removedImages[] = $imageName;
						}
					}
				}
			}

			if ( !empty( $removedImages ) ) {
				$memcKey = $this->helper->getMemcKey( $sourceWikiId, $sourceWikiLang );
				$updateData = $this->syncAdditionalImages( $sourceWikiId, $sourceWikiLang, $removedImages );

				// update in db
				if ( !empty( $updateData ) ) {
					// updating city_visualization table
					$this->model->saveVisualizationData(
						$sourceWikiId,
						$updateData,
						$sourceWikiLang
					);

					// purging interstitial cache
					$app->wg->Memc->set( $memcKey, null );
				}
			}
		}

		// since an admin can't delete main image we don't purge visualization list cache
		// as it happens during uploads
		return true;
	}

	/**
	 * @param int $imageId
	 * @param string $destinationName
	 * @param int $targetWikiId
	 * @param int $sourceWikiId
	 * @return array
	 */
	public function uploadSingleImage( $imageId, $destinationName, $targetWikiId, $sourceWikiId ) {
		global $IP;

		$imageTitle = \GlobalTitle::newFromId( $imageId, $sourceWikiId );
		$sourceFile = \GlobalFile::newFromText( $imageTitle->getText(), $sourceWikiId );

		if ( $sourceFile->exists() ) {
			$sourceImageUrl = $sourceFile->getUrl();
		} else {
			$this->error( 'image is not accessible', [
				'city_id' => $sourceWikiId,
				'title' => $imageTitle->getText(),
			] );

			return ['status' => 1];
		}

		$cityUrl = \WikiFactory::getVarValueByName( "wgServer", $targetWikiId );
		if ( empty( $cityUrl ) ) {
			$this->error( 'unable to get wgServer', [
				'wiki_id' => $targetWikiId,
			] );
			return ['status' => 1];
		}

		$destinationName = \PromoImage::fromPathname( $destinationName )->ensureCityIdIsSet( $sourceWikiId )->getPathname();
		$command = "SERVER_ID={$targetWikiId} php {$IP}/maintenance/wikia/ImageReview/PromoteImage/upload.php" .
			' --originalimageurl=' . escapeshellarg( $sourceImageUrl ) .
			' --destimagename=' . escapeshellarg( $destinationName ) .
			' --wikiid=' . escapeshellarg( $sourceWikiId );

		$output = wfShellExec( $command, $exitStatus );

		if ( $exitStatus ) {
			$this->error( 'uploadSingleImage error', [
				'command' => $command,
				'city_url' => $cityUrl,
				'output' => $output,
				'exitStatus' => $exitStatus,
			] );
		} else {
			$this->info( 'uploadSingleImage success', [
				'output' => $output,
				'src_img_url' => $sourceImageUrl,
				'dest_name' => $destinationName,
			] );
		}

		$output = json_decode( $output );
		return [
			'status' => $exitStatus,
			'name' => $output->name,
			'id' => $output->id, // page_id
		];
	}

	private function removeSingleImage( $targetWikiId, $imageName ) {
		global $IP;

		$command = "SERVER_ID={$targetWikiId} php ${IP}/maintenance/wikia/ImageReview/PromoteImage/remove.php" .
			' --imagename=' . escapeshellarg( $imageName ) .
			' --userid=' . escapeshellarg( $this->createdBy );

		$output = wfShellExec( $command, $exitStatus );
		$cityUrl = \WikiFactory::getVarValueByName( 'wgServer', $targetWikiId );

		if ( empty( $cityUrl ) ) {
			$this->error( "can't find wgServer via WikiFactory", ['wiki_id' => $targetWikiId] );
			return ['status' => 1];
		}

		if ( $exitStatus != 0 ) {
			$this->error( 'removeSingleImage error', [
				'city_url' => $cityUrl,
				'status' => $exitStatus,
				'error' => $output,
			] );
		} else {
			$cityPath = \WikiFactory::getVarValueByName( 'wgScript', $targetWikiId );
			$link = "{$cityUrl}{$cityPath}?title=" . wfEscapeWikiText( $output );

			$this->info( 'removeSingleImage successful', [
				'link' => $link,
			] );
		}

		return [
			'status' => $exitStatus,
			'title' => $output,
		];
	}

	private function getImagesToUpdateInDb( $sourceWikiId, $sourceWikiLang, $images ) {
		$wikiData = $this->model->getWikiData( $sourceWikiId, $sourceWikiLang, $this->helper );
		$data = $this->getWikiCityImages( $wikiData['images'], $images );

		foreach ( $images as $image ) {
			$promoImage = \PromoImage::fromPathname( $image['name'] );

			if ( $promoImage->isType( \PromoImage::MAIN ) ) {
				$data['city_main_image'] = $promoImage->getPathname();
			} elseif ( $promoImage->isAdditional() ) {
				$data['city_images'][] = $promoImage->getPathname();
			}
		}

		if ( !empty( $data['city_images'] ) ) {
			asort( $data['city_images'] );
			$data['city_images'] = array_unique( $data['city_images'] );
			$data['city_images'] = json_encode( $data['city_images'] );
		}

		return $data;
	}

	private function syncAdditionalImages( $sourceWikiId, $sourceWikiLang, $deletedImages ) {
		$wikiData = $this->model->getWikiData( $sourceWikiId, $sourceWikiLang, $this->helper );
		$data = $this->getWikiCityImages( $wikiData['images'], $deletedImages );

		if ( isset( $data['city_images'] ) ) {
			$data['city_images'] = json_encode( $data['city_images'] );
		}

		return $data;
	}

	private function getWikiCityImages( $currentImages, $images ) {
		$data = [];

		if ( !empty( $currentImages ) ) {
			foreach ( $currentImages as $imageName ) {
				$promoImage = \PromoImage::fromPathname( $imageName );
				if ( $promoImage->isAdditional() && !in_array( $promoImage->getPathname(), $images ) ) {
					$data['city_images'][] = $promoImage->getPathname();
				}
			}
		}

		return $data;
	}

	/**
	 * @param $targetWikiId
	 * @param $targetWikiLang
	 * @param $images
	 */
	private function addImagesToPromoteDb( $targetWikiId, $targetWikiLang, $images ) {
		global $wgExternalSharedDB;

		$imagesToAdd = [];

		foreach ( $images as $image ) {
			$promoImage = \PromoImage::fromPathname( $image['name'] )->ensureCityIdIsSet( $targetWikiId );

			$imageData = new \stdClass();
			$imageData->city_id = $targetWikiId;
			$imageData->page_id = $image['id'];
			$imageData->city_lang_code = $targetWikiLang;
			$imageData->image_index =  $promoImage->getType();
			$imageData->image_name = $promoImage->getPathname();
			$imageData->image_review_status = \ImageReviewStatuses::STATE_APPROVED;
			$imageData->last_edited = date( 'Y-m-d H:i:s' );
			$imageData->review_start = null;
			$imageData->review_end = null;
			$imageData->reviewer_id = null;

			$imagesToAdd[] = $imageData;
		}

		if ( count( $imagesToAdd ) > 0 ) {
			$dbm = wfGetDB( DB_MASTER, array(), $wgExternalSharedDB );

			$deleteArray = [];
			$insertArray = [];
			foreach ( $imagesToAdd as $image ) {
				$tmpArr = array();
				foreach ( $image as $field => $value ) {
					$tmpArr[$field] = $value;
				}
				$insertArray[] = $tmpArr;
				$deleteArray[] = $image->page_id;
			}

			( new \WikiaSQL() )
				->DELETE( 'city_visualization_images' )
				->WHERE( 'page_id' )->IN( $deleteArray )
					->AND_( 'city_id' )->EQUAL_TO( $targetWikiId )
				->run( $dbm );

			( new \WikiaSQL() )
				->INSERT( 'city_visualization_images', array_keys( $insertArray[0] ) )
				->VALUES( $insertArray )
				->run( $dbm );
		}
	}

	private function finalizeImageUploadStatus( $imageId, $sourceWikiId, $status ) {
		global $wgExternalSharedDB;

		( new \WikiaSQL() )
			->UPDATE( 'city_visualization_images' )
				->SET( 'reviewer_id', 'null', true )
				->SET( 'image_review_status', $status )
			->WHERE( 'city_id' )->EQUAL_TO( $sourceWikiId )
				->AND_( 'page_id' )->EQUAL_TO( $imageId )
				->AND_( 'image_review_status' )->EQUAL_TO( \ImageReviewStatuses::STATE_APPROVED_AND_TRANSFERRING )
			->run( wfGetDB( DB_MASTER, array(), $wgExternalSharedDB ) );
	}
}
