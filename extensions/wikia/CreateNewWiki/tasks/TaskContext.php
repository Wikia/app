<?php

namespace Wikia\CreateNewWiki\Tasks;

use User;

class TaskContext {

	//TODO would be awesome to read it from some config
	const ACTIVE_CLUSTER = "c7";

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

	/** @var  string */
	private $vertical;

	/** @var  string */
	private $categories;

	/** @var  User */
	private $founder;

	public function __construct( $inputWikiName, $inputDomain, $language, $vertical, $categories ) {
		$this->inputWikiName = $inputWikiName;
		$this->inputDomain = $inputDomain;
		$this->language = $language;
		$this->vertical = $vertical;
		$this->categories = $categories;
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
}
