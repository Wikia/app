<?php

namespace Wikia\CreateNewWiki\Tasks;

use User;

class TaskContext {

	/** @var  \DatabaseMysqli */
	private $wikiDBW;

	/** @var  \DatabaseMysqli */
	private $sharedDBW;

	/** @var  string */
	private $dbName;

	/** @var  string */
	private $starterDb;

	/** @var  string */
	private $language;

	/** @var  int */
	private $cityId;

	/** @var  string */
	private $wikiName;

	/** @var  string */
	private $siteName;

	/** @var  string */
	private $url;

	/** @var  string */
	private $domain;

	/** @var  string */
	private $inputDomain;

	/** @var  string */
	private $inputWikiName;

	/** @var  int */
	private $vertical;

	/** @var  array */
	private $categories;

	/** @var  User */
	private $founder;

	public function __construct( $params ) {
		foreach ($params as $key => $value) {
			if ( property_exists($this, $key) ) {
				$this->$key = $value;
			} else {
				throw new \InvalidArgumentException(__CLASS__ . ' does not have property ' . $key);
			}
		}
	}

	public static function newFromUserInput( $inputWikiName, $inputDomain, $language, $vertical, $categories ) {
		return new self( [
			'inputWikiName' => $inputWikiName,
			'inputDomain' => $inputDomain,
			'language' => $language,
			'vertical' => $vertical,
			'categories' => $categories
		] );
	}

	public function getAllProperties() {
		return get_object_vars( $this );
	}

	public function getInputWikiName() {
		return $this->inputWikiName;
	}

	public function getInputDomain() {
		return $this->inputDomain;
	}

	public function getLanguage() {
		return $this->language;
	}

	public function getVertical() {
		return $this->vertical;
	}

	public function getCategories() {
		return $this->categories;
	}

	public function setWikiName( $wikiName ) {
		$this->wikiName = $wikiName;
	}

	public function getWikiName() {
		return $this->wikiName;
	}

	public function setDbName( $dbName ) {
		$this->dbName = $dbName;
	}

	public function getDbName() {
		return $this->dbName;
	}

	// wikiDBW represents CreateWiki::newWiki->dbw
	public function setWikiDBW( $dbw ) {
		$this->wikiDBW = $dbw;
	}

	public function getWikiDBW() {
		return $this->wikiDBW;
	}

	// sharedDBW represents CreateWiki::mDBW
	public function setSharedDBW( $dbw ) {
		$this->sharedDBW = $dbw;
	}

	public function getSharedDBW() {
		return $this->sharedDBW;
	}

	public function setCityId( $cityId ) {
		$this->cityId = $cityId;
	}

	public function getCityId() {
		return $this->cityId;
	}

	public function setStarterDb( $db ) {
		$this->starterDb = $db;
	}

	public function getStarterDb() {
		return $this->starterDb;
	}

	public function getSiteName() {
		return $this->siteName;
	}

	public function setSiteName($siteName) {
		$this->siteName = $siteName;
	}

	public function getURL() {
		return $this->url;
	}

	public function setURL($url) {
		$this->url = $url;
	}

	public function getDomain() {
		return $this->domain;
	}

	public function setDomain( $domain ) {
		$this->domain = $domain;
	}

	public function getFounder() {
		return $this->founder;
	}

	public function setFounder($founder) {
		$this->founder = $founder;
	}

	public function setCategories($categories) {
		$this->categories = $categories;
	}
}
