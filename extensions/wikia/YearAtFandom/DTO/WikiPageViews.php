<?php

declare( strict_types=1 );

final class WikiPageViews {
	/** @var int */
	public $wikiId;
	/** @var int */
	public $pageViews;

	public function __construct( int $wikiId, int $pageViews) {
		$this->wikiId = $wikiId;
		$this->pageViews = $pageViews;
	}
}
