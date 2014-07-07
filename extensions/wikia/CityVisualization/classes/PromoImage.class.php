<?php

/**
 * Helper class for handling images used for promotion
 *
 *
 */

class PromoImage extends WikiaObject {
	const __LATEST_IMAGE_WITH_STATUS_XWIKI_CACHE_KEY = "promoimage.%s.%s.state.%s";
	const __BULK_IMAGES_WITH_TYPE_TTL = 60;
	const __REVIEWED_XWIKI_TTL = 3600;
	const __MAIN_IMAGE_BASE_NAME = 'Wikia-Visualization-Main';
	const __ADDITIONAL_IMAGES_BASE_NAME = 'Wikia-Visualization-Add';
	const __IMAGES_EXT = '.png';

	const INVALID = -1;
	const MAIN = 0;
	const ADDITIONAL = 1;

	const ADDITIONAL_START = 1;
	const ADDITIONAL_END = 9;

	const TABLE_CITY_VISUALIZATION_IMAGES_XWIKI = "city_visualization_images_xwiki";
	const TABLE_CITY_VISUALIZATION_XWIKI = "city_visualization_xwiki";

	static public function listAllAdditionalTypes() {
		return range(self::ADDITIONAL_START, self::ADDITIONAL_END);
	}

	static public function fromPathname($pathString){
		$type = self::inferType($pathString, $dbName);
		return new PromoImage($type, $dbName);
	}

	/**
	 * @deprecated
	 */
	static public function oldVersionFixup($fileName, $cityId = null) {
		if (!empty($fileName)){
			$type = self::inferType($fileName);
			if ($type != self::INVALID) {
				$promo = new PromoImage($type);
				if (!empty($cityId)){
					$promo->ensureCityIdIsSet($cityId);
				}
				return $promo->getReviewedImageName();
			}
		}
		return $fileName;
	}

	static public function getImage( $fileName ) {
		if ( empty($fileName) ) {
			return null;
		} else {
			return new PromoXWikiImage( $fileName );
		}
	}

	static public function forWikiId($type, $cityId){
		$promo = new PromoImage($type);
		$promo->setCityId($cityId);
		return $promo;
	}

	static public function getApprovedImageNamesForWikiIds($wikiIds){
		$db = wfGetDB( DB_SLAVE, array(), F::app()->wg->ExternalSharedDB );

		$sql = new WikiaSQL();
		$sql->cache(PromoImage::__BULK_IMAGES_WITH_TYPE_TTL)
			->SELECT('city_id', 'image_name')
			->FROM(PromoImage::TABLE_CITY_VISUALIZATION_IMAGES_XWIKI)
			->WHERE('image_review_status')->EQUAL_TO(ImageReviewStatuses::STATE_APPROVED)
			->AND_('image_type')->EQUAL_TO(PromoImage::MAIN)
			->AND_('city_id')->IN($wikiIds);
		$resultMap = [];
		$sql->runLoop($db, function($unused, $row) use (&$resultMap) {
			$resultMap[$row->city_id] = $row->image_name;
		});
		return $resultMap;
	}

	public function __construct($type, $dbName = null) {
		parent::__construct();
		$this->dbName = $dbName;
		$this->index = 0;
		$this->cityId = null;
		$this->type = $type;
		$this->fileName = null;
		$this->fileChanged = false;
		$this->removed = false;
		$this->langCode = $this->wg->contLang->getCode();
	}

	public function isType($type){
		return $this->type === $type;
	}

	public function isAdditional(){
		return $this->isType(self::MAIN);
	}

	/*
	 * @deprecated
	 */
	public function isValid(){
		return !$this->isType(self::INVALID) and $this->isCityIdSet();
	}

	public function wasRemoved(){
		return $this->removed;
	}

	public function getType(){
		return $this->type;
	}

	public function setDBName($dbName) {
		$this->dbName = $dbName;
		$this->city = null;
		return $this;
	}

	public function getDBName(){
		if (empty($this->dbName) and !empty($this->cityId)) {
			$this->dbName = WikiFactory::IDtoDB($this->cityId);
		}
		return $this->dbName;
	}

