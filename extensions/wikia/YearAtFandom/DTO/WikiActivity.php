<?php

declare( strict_types=1 );

final class WikiActivity {
	/** @var int */
	public $wikiId;
	/** @var string */
	private $wikiDBName;
	/** @var string */
	public $wikiName;
	/** @var string */
	public $wikiUrl;
	/** @var string|null */
	public $wikiThumbnailUrl;
	/** @var int */
	public $pageViews;
	/** @var string */
	public $categoryName;
	/** @var int */
	public $categoryId;

	public function __construct(
		int $wikiId,
		string $wikiDBName,
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
		$this->wikiDBName = $wikiDBName;
	}

	public function wikiDBName(): string {
		return $this->wikiDBName;
	}
}
