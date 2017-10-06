<?php

/**
 * Helper class for handling images used for promotion
 */
class PromoImage extends WikiaObject {
	const MAIN_IMAGE_BASE_NAME = 'Wikia-Visualization-Main';
	const ADDITIONAL_IMAGES_BASE_NAME = 'Wikia-Visualization-Add';
	const IMAGES_EXT = '.png';

	const INVALID = -1;
	const MAIN = 0;
	const ADDITIONAL_START = 1;
	const ADDITIONAL_END = 9;

	private $dbName, $cityId, $type, $fileChanged, $removed;

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

	private function isType($type){
		return $this->type === $type;
	}

	private function getDBName(){
		if (empty($this->dbName) && !empty($this->cityId)) {
			$this->dbName = WikiFactory::IDtoDB($this->cityId);
		}
		return $this->dbName;
	}

	private function isCityIdSet(){
		return (!empty($this->dbName) || !empty($this->cityId));
	}

	public function setCityId($cityId) {
		$this->cityId = $cityId;
		$this->dbName = null;
		return $this;
	}

	private function getCityId(){
		if (empty($this->cityId) && !empty($this->dbName)){
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

	private function pathnameHelper($withDbName = true, $withExtension = true){
		if ($this->isType(self::INVALID)){
			$path = null;
		} else {
			if ($this->isType(self::MAIN)){
				$path = self::MAIN_IMAGE_BASE_NAME;
			} else {
				$path = self::ADDITIONAL_IMAGES_BASE_NAME . "-" . $this->type;
			}
			if ($withDbName && $this->isCityIdSet()) {
				$path .= ',' . $this->getDBName();
			}
			if ($withExtension) {
				$path .= self::IMAGES_EXT;
			}
		}
		return $path;
	}

	public function getPathname(){
		return $this->pathnameHelper(true, true);
	}

	public function getOriginFile($cityId = null){
		if (empty($cityId)){
			$cityId =  $this->getCityId();
		}

		return GlobalFile::newFromText($this->getPathname(), $cityId);
	}

	public function corporateFileByLang($lang){
		$wiki_id = (new WikiaCorporateModel())->getCorporateWikiIdByLang($lang);
		return GlobalFile::newFromText($this->getPathname(), $wiki_id);
	}

	static private function inferType( $fileName, &$dbName = null ) {
		$pattern = "/^(".self::MAIN_IMAGE_BASE_NAME.")?(".self::ADDITIONAL_IMAGES_BASE_NAME."-(\d)?)?,?([^.]{1,})?\.?(.*)$/i";
		$type = self::INVALID;

		if (preg_match($pattern, $fileName, $matches)){
			if (!empty($matches[1])) {
				$type = self::MAIN;
			} elseif (!empty($matches[2]) && !empty($matches[3])) {
				// matches additional images and has a number designation
				$val = intval($matches[3]);
				if ($val >= self::ADDITIONAL_START && $val <= self::ADDITIONAL_END){
					$type = $val;
				}
			}

			$dbName = $matches[4];
		}
		return $type;
	}
}
