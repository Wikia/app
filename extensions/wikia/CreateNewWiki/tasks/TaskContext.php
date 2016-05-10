<?php

namespace Wikia\CreateNewWiki\Tasks;

class TaskContext {

	/** @var  \DatabaseMysqli */
	private $wikiDBW;

	/** @var  \DatabaseMysqli */
	private $sharedDBW;

	/** @var  string */
	private $starterDb;

	/** @var  string */
	private $language;

	/** @var  int */
	private $cityId;

	/**
	 * TaskContext constructor.
	 * @param string $language - language code
	 */
	public function __construct( $language ) {
		$this->language = $language;
	}

	public function getLanguage() {
		return $this->language;
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
}