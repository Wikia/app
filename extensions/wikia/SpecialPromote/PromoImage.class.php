<?php

/**
 * Helper function for handling images used for promotion
 *
 *
 */

class PromoImage extends WikiaObject {
	const __MAIN_IMAGE_BASE_NAME = 'Wikia-Visualization-Main';
	const __ADDITIONAL_IMAGES_BASE_NAME = 'Wikia-Visualization-Add';
	const __IMAGES_EXT = '.png';

	const MAIN = 0;
	const ADDITIONAL_1 = 1;
	const ADDITIONAL_2 = 2;
	const ADDITIONAL_3 = 3;
	const ADDITIONAL_4 = 4;
	const ADDITIONAL_5 = 5;
	const ADDITIONAL_6 = 6;
	const ADDITIONAL_7 = 7;
	const ADDITIONAL_8 = 8;
	const ADDITIONAL_9 = 9;


	static public function fromPathname($pathString, $cityId=null){
		$pattern = "/^(".self::__MAIN_IMAGE_BASE_NAME.")?(".self::__ADDITIONAL_IMAGES_BASE_NAME."-(\d)?)?,?([^.]{1,})?/i";
	
		if (preg_match($pattern, $pathString, $matches)){
			if (!empty($matches[1])) {
				$type = self::MAIN;
			} elseif (!empty($matches[2]) and !empty($matches[3])) { // matches additional images and has a number designation
				$val = intval($matches[3]);
				if ($val >= self::ADDITIONAL_1 and $val <= self::ADDITIONAL_9){
					$type = $val;
				}
			}

			$dbName = $matches[4];
		}
		if (!empty($type)){
			return new PromoImage($type, $dbName);
		}
	}

//	static public function newF
	static public function makePathname($type, $dbName = null) {
		$obj = new self($type, $dbName);
		return $obj->pathname();
	}

	public function __construct($type, $dbName = null) {
		parent::__construct();
		$this->dbName = $dbName;
		$this->type = $type;
	}

	public function isType($type){
		return $this->type === $type;
	}

	public function setDBName($dbName) {
		$this->dbName = $dbName;
		return $this;
	}

	public function setCityId($cityId) {
		$this->dbName = WikiFactory::IDtoDB( $cityId );
		return $this;
	}

	public function pathname(){
		if ($this->isType(self::MAIN)){
			$path = self::__MAIN_IMAGE_BASE_NAME;
		} else {
			$path = self::__ADDITIONAL_IMAGES_BASE_NAME . "-" . $this->type;
		}
		if (!empty($this->dbName)) {
			$path .= ',' . $this->dbName;
		}
	}

	public function corporateFileByLang($lang){
		$wiki_id = (new WikiaCorporateModel())->getCorporateWikiIdByLang($lang);
		return GlobalFile::newFromText($this->pathname(), $wiki_id);
	}
}