<?php

declare( strict_types=1 );

final class ArticlePageViewsList {
	/** @var ArticlePageViews[] */
	private $list;

	public function __construct( array $list ) {
		$this->list = $list;
	}

	public static function empty(): self {
		return new self([]);
	}

	/**
	 * @return ArticlePageViews[]
	 */
	public function top5Articles(): array {
		$views = $this->list;
		usort( $views, function ( ArticlePageViews $left, ArticlePageViews $right) {
			return $right->pageViews <=> $left->pageViews;
		} );

		return array_splice($views, 0, 5 );
	}
}
