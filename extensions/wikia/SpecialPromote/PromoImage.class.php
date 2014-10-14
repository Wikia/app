<?php

/**
 * Helper class for handling images used for promotion
 *
 *
 */

class PromoImage extends WikiaObject {
	const __MAIN_IMAGE_BASE_NAME = 'Wikia-Visualization-Main';
	const __ADDITIONAL_IMAGES_BASE_NAME = 'Wikia-Visualization-Add';
	const __IMAGES_EXT = '.png';

	const INVALID = -1;
	const MAIN = 0;
	const ADDITIONAL_START = 1;
	const ADDITIONAL_END = 9;

	static public function listAllAdditionalTypes() {
		return range(self::ADDITIONAL_START, self::ADDITIONAL_END);
	}

	static public function fromPathname($pathString){
		$type = self::inferType($pathString, $dbName);
		return new PromoImage($type, $dbName);
	}

	public function __construct($type, $dbName = null) {
		parent::__construct();
		$this->dbName = $dbName;
		$this->cityId = null;
		$this->type = $type;
		$this->fileChanged = false;
		$this->removed = false;
	}

	public function isType($type){
		return $this->type === $type;
	}

	public function isAdditional(){
		return in_array($this->type, self::listAllAdditionalTypes());
	}

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

	public function getPathname(){
		return $this->pathnameHelper(true, true);
	}

	public function getOriginFile(){
		$f = GlobalFile::newFromText($this->getPathname(), $this->getCityId());
		return $f;
	}

	public function corporateFileByLang($lang){
		$wiki_id = (new WikiaCorporateModel())->getCorporateWikiIdByLang($lang);
		return GlobalFile::newFromText($this->getPathname(), $wiki_id);
	}

	public function isFileChanged(){
		return !empty($this->fileChanged);
	}

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
			if (class_exists('PromoteImageReviewTask')) {
				$task = new PromoteImageReviewTask();
				$deletion_list = array(
					$content_lang => array(
						$this->wg->cityId => array($imageName)
					)
				);

				$task->createTask(
					array(
						'deletion_list' => $deletion_list
					),
					TASK_QUEUED
				);
			}
		}
	}

	public function purgeImage() {
		$this->deleteImage();
		$this->deleteImageFromCorporate();
		if ($this->isCityIdSet()){
			//for legacy compatibility attempt to remove older image path format
			$this->removalTaskHelper($this->pathnameHelper(false,true));
		}
		return $this;
	}

	public function deleteImageFromCorporate(){
		if ($this->isCityIdSet()){
			$this->removalTaskHelper($this->getPathname());
		}
	}

	public function deleteImage() {
		$this->deleteImageHelper($this->getPathname());
		if ($this->isCityIdSet()){
			//for legacy compatibility attempt to remove older image path format
			$this->deleteImageHelper($this->pathnameHelper(false,true));
		}
		$this->removed = true;
		return $this;
	}

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
