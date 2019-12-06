<?php

declare( strict_types=1 );

final class ArticlePageViewsList {
	/** @var ArticlePageViews[] */
	private $list;

	public function __construct( array $list ) {
		$this->list = $list;
	}

	/**
	 * @return ArticlePageViews[]
	 */
	public function top5Articles(): array {
		$views = $this->list;
		usort( $views, function ( ArticlePageViews $left, ArticlePageViews $right) {
			return $left->pageViews <=> $right->pageViews;
		} );

		return array_splice($views, 0, 5 );
	}
}
