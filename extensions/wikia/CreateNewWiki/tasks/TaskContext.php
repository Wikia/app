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

	/** @var  string */
	private $description;

	/** @var  array */
	private $categories;

	/** @var string */
	private $fandomCreatorCommunityId;

	/** @var  bool */
	private $allAges;

	/** @var  string ID of Celery task responsible for setting up a new wiki */
	private $taskId;

	/** @var  string IP address of a user that is creating the wiki */
	private $ip;

	/** @var  User */
	private $founder;

	/** @var bool $shouldCreateLanguageWikiWithPath */
	private $shouldCreateLanguageWikiWithPath;

	/** @var bool $shouldCreateEnglishWikisOnFandomCom */
	private $shouldCreateEnglishWikisOnFandomCom;

	public function __construct( $params ) {
		foreach ($params as $key => $value) {
			if ( property_exists($this, $key) ) {
				$this->$key = $value;
			} else {
				throw new \InvalidArgumentException(__CLASS__ . ' does not have property ' . $key);
			}
		}
	}

	public static function newFromUserInput( $inputWikiName, $inputDomain, $language, $vertical, $description, $categories, $allAges, $taskId, $ip, $fandomCreatorCommunityId ) {
		global $wgCreateLanguageWikisWithPath, $wgCreateEnglishWikisOnFandomCom;

		return new self( [
			'inputWikiName' => $inputWikiName,
			'inputDomain' => $inputDomain,
			'language' => $language,
			'vertical' => $vertical,
			'description' => $description,
			'categories' => $categories,
			'allAges' => $allAges,
			'taskId' => $taskId,
			'ip' => $ip,
			'fandomCreatorCommunityId' => $fandomCreatorCommunityId,
			'shouldCreateLanguageWikiWithPath' => $wgCreateLanguageWikisWithPath,
			'shouldCreateEnglishWikisOnFandomCom' => $wgCreateEnglishWikisOnFandomCom
		] );
	}

	/**
	 * @return string[][]
	 */
	public function getLoggerContext() {
		$context = [
			'dbName'        => $this->dbName,
			'language'      => $this->language,
			'cityId'        => $this->cityId,
			'wikiName'      => $this->wikiName,
			'siteName'      => $this->siteName,
			'url'           => $this->url,
			'domain'        => $this->domain,
			'inputDomain'   => $this->inputDomain,
			'inputWikiName' => $this->inputWikiName,
			'vertical'      => $this->vertical,
			'categories'    => $this->categories,
		];
		if ( $this->founder instanceof User ) {
			$context['founderName'] = $this->founder->getName();
			$context['founderId'] = $this->founder->getId();
		}

		return $context;
	}

	public function getInputWikiName() {
		return $this->inputWikiName;
	}

	public function getInputDomain() {
		return $this->inputDomain;
	}

	public function setInputDomain( $inputDomain ) {
		$this->inputDomain = $inputDomain;
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

	public function setCategories($categories) {
		$this->categories = $categories;
	}

	public function getWikiName() {
		return $this->wikiName;
	}

	public function setWikiName( $wikiName ) {
		$this->wikiName = $wikiName;
	}

	/**
	 * Is this wiki for audience below 13 years old
	 *
	 * @return bool
	 */
	public function isAllAges() {
		return $this->allAges;
	}

	public function getTaskId() {
		return $this->taskId;
	}

	public function getIP() {
		return $this->ip;
	}

	// wikiDBW represents CreateWiki::newWiki->dbw

	public function getDbName() {
		return $this->dbName;
	}

	public function setDbName( $dbName ) {
		$this->dbName = $dbName;
	}

	public function getWikiDBW() {
		return $this->wikiDBW;
	}

	public function setWikiDBW( $dbw ) {
		$this->wikiDBW = $dbw;
	}

	/**
	 * Return a connection to "wikicities" shared database
	 *
	 * @return \DatabaseBase
	 */
	public function getSharedDBW() {
		return $this->sharedDBW;
	}

	public function setSharedDBW( $dbw ) {
		$this->sharedDBW = $dbw;
	}

	public function getCityId() {
		return $this->cityId;
	}

	public function setCityId( $cityId ) {
		$this->cityId = $cityId;

		// SUS-4383 | keep the city ID of the wiki we're creating in the log
		\CreateWikiTask::updateCreationLogEntry( $this->getTaskId(), [
			'city_id' => $cityId
		] );
	}

	public function getStarterDb() {
		return $this->starterDb;
	}

	public function setStarterDb( $db ) {
		$this->starterDb = $db;
	}

	public function getDescription() {
		return $this->description;
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

	/**
	 * @param string $language
	 */
	public function setLanguage( string $language ) {
		$this->language = $language;
	}

	/**
	 * @param string $ip
	 */
	public function setIp( string $ip ) {
		$this->ip = $ip;
	}

	/**
	 * @param string $taskId
	 */
	public function setTaskId( string $taskId ) {
		$this->taskId = $taskId;
	}

	/**
	 * @param string $fandomCreatorCommunityId
	 */
	public function setFandomCreatorCommunityId( string $fandomCreatorCommunityId ) {
		$this->fandomCreatorCommunityId = $fandomCreatorCommunityId;
	}

	public function isFandomCreatorCommunity() {
		return !!$this->fandomCreatorCommunityId;
	}

	public function getFandomCreatorCommunityId() {
		return $this->fandomCreatorCommunityId;
	}

	public function shouldCreateLanguageWikiWithPath(): bool {
		return $this->shouldCreateLanguageWikiWithPath;
	}

	public function shouldCreateEnglishWikisOnFandomCom(): bool {
		return $this->shouldCreateEnglishWikisOnFandomCom;
	}
}
