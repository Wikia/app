<?php

declare( strict_types=1 );


final class CategoryActivity {
	/** @var int */
	public $categoryId;
	/** @var string */
	public $categoryName;
	/** @var int */
	public $pageViews;

	public function __construct( int $categoryId, string $categoryName, int $pageViews ) {
		$this->categoryName = $categoryName;
		$this->pageViews = $pageViews;
		$this->categoryId = $categoryId;
	}

	public function withAddedViews( int $additionalViews ): self {
		return new self(
			$this->categoryId,
			$this->categoryName,
			$this->pageViews + $additionalViews
		);
	}
}
