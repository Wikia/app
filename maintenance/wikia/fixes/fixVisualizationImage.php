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
//			->NOT_IN()-> ("(select city_id from city_visualization_images)")
//			->JOIN("city_visualization_images")->ON("city_visualization.city_id", "city_visualization_images.city_id")

//			->AND_("city_visualization_images.city_id") ->IS_NULL()
			->run($dbr, function($result){
//				var $row=null;
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
			die("sourceFile doesn't exist\n");
		}
		$sourceImageUrl = $sourceFile->getUrl();

		$user = User::newFromName('WikiaBot');

		$imageData = new stdClass();
		$imageData->name = $promoImage->getPathname();
		$imageData->description = $imageData->comment = wfMsg('wikiahome-image-auto-uploaded-comment');
		$result = ImagesService::uploadImageFromUrl($sourceImageUrl, $imageData, $user);
		var_dump($result['errors'], $sourceImageUrl);
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

	public static function uploadCorrectMainImageOnCurrentWiki(GlobalTitle $srcImageTitle){
		$app = F::app();
		$city_id = $app->wg->cityId;

		if ($srcImageTitle->exists()){
			$promoImage = (new PromoImage(PromoImage::MAIN))->setCityId($city_id);

			$newTitle = GlobalTitle::newFromText($promoImage->getPathname(), NS_FILE, $promoImage->cityId);
			if (!$newTitle->exists()) {
				echo "uploading\n";
				$success = self::uploadFile($promoImage, $srcImageTitle, $city_id);
				if (!$success){
					die("image upload failed\n");
				}
				echo "uploaded\n";
			} else {
				echo "file already exists, skipping upload\n";
			}

		} else {
			echo "srv image title doesnt exist " . $srcImageTitle->getText() . "\n";
		}
	}

	public static function correctFileExists($cityId) {
		$promoImage = (new PromoImage(PromoImage::MAIN))->setCityId($cityId);
		$f = GlobalFile::newFromText($promoImage->getPathname(), $cityId);

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
	}

	public function execute() {
		$app = F::app();
		global $wgHooks;
		$cityId = $app->wg->cityId;

		$oldMainImageName = (new PromoImage(PromoImage::MAIN))->getPathname();
//		UploadVisualizationImageFromFile::UploadVerification()
		$SPECIAL_UPLOAD_VERIFICATION = "UploadVisualizationImageFromFile::UploadVerification";
		$UPLOAD_VERIFICATION_KEY = "UploadVerification";
//		$idx = array_search($SPECIAL_UPLOAD_VERIFICATION, $app->wg->Hooks[$UPLOAD_VERIFICATION_KEY]);
		if (in_array($SPECIAL_UPLOAD_VERIFICATION, $wgHooks[$UPLOAD_VERIFICATION_KEY])) {
			$idx = array_search($SPECIAL_UPLOAD_VERIFICATION, $wgHooks[$UPLOAD_VERIFICATION_KEY]);
			echo "Deleting verification";
			unset($wgHooks['UploadVerification'][$idx]);
		}
		var_dump($idx);

		$oldFileTitle = GlobalTitle::newFromText($oldMainImageName, NS_FILE, $cityId);
		$t = GlobalFile::newFromText($oldFileTitle, $cityId);
		var_dump($t->exists());

		$dbr = wfGetDB( DB_MASTER, array(), $app->wg->ExternalSharedDB );

		if (!self::correctFileExists($cityId)){
			self::uploadCorrectMainImageOnCurrentWiki($oldFileTitle);
			self::saveCorrectImageRowForCurrentWiki($dbr);

		} else {
			if (!self::checkIfImageIsInDB($cityId)){
				self::saveCorrectImageRowForCurrentWiki($dbr);
			} else {
				die("image seems to be correctly set in db, exiting\n");
			}
		}
	}
}

$maintClass = "FixVisualizationImage";
require_once( DO_MAINTENANCE );