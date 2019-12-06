<?php

declare( strict_types=1 );

final class WikiActivityList implements IteratorAggregate {
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

	/**
	 * @return CategoryActivity[]
	 */
	public function top5Categories(): array {
		/** @var CategoryActivity[] $categories */
		$categories = [];

		foreach ( $this->list as $activity ) {
			if (!isset($categories[$activity->categoryId])) {
				$categories[$activity->categoryId] = new CategoryActivity(
					$activity->categoryId,
					$activity->categoryName,
					$activity->pageViews
				);
			} else {
				$categories[$activity->categoryId] = $categories[$activity->categoryId]
					->withAddedViews($activity->pageViews);
			}
		}

		usort( $categories, function ( CategoryActivity $left, CategoryActivity $right) {
			return $left->pageViews <=> $right->pageViews;
		} );

		return array_splice($categories, 0, 5 );
	}

	/**
	 * @return WikiActivity[]
	 */
	public function getIterator() {
		return new ArrayIterator( $this->list );
	}
}
