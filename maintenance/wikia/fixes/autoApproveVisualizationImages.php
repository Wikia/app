<?php
require_once( dirname(__FILE__) . '/../../Maintenance.php' );

class AutoApproveAlreadyApprovedImages extends Maintenance {

	public static function findApprovedAndInReviewImages($limit = 100){
		$app = F::app();
		$dbr = wfGetDB( DB_MASTER, array(), $app->wg->ExternalSharedDB );
		$city_ids = (new WikiaSQL())
			->SELECT("city_visualization_images.city_id")
			->FROM("city_visualization_images")
			->WHERE("city_visualization_images.image_review_status")->EQUAL_TO("0")
			->AND_("city_visualization_images.city_lang_code")->EQUAL_TO($app->wg->ContLang->getCode())
			->AND_("city_visualization_images.city_id")->IN(\FluentSql\StaticSQL::RAW("( select city_id from city_visualization_images WHERE image_review_status = 2 )"))
			->LIMIT($limit)
			->run($dbr, function($result){
				$res = [];
				while ($row = $result->fetchObject( $result )){
					$res []= $row->city_id;
				}
				return $res;
			});
		return $city_ids;
	}

	public static function fileExists(PromoImage $promoImage, $cityId) {
		$f = GlobalFile::newFromText($promoImage->getPathname(), $cityId);
		$title = GlobalTitle::newFromText($promoImage->getPathname(), NS_FILE, $cityId);

		return $title->exists() && $f->exists();
	}

	public function execute() {
		$app = F::app();
		$dbr = wfGetDB( DB_MASTER, array(), $app->wg->ExternalSharedDB );
		// checks if images exist in Corporate site
		$imagesToPreApprove = array_filter(self::findApprovedAndInReviewImages(), function($cityId) {
			$promoImage = (new PromoImage(PromoImage::MAIN))->setCityId($cityId);
			return self::fileExists($promoImage, 80433); //112264
		});

		$sql = (new WikiaSQL())->UPDATE('city_visualization_images')->SET('image_review_status', 2)
		->WHERE('city_id')->IN($imagesToPreApprove)
		->AND_('image_review_status')
		->EQUAL_TO("0");

		echo var_export($sql->run($dbr), true) . PHP_EOL;
	}
}

$maintClass = "AutoApproveAlreadyApprovedImages";
require_once( DO_MAINTENANCE );