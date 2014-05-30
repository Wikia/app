<?php
require_once( dirname(__FILE__) . '/../../Maintenance.php' );

class FixVisualizationImage extends Maintenance {

	public static function fetchAfflictedCityIds($langCode=null){
		$app = F::app();
		if (empty($langCode)){
			$langCode = $app->wg->ContLang->getCode();
		}
		$dbr = wfGetDB( DB_MASTER, array(), $app->wg->ExternalSharedDB );
		$city_ids = (new WikiaSQL())
			->SELECT("city_visualization.city_id")
			->FROM("city_visualization")
			->WHERE("city_visualization.city_lang_code")->EQUAL_TO($langCode)
			->AND_("city_visualization.city_id")->NOT_IN(\FluentSql\StaticSQL::RAW("( select city_id from city_visualization_images)"))
			->run($dbr, function($result){
				$res = [];
				while ($row = $result->fetchObject( $result )){
					$res []= $row->city_id;
				}
				return $res;
			});
		return $city_ids;
	}

	public static function checkIfImageIsInDB($cityId){
		$app = F::app();

		$dbr = wfGetDB( DB_MASTER, array(), $app->wg->ExternalSharedDB );
		$foundRow = (new WikiaSQL())
			->SELECT("city_visualization_images.city_id")
			->FROM(CityVisualization::CITY_VISUALIZATION_IMAGES_TABLE_NAME)
			->WHERE("city_id")->EQUAL_TO($cityId)->AND_("image_index")->EQUAL_TO(PromoImage::MAIN)

			->run($dbr, function($result){
				while ($row = $result->fetchObject( $result )){
					return $row;
				}
				return null;
			});
		return !empty($foundRow);
	}

	public static function uploadFile(PromoImage $promoImage, GlobalTitle $sourceTitle, $sourceWikiId) {

		$sourceFile = \GlobalFile::newFromText($sourceTitle->getText(), $sourceWikiId);
		if (!$sourceFile->exists()){
			echo "sourceFile doesn't exist" . PHP_EOL;
			return false;
		}
		$sourceImageUrl = $sourceFile->getUrl();

		$user = User::newFromName('WikiaBot');

		$imageData = new stdClass();
		$imageData->name = $promoImage->getPathname();
		$imageData->description = $imageData->comment = wfMessage('wikiahome-image-auto-uploaded-comment')->plain();

		$result = ImagesService::uploadImageFromUrl($sourceImageUrl, $imageData, $user);
		if (!$result['status']){
			var_dump($result['errors'], $sourceImageUrl);
		}

		return $result['status'];
	}

	public static function buildSyntheticCVImagesRow(PromoImage $promoImage, $langCode){
		$imageReviewStatus = ImageReviewStatuses::STATE_UNREVIEWED;

		$title = GlobalTitle::newFromText($promoImage->getPathname(), NS_FILE, $promoImage->cityId);

		$imageData = array();
		$imageData['city_id'] = $promoImage->getCityId();
		$imageData['page_id'] = $title->getArticleId();
		$imageData['city_lang_code'] = $langCode;
		$imageData['image_index'] = $promoImage->getType();
		$imageData['image_name'] = $promoImage->getPathname();
		$imageData['image_review_status'] = $imageReviewStatus;
		$imageData['last_edited'] = date('Y-m-d H:i:s');
		$imageData['review_start'] = null;
		$imageData['review_end'] = null;
		$imageData['reviewer_id'] = null;

		return $imageData;
	}

	public static function uploadCorrectMainImageOnCurrentWiki(PromoImage $promoImage, GlobalTitle $srcImageTitle){
		$app = F::app();
		$city_id = $app->wg->cityId;
		$success = true;

		if ($srcImageTitle->exists()){

			$newTitle = GlobalTitle::newFromText($promoImage->getPathname(), NS_FILE, $promoImage->cityId);
			if (!$newTitle->exists()) {
				echo "uploading " . $promoImage->getPathname() . PHP_EOL;
				$success = self::uploadFile($promoImage, $srcImageTitle, $city_id);
				if (!$success){
					echo "image upload failed" . PHP_EOL;
				} else {
					echo "uploaded" . PHP_EOL;
				}
			} else {
				echo "file already exists, skipping upload" . PHP_EOL;
			}

		} else {
			echo "srv image title doesnt exist " . $srcImageTitle->getText() . PHP_EOL;
		}
		return $success;
	}

	public static function targetFileExists(PromoImage $promoImage) {
		$f = GlobalFile::newFromText($promoImage->getPathname(), $promoImage->getCityId());

		return $f->exists();
	}

	public static function srcFileExists(PromoImage $targetPromoImage) {
		$promoImage = (new PromoImage($targetPromoImage->getType()));
		$f = GlobalFile::newFromText($promoImage->getPathname(), $targetPromoImage->getCityId());

		return $f->exists();
	}

	public static function saveCorrectImageRowForCurrentWiki($dbr) {
		$app = F::app();
		$cityId = $app->wg->cityId;

		$promoImage = (new PromoImage(PromoImage::MAIN))->setCityId($cityId);
		$values = self::buildSyntheticCVImagesRow($promoImage, $app->wg->ContLang->getCode());

		$sql = (new WikiaSQL())->INSERT(CityVisualization::CITY_VISUALIZATION_IMAGES_TABLE_NAME);

		foreach($values as $key => $value) {
			$sql->SET($key, $value);
		}
		$res = $sql->run($dbr);
		if ($res){
			$app->wg->memc->delete((new WikiGetDataForPromoteHelper())->getMemcKey($cityId, $app->wg->ContLang->getCode()));
		}
	}

	public function execute() {
		$app = F::app();
		global $wgHooks;
		$cityId = $app->wg->cityId;
		$promoImage = (new PromoImage(PromoImage::MAIN))->setCityId($cityId);

//		echo var_export(self::fetchAfflictedCityIds('en'), true);

		$oldMainImageName = (new PromoImage($promoImage->getCityId()))->getPathname();
		$SPECIAL_UPLOAD_VERIFICATION = "UploadVisualizationImageFromFile::UploadVerification";
		$UPLOAD_VERIFICATION_KEY = "UploadVerification";

		if (in_array($SPECIAL_UPLOAD_VERIFICATION, $wgHooks[$UPLOAD_VERIFICATION_KEY])) {
			$idx = array_search($SPECIAL_UPLOAD_VERIFICATION, $wgHooks[$UPLOAD_VERIFICATION_KEY]);
			echo "Deleting upload verification hook " . $idx . PHP_EOL;
			unset($wgHooks['UploadVerification'][$idx]);
		}

		$oldFileTitle = GlobalTitle::newFromText($oldMainImageName, NS_FILE, $cityId);

		$dbr = wfGetDB( DB_MASTER, array(), $app->wg->ExternalSharedDB );

		if (self::srcFileExists($promoImage) && !self::targetFileExists($promoImage)){
			if (self::uploadCorrectMainImageOnCurrentWiki($promoImage, $oldFileTitle)){
				self::saveCorrectImageRowForCurrentWiki($dbr);
			}
		} else {
			if (!self::checkIfImageIsInDB($cityId)){
				if (self::targetFileExists($promoImage)){
					self::saveCorrectImageRowForCurrentWiki($dbr);
				} else {
					die("target image not found" . PHP_EOL);
				}
			} else {
				die("image seems to be correctly set in db, exiting" . PHP_EOL);
			}
		}
	}
}

$maintClass = "FixVisualizationImage";
require_once( DO_MAINTENANCE );