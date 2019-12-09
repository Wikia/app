<?php

declare( strict_types=1 );

final class WikiPageviewsList implements IteratorAggregate {
	/** @var WikiPageviews[] */
	private $list;

	public function __construct( array $list ) {
		$this->list = $list;
	}

	/**
	 * @return WikiPageviews[]
	 */
	public function all(): array {
		return $this->list;
	}

	/**
	 * @return WikiPageviews[]
	 */
	public function getIterator() {
		return new ArrayIterator( $this->list );
	}
}
