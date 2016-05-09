<?php

namespace Wikia\Paginator;

use InvalidArgumentException;

class UrlGenerator {

	/**
	 * @var string Base URL for the pagination
	 */
	private $url;

	/**
	 * @var string URL param name to store the page number
	 */
	private $pageParam;

	/**
	 * @var null|int Total number of pages (for validation purposes)
	 */
	private $pagesCount;

	public function __construct( $url, $pageParam, $pagesCount, $usePage1 = false ) {
		if ( !is_string( $url ) ) {
			throw new InvalidArgumentException( 'Expected a string for url' );
		}
		if ( !is_string( $pageParam ) ) {
			throw new InvalidArgumentException( 'Expected a string for pageParam' );
		}
		if ( !is_null( $pagesCount ) && !Validator::isNonNegativeInteger( $pagesCount ) ) {
			throw new InvalidArgumentException( 'Expected a non-negative integer for pagesCount' );
		}

		$this->url = $url;
		$this->pageParam = $pageParam;
		$this->pagesCount = intval( $pagesCount );
		$this->usePage1 = $usePage1;
	}

	public function getUrlForPage( $pageNumber ) {
		if ( !Validator::isPositiveInteger( $pageNumber ) ) {
			throw new InvalidArgumentException( 'Expected a positive integer for pageNumber' );
		}

		// Page #1 is always OK no matter how many pages there are
		if ( !$this->usePage1 && ( $pageNumber == 1 ) ) {
			return $this->url;
		}

		if ( $pageNumber > $this->pagesCount ) {
			throw new InvalidArgumentException( 'No such page available' );
		}

		if ( strchr( $this->url, '?' ) > -1 ) {
			return sprintf( '%s&%s=%d', $this->url, $this->pageParam, $pageNumber );
		}

		return sprintf( '%s?%s=%d', $this->url, $this->pageParam, $pageNumber );
	}
}
