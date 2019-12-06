<?php

declare( strict_types=1 );

final class WikiActivityList {
	/** @var WikiActivity[] */
	private $list;

	public function __construct( array $list ) {
		$this->list = $list;
	}

	/**
	 * @return WikiActivity[]
	 */
	public function top5Wikis(): array {
		$views = $this->list;
		usort( $views, function ( WikiActivity $left, WikiActivity $right) {
			return $left->pageViews <=> $right->pageViews;
		} );

		return array_splice($views, 0, 5 );
	}
}
