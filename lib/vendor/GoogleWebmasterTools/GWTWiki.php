<?php

class GWTWiki {
	/**
	 * @var integer
	 */
	private $wikiId;
	/**
	 * @var null|integer
	 */
	private $userId;
	/**
	 * @var string
	 */
	private $uploadDate;
	/**
	 * @var null|integer
	 */
	private $pageCount;

	function __construct( $wikiId, $userId, $uploadDate, $pageCount = null ) {
		$this->setUserId( $userId );
		$this->setWikiId( $wikiId );
		$this->setUploadDate( $uploadDate );
	}

	public function setUserId($userId) {
		$this->userId = $userId === null ? null : intval( $userId );
	}

	public function getUserId() {
		return $this->userId;
	}

	public function setWikiId($wikiId) {
		$this->wikiId = intval( $wikiId );
	}

	public function getWikiId() {
		return $this->wikiId;
	}

	public function setUploadDate($uploadDate) {
		$this->uploadDate = $uploadDate;
	}

	public function getUploadDate() {
		return $this->uploadDate;
	}

	public function getDb() {
		return WikiFactory::IDtoDB( $this->wikiId );
	}

	public function getUrl() {
		$wiki = WikiFactory::getWikiByID( $this->wikiId );
		return $this->normalize_site( $wiki );
	}

	private function normalize_site ( $site ) {
		if (!preg_match('!^http://!', $site)) $site = 'http://'.$site;
		if (!preg_match('!/$!', $site))       $site = $site.'/';

		return $site;
	}

	public function getPageCount() {
		return $this->pageCount;
	}

	public function setPageCount($pageCount) {
		$this->pageCount = $pageCount;
	}
}
