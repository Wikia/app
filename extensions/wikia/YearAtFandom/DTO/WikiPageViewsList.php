<?php

declare( strict_types=1 );

final class WikiPageViewsList {
	/** @var WikiPageViews[] */
	private $list;

	public function __construct( array $list ) {
		$this->list = $list;
	}

	/**
	 * @return WikiPageViews[]
	 */
	public function top5Wikis(): array {
		$views = clone $this->list;
		usort( $views, function ( WikiPageViews $left, WikiPageViews $right) {
			return $left->pageViews <=> $right->pageViews;
		} );

		return array_splice($views, 0, 5 );
	}
}
