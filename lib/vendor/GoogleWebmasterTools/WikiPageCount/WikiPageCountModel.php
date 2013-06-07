<?php
/**
 * User: artur
 * Date: 07.06.13
 * Time: 11:41
 */

class WikiPageCountModel {
	private $wikiId;
	private $pageCount;

	public function __construct( $wikiId, $pageCount ) {
		$this->wikiId = $wikiId;
		$this->pageCount = $pageCount;
	}

	public function setWikiId($wikiId) {
		$this->wikiId = $wikiId;
	}

	public function getWikiId() {
		return $this->wikiId;
	}

	public function setPageCount($pageCount) {
		$this->pageCount = $pageCount;
	}

	public function getPageCount() {
		return $this->pageCount;
	}
}
