<?php

/**
 * Script that removes images marked for garbage collection in xwiki promote data
 *
 * @ingroup Maintenance
 */

require_once(dirname( __FILE__ ) . '/../../../../maintenance/Maintenance.php');

class XWikiImageCulling extends Maintenance {

	/**
	 * Set script options
	 */
	public function __construct() {
		parent::__construct();
		$this->mDescription = 'Clear unused promote data';
	}

	public function execute() {
		global $wgExternalSharedDB,$wgCityId;

		$query = (new \WikiaSQL())
			->SELECT('image_name')
			->FROM('city_visualization_images_xwiki')
			->WHERE('city_id')->EQUAL_TO($wgCityId)
			->AND_('image_review_status')->EQUAL_TO(ImageReviewStatuses::STATE_READY_FOR_CULLING)
			->AND_('last_edited')->LESS_THAN('NOW() - INTERVAL 2 DAY');

		$sdb = wfGetDB( DB_SLAVE, [], $wgExternalSharedDB );

		$images = $query->run($sdb, function($result) {
			$images = [];
			while($row = $result->fetchObject()) {
				$images []= $row->image_name;
			}
			return $images;
		});

		$imagesToRemoveFromDB = [];
		foreach($images as $image) {
			$promoImage = new PromoXWikiImage($image);

			if($promoImage->exists()) {
				echo 'Removing ' . $image . '...';
				try {
					$status = $promoImage->removeFile();
				} catch(Exception $e) {
					$status = false;
				}

				if($status) {
					echo ' SUCCESS' . PHP_EOL;
					$imagesToRemoveFromDB []= $image;
				} else {
					echo ' FAIL' . PHP_EOL;
				}
			} else {
				echo 'File ' . $image . ' does not exist - removing DB entry' . PHP_EOL;
				$imagesToRemoveFromDB []= $image;
			}
		}

		if(!empty($imagesToRemoveFromDB)) {
			$mdb = wfGetDB( DB_MASTER, [], $wgExternalSharedDB );
			$query = (new \WikiaSQL())
				->DELETE('city_visualization_images_xwiki')
				->WHERE('image_name')->IN($imagesToRemoveFromDB);
			$query->run($mdb);
		}
	}
}

$maintClass = 'XWikiImageCulling';
require_once(RUN_MAINTENANCE_IF_MAIN);
