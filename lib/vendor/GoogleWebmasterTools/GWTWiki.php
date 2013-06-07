<?php

/**
 * Class GWTWiki
 */
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

	/**
	 * @param $wikiId
	 * @param $userId
	 * @param $uploadDate
	 * @param null $pageCount
	 */
	function __construct( $wikiId, $userId, $uploadDate, $pageCount = null ) {
		$this->setUserId( $userId );
		$this->setWikiId( $wikiId );
		$this->setUploadDate( $uploadDate );
		$this->setPageCount( $pageCount );
	}

	/**
	 * @param null|integer $userId
	 */
	public function setUserId( $userId ) {
		$this->userId = $userId === null ? null : intval( $userId );
	}

	/**
	 * @return int|null
	 */
	public function getUserId() {
		return $this->userId;
	}

	/**
	 * @param integer $wikiId
	 */
	public function setWikiId( $wikiId ) {
		$this->wikiId = intval( $wikiId );
	}

	/**
	 * @return int
	 */
	public function getWikiId() {
		return $this->wikiId;
	}

	/**
	 * @param string $uploadDate
	 */
	public function setUploadDate( $uploadDate ) {
		$this->uploadDate = $uploadDate;
	}

	/**
	 * @return string
	 */
	public function getUploadDate() {
		return $this->uploadDate;
	}

	/**
	 * @return string
	 */
	public function getDb() {
		return WikiFactory::IDtoDB( $this->wikiId );
	}

	/**
	 * @return string
	 */
	public function getUrl() {
		$wiki = WikiFactory::getWikiByID( $this->wikiId );
		return $this->normalize_site( $wiki );
	}

	/**
	 * @param $site
	 * @return string
	 */
	private function normalize_site ( $site ) {
		if (!preg_match('!^http://!', $site)) $site = 'http://'.$site;
		if (!preg_match('!/$!', $site))       $site = $site.'/';

		return $site;
	}

	/**
	 * @return int|null
	 */
	public function getPageCount() {
		return $this->pageCount;
	}

	/**
	 * @param int $pageCount
	 */
	public function setPageCount($pageCount) {
		$this->pageCount = $pageCount === null ? null : (int) $pageCount;
	}
}