	public function isCityIdSet(){
		return (!empty($this->dbName) or !empty($this->cityId));
	}

	public function setCityId($cityId) {
		$this->cityId = $cityId;
		$this->dbName = null;
		return $this;
	}

	public function getCityId(){
		if (empty($this->cityId) and !empty($this->dbName)){
			$this->cityId = WikiFactory::DBtoID($this->dbName);
		}
		return $this->cityId;
	}

	//only saves city id if it is not set
	public function ensureCityIdIsSet($cityId){
		if (!$this->isCityIdSet()) {
			$this->setCityId($cityId);
		}
		return $this;
	}

	protected function pathnameHelper($withDbName = true, $withExtension = true){
		if ($this->isType(self::INVALID)){
			$path = null;
		} else {
			if ($this->isType(self::MAIN)){
				$path = self::__MAIN_IMAGE_BASE_NAME;
			} else {
				$path = self::__ADDITIONAL_IMAGES_BASE_NAME . "-" . $this->type;
			}
			if ($withDbName and $this->isCityIdSet()) {
				$path .= ',' . $this->getDBName();
			}
			if ($withExtension) {
				$path .= self::__IMAGES_EXT;
			}
		}
		return $path;
	}

	/**
	 * @deprecated
	 */
	public function getPathname(){
		return $this->pathnameHelper(true, true);
	}
	protected function materializeCacheKey($keyTemplate, $additional=null){
		return sprintf($keyTemplate, $this->cityId, $this->type, $additional);
	}

	/*
	 * @deprecated
	 */
	public function getReviewedImageName($skipCache = false) {
		return $this->getLatestImageNameWithStatus(ImageReviewStatuses::STATE_APPROVED, $skipCache);
	}

	public function getLatestImageNameWithStatus($desiredStatus, $skipCache = false) {
		$cityId = $this->getCityId();
		$db = wfGetDB( DB_SLAVE, array(), F::app()->wg->ExternalSharedDB );

		$result = null; // name when nothing is found
		if ( !empty($cityId) ) {
			$cacheKey = $this->materializeCacheKey( self::__LATEST_IMAGE_WITH_STATUS_XWIKI_CACHE_KEY, $desiredStatus );
			if ( $skipCache ) {
				global $wgMemc;
				$wgMemc->delete( $cacheKey );
			}
			$sql = new WikiaSQL();
			$sql->cache( self::__REVIEWED_XWIKI_TTL, $cacheKey, true );
			$sql->SELECT( "image_name" )
				->FROM( self::TABLE_CITY_VISUALIZATION_IMAGES_XWIKI )
				->WHERE( "city_id" )->EQUAL_TO( $cityId )
				->AND_( "image_type" )->EQUAL_TO( $this->type )
				->AND_( "image_review_status" )->EQUAL_TO( $desiredStatus );

			if ( $this->isAdditional() ) {
				$sql->AND_( "image_index" )->EQUAL_TO( $this->getIndex() );
			}

			$result = $sql->ORDER_BY( 'last_edited' )->DESC()->LIMIT( 1 )
				->run( $db, function ( $result ) {
					$row = $result->fetchObject( $result );
					if ( $row && isset($row->image_name) ) {
						return $row->image_name;
					} else {
						return null;
					}
				} );
		}
		return $result;
	}

	public function getApprovedImage($skipCache = false) {
		$name = $this->getLatestImageNameWithStatus(ImageReviewStatuses::STATE_APPROVED, $skipCache);
		if (!empty($name)){
			return new PromoXWikiImage($name);
		} else {
			return null;
		}
	}

	public function createNewImage() {
		$img = PromoXWikiImage::createNewImage($this->getCityId());
		return $img;
	}

