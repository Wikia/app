<?php

namespace Wikia\CreateNewWiki\Tasks;

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
	private $clusterDB;

	/** @var  string */
	private $wikiName;

	public function __construct( $language, $wikiName ) {
		$this->language = $language;
		$this->wikiName = $wikiName;
	}

	public function getLanguage() {
		return $this->language;
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

	public function setWikiDBW( $dbw ) {
		$this->wikiDBW = $dbw;
	}

	public function getWikiDBW() {
		return $this->wikiDBW;
	}

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

	public function getClusterDB() {
		return $this->clusterDB;
	}

	public function setClusterDB( $clusterDB ) {
		$this->clusterDB = $clusterDB;
	}
}