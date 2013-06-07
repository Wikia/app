<?php
/**
 * User: artur
 * Date: 07.06.13
 * Time: 11:41
 */

class WikiPageCountModel {
	/** @var int */
	private $wikiId;
	/** @var int */
	private $pageCount;

	/**
	 * @param int $wikiId
	 * @param int $pageCount
	 */
	public function __construct( $wikiId, $pageCount ) {
		$this->wikiId = (int) $wikiId;
		$this->pageCount = (int) $pageCount;
	}

	/**
	 * @param $wikiId
	 */
	public function setWikiId($wikiId) {
		$this->wikiId = $wikiId;
	}

	/**
	 * @return int
	 */
	public function getWikiId() {
		return $this->wikiId;
	}

	/**
	 * @param $pageCount
	 */
	public function setPageCount($pageCount) {
		$this->pageCount = (int) $pageCount;
	}

	/**
	 * @return int
	 */
	public function getPageCount() {
		return $this->pageCount;
	}
}
