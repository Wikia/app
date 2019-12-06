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
	/** @var int */
	public $categoryId;
	/** @var string|null */
	public $wikiThumbnailUrl;

	public function __construct(
		int $wikiId,
		int $pageViews,
		int $categoryId,
		string $categoryName,
		string $wikiName,
		string $wikiUrl,
		?string $wikiThumbnailUrl
	) {
		$this->wikiId = $wikiId;
		$this->pageViews = $pageViews;
		$this->categoryName = $categoryName;
		$this->wikiName = $wikiName;
		$this->wikiUrl = $wikiUrl;
		$this->categoryId = $categoryId;
		$this->wikiThumbnailUrl = $wikiThumbnailUrl;
	}
}