	public function insertImageIntoDB( PromoXWikiImage $img, $status = ImageReviewStatuses::STATE_UNREVIEWED) {
		$db = wfGetDB( DB_MASTER, array(), F::app()->wg->ExternalSharedDB );

		$sql = new WikiaSQL();
		$sql->INSERT( self::TABLE_CITY_VISUALIZATION_IMAGES_XWIKI )
			->SET( 'city_id', $this->getCityId() )
			->SET( 'city_lang_code', $this->getLangCode() )
			->SET( 'image_type', $this->getType() )
			->SET( 'image_index', $this->getIndex() )
			->SET( 'image_name', $img->getName() )
			->SET( 'last_edited', date( 'Y-m-d H:i:s' ) )
			->SET( 'image_review_status', $status );

		return $sql->run( $db );
	}

	public function demoteOldImages( $oldStatus, $newStatus = ImageReviewStatuses::STATE_READY_FOR_CULLING ) {
		$db = wfGetDB( DB_MASTER, array(), F::app()->wg->ExternalSharedDB );
		$exceptImageName = $this->getLatestImageNameWithStatus( $oldStatus, true );
		if ( !empty($exceptImageName) ) { //no sense demoting if nothing is found
			$sql = new WikiaSQL();
			$sql->UPDATE( self::TABLE_CITY_VISUALIZATION_IMAGES_XWIKI )
				->SET( 'image_review_status', $newStatus )
				->WHERE( 'city_id' )->EQUAL_TO( $this->getCityId() )
				->AND_( 'image_type' )->EQUAL_TO( $this->getType() )
				->AND_( 'image_index' )->EQUAL_TO( $this->getIndex() )
				->AND_( 'image_review_status' )->EQUAL_TO( $oldStatus )
				->AND_( "image_name" )->NOT_EQUAL_TO( $exceptImageName );  // do not demote this one file, some one needs to be left alive

			$sql->run( $db );
			// FIXME: possible race condition that deletes all images
		}
	}

	protected function deleteImageHelper($imageName) {
		$title = Title::newFromText($imageName, NS_FILE);
		$file = new LocalFile($title, RepoGroup::singleton()->getLocalRepo());

		$visualization = new CityVisualization();
		$visualization->removeImageFromReview($this->wg->cityId, $title->getArticleId(), $this->wg->contLang->getCode());

		if ($file->exists()) {
			$file->delete('no longer needed');
		}
	}

	protected function removalTaskHelper($imageName) {
		$visualization = new CityVisualization();

		$content_lang = $this->wg->contLang->getCode();

		//create task only for languages which have corporate wiki
		if ($visualization->isCorporateLang($content_lang)) {
			$deletion_list = array(
				$content_lang => array(
					$this->wg->cityId => array($imageName)
				)
			);
			wfRunHooks('CreatePromoImageReviewTask', ['delete', $deletion_list]);
		}
	}

	public function purgeImage() {
		$this->deleteImage();
		$this->deleteImageFromCorporate();
		return $this;
	}

	public function deleteImageFromCorporate(){
		if ($this->isCityIdSet()){
			$this->removalTaskHelper($this->getPathname());
		}
	}

	public function deleteImage() {
		$this->deleteImageHelper($this->getPathname());
		$this->removed = true;
		return $this;
	}

	public function setIndex($index) {
		$this->index = $index;
	}

	public function getIndex() {
		return $this->index;
	}

	public function setLangCode($langCode) {
		$this->langCode = $langCode;
	}

	public function getLangCode() {
		return $this->langCode;
	}

	/*
	 * @deprecated
	 */
	protected static function inferType($fileName, &$dbName = null){
		$pattern = "/^(".self::__MAIN_IMAGE_BASE_NAME.")?(".self::__ADDITIONAL_IMAGES_BASE_NAME."-(\d)?)?,?([^.]{1,})?\.?(.*)$/i";
		$type = self::INVALID;

		if (preg_match($pattern, $fileName, $matches)){
			if (!empty($matches[1])) {
				$type = self::MAIN;
			} elseif (!empty($matches[2]) and !empty($matches[3])) { // matches additional images and has a number designation
				$val = intval($matches[3]);
				if ($val >= self::ADDITIONAL_START and $val <= self::ADDITIONAL_END){
					$type = $val;
				}
			}

			$dbName = $matches[4];
		}
		return $type;
	}
}
