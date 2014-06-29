<?php

/**
 * Helper class for handling images used for promotion
 *
 *
 */

class PromoImage extends WikiaObject {
	const __REVIEWED_XWIKI_CACHE_KEY = "promoimage.reviewed.%s.%s";
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

	static public function forWikiId($type, $cityId){
		$promo = new PromoImage($type);
		$promo->setCityId($cityId);
		return $promo;
	}

	public function __construct($type, $dbName = null) {
		parent::__construct();
		$this->dbName = $dbName;
		$this->index = 0;
		$this->cityId = null;
		$this->type = $type;
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
	protected function materializeCacheKey($keyTemplate){
		return sprintf(self::__REVIEWED_XWIKI_CACHE_KEY, $this->cityId, $this->type);
	}

	public function getReviewedImageName() {
		$cityId = $this->getCityId();
		$db = wfGetDB( DB_SLAVE, array(), F::app()->wg->ExternalSharedDB );

		$result = null; // name when nothing is found
		if ( !empty($cityId) ) {
			$sql = new WikiaSQL();

			$sql->cache(self::__REVIEWED_XWIKI_TTL, $this->materializeCacheKey(self::__REVIEWED_XWIKI_CACHE_KEY), true);
			$result = $sql->SELECT( "image_name" )
				->FROM( self::TABLE_CITY_VISUALIZATION_IMAGES_XWIKI )
				->WHERE( "city_id" )->EQUAL_TO( $cityId )
				->AND_( "image_type" )->EQUAL_TO( $this->type )
				->AND_( "image_review_status" )->EQUAL_TO( ImageReviewStatuses::STATE_APPROVED )
				->ORDER_BY( 'last_edited' )->DESC()->LIMIT( 1 )
				->run( $db, function ( $result ) {
					var_dump("asfasdfasdfasdfasd");
					$row = $result->fetchObject( $result );
					if ( $row && isset($row->image_name) )
					{
						return $row->image_name;
					} else {
						return null;
					}
				} );
		}
		return $result;
	}

	public function getApprovedImage() {
		$name = $this->getReviewedImageName();
		if (!empty($name)){
			return new PromoXWikiImage($name);
		} else {
			return null;
		}
	}

	public function purgeCache() {
		global $wgMemc;
		$wgMemc->delete($this->materializeCacheKey(self::__REVIEWED_XWIKI_CACHE_KEY));
	}

	public function createNewImage() {
		$img = PromoXWikiImage::createNewImage($this->getCityId());
		return $img;
	}

	public function insertImageIntoDB( PromoXWikiImage $img, $status ) {
		$img->getName();
		$cityId = $this->getCityId();

		$db = wfGetDB( DB_MASTER, array(), F::app()->wg->ExternalSharedDB );

		$sql = new WikiaSQL();
		$sql->INSERT( self::TABLE_CITY_VISUALIZATION_IMAGES_XWIKI )
			->SET( 'city_id', $cityId )
			->SET( 'city_lang_code', $this->getLangCode() )
			->SET( 'image_type', $this->getType() )
			->SET( 'image_index', $this->getIndex() )
			->SET( 'image_name', $img->getName() )
			->SET( 'last_edited', date( 'Y-m-d H:i:s' ) )
			->SET( 'image_review_status', $status );

		return $sql->run( $db );
	}

	/*
	 * @deprecated
	 */
	public function getOriginFile($cityId = null){
		if (empty($cityId)){
			$cityId =  $this->getCityId();
		}

		$f = GlobalFile::newFromText($this->getPathname(), $cityId);
		return $f;
	}
	/*
	 * @deprecated
	 */
	public function corporateFileByLang($lang){
		$wiki_id = (new WikiaCorporateModel())->getCorporateWikiIdByLang($lang);
		return GlobalFile::newFromText($this->getPathname(), $wiki_id);
	}

	public function isFileChanged(){
		return !empty($this->fileChanged);
	}

	/*
	 * @deprecated
	 */
	public function processUploadedFile($srcFileName) {
		if ($this->isValid()){ // do not upload invalid filenames
			$this->fileChanged = true;
			$dst_file_title = Title::newFromText($this->getPathname(), NS_FILE);

			$temp_file = RepoGroup::singleton()->getLocalRepo()->getUploadStash()->getFile($srcFileName);
			$file = new LocalFile($dst_file_title, RepoGroup::singleton()->getLocalRepo());

			$file->upload($temp_file->getPath(), '', '');
			$temp_file->remove();
		}
		return $this;
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
	protected function inferType($fileName, &$dbName = null){
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
