<?php

declare( strict_types=1 );

final class WikiActivity {
	/** @var int */
	public $wikiId;
	/** @var int */
	public $pageViews;
	/** @var string */
	public $categoryName;
	/** @var string */
	public $wikiName;
	/** @var string */
	public $wikiUrl;

	public function __construct( int $wikiId, int $pageViews, string $categoryName, string $wikiName, string $wikiUrl) {
		$this->wikiId = $wikiId;
		$this->pageViews = $pageViews;
		$this->categoryName = $categoryName;
		$this->wikiName = $wikiName;
		$this->wikiUrl = $wikiUrl;
	}
}
