<?php

declare( strict_types=1 );

final class ArticlePageViews {
	/** @var int */
	public $articleId;
	/** @var int */
	public $wikiId;
	/** @var int */
	public $pageViews;
	/** @var string */
	public $articleName;
	/** @var string */
	public $articleUrl;

	public function __construct( int $articleId, int $wikiId, int $pageViews, string $articleName, string $articleUrl) {
		$this->wikiId = $wikiId;
		$this->pageViews = $pageViews;
		$this->articleId = $articleId;
		$this->articleName = $articleName;
		$this->articleUrl = $articleUrl;
	}
}
