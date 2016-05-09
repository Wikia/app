<?php

namespace Wikia\Paginator;

use EasyTemplate;
use Html;
use InvalidArgumentException;

/**
 *
 * @package MediaWiki
 * @subpackage Pagination
 * @author Jakub Kurcek
 * @author Piotr Gabryjeluk <rychu@wikia-inc.com>
 *
 * Object that allows auto pagination of array content
 *
 * TODO:
 *  * On any page other than the first page there should be no canonical (link rel="prev/next" is enough)
 *  * Support for indefinite pagination? 1 ... 47 48 49 _50_ 51 52 53 ...
 */
class Paginator {

	const MIN_ITEMS_PER_PAGE = 4;
	const DISPLAYED_NEIGHBOURS = 3;

	// State
	private $itemsPerPage;
	private $pagesCount;
	private $activePage = 1;
	private $url;
	private $paramName = 'page';

	/**
	 * Paginator constructor
	 *
	 * @param int $dataCount number of data to paginate or the data to paginate
	 * @param int $itemsPerPage number of items to display per page
	 * @param string $url URL to be paginated
	 * @param mixed[] $options {
	 * @type string $paramName the name of the URL param to store the page number (defaults to "page")
	 * }
	 */
	public function __construct( $dataCount, $itemsPerPage, $url = '', array $options = [] ) {
		if ( !Validator::isNonNegativeInteger( $dataCount ) ) {
			throw new InvalidArgumentException( 'Paginator: Expected a non-negative integer for dataCount' );
		}
		if ( !Validator::isPositiveInteger( $itemsPerPage ) ) {
			throw new InvalidArgumentException( 'Paginator: Expected a positive integer for itemsPerPage' );
		}
		if ( !is_string( $url ) ) {
			throw new InvalidArgumentException( 'Paginator: Expected a string for url' );
		}

		$itemsPerPage = intval( $itemsPerPage );
		$dataCount = intval( $dataCount );

		$this->itemsPerPage = max( $itemsPerPage, self::MIN_ITEMS_PER_PAGE );
		$this->pagesCount = ceil( $dataCount / $this->itemsPerPage );
		$this->url = $url;

		if ( isset( $options['paramName'] ) ) {
			if ( !is_string( $options['paramName'] ) ) {
				throw new InvalidArgumentException( 'Paginator: Expected a string for options.paramName' );
			}
			$this->paramName = $options['paramName'];
		}
	}

	/**
	 * Set the currently active page
	 *
	 * @param int $pageNumber
	 */
	public function setActivePage( $pageNumber ) {
		$pageNumber = min( $pageNumber, $this->pagesCount );
		$pageNumber = max( $pageNumber, 1 );
		$this->activePage = $pageNumber;
	}

	/**
	 * Get the current page of the passed data
	 *
	 * @param array $data data to be paginated
	 * @return array
	 */
	public function getCurrentPage( array $data ) {
		$paginatedData = array_chunk( $data, $this->itemsPerPage );

		$index = $this->activePage - 1;
		if ( isset( $paginatedData[$index] ) ) {
			return $paginatedData[$index];
		}
		return [];
	}

	/**
	 * Used by SpecialVideosHelper
	 *
	 * @return int
	 */
	public function getPagesCount() {
		return $this->pagesCount;
	}

	/**
	 * Get data needed to generate the paginator bar: an array specifying pages to link.
	 *
	 * Example:
	 *
	 * For page 1 of 1000, return: [1, 2, 3, 4, '', 1000]
	 * For page 100 of 1000, return [1, '', 97, 98, 99, 100, 101, 102, 103, '', 1000]
	 * For page 1000 of 1000, return [1, '', 997, 998, 999, 1000]
	 *
	 * Empty string represents the ellipsis, the first item is always 1, the last one is always
	 * the total number of pages.
	 *
	 * The current page is always included and up to self::DISPLAYED_NEIGHBOURS items are returned
	 * to the left and to the right of the current page.
	 *
	 * This method doesn't work very well for activePage 0 or 1, returns [1, 0] and [1, 1]
	 * respectively.
	 *
	 * @return array as described above
	 */
	private function getBarData( $url, $pageParam ) {
		$urlGenerator = new UrlGenerator( $url, $pageParam, $this->pagesCount );

		// Compute whether there's the ellipsis to the left/right of the current page
		$leftEllipsis = ( $this->activePage > self::DISPLAYED_NEIGHBOURS + 2 );
		$rightEllipsis = ( $this->activePage < $this->pagesCount - self::DISPLAYED_NEIGHBOURS - 1 );

		// Compute the range of pages between the left and right ellipsis
		// Or between the first and last page
		$leftRangeStart = max( $this->activePage - self::DISPLAYED_NEIGHBOURS, 2 );
		$rightRangeStart = min( $this->activePage + self::DISPLAYED_NEIGHBOURS, $this->pagesCount - 1 );

		$data = [ 1 ];
		$urls = [ 1 => $urlGenerator->getUrlForPage( 1 ) ];

		if ( $leftEllipsis ) {
			$data[] = '';
		}
		for ( $i = $leftRangeStart; $i <= $rightRangeStart; $i++ ) {
			$data[] = $i;
			$urls[$i] = $urlGenerator->getUrlForPage( $i );
		}
		if ( $rightEllipsis ) {
			$data[] = '';
		}

		$data[] = $this->pagesCount;
		$urls[$this->pagesCount] = $urlGenerator->getUrlForPage( $this->pagesCount );

		return [
			'pages' => $data,
			'currentPage' => $this->activePage,
			'urls' => $urls,
		];
	}

	/**
	 * Get the Paginator HTML
	 *
	 * @param string $paginatorId
	 * @return string
	 */
	public function getBarHTML( $paginatorId = null ) {
		if ( $this->pagesCount <= 1 ) {
			return '';
		}

		$data = $this->getBarData( $this->url, $this->paramName );
		$data['paginatorId'] = strip_tags( trim( stripslashes( $paginatorId ) ) );

		$template = new EasyTemplate( __DIR__ . '/../templates/' );
		$template->set_vars( $data );
		return $template->render( 'paginator' );
	}

	/**
	 * Get HTML to put to HTML <head> to allow search engines to identify next and previous pages
	 *
	 * @return string
	 */
	public function getHeadItem() {
		$links = '';

		$urlGenerator = new UrlGenerator( $this->url, $this->paramName, $this->pagesCount );

		// Has a previous page?
		if ( $this->activePage > 1 ) {
			$links .= "\t" . Html::element( 'link', [
					'rel' => 'prev',
					'href' => $urlGenerator->getUrlForPage( $this->activePage - 1 ),
				] ) . PHP_EOL;
		}

		// Has a next page?
		if ( $this->activePage < $this->pagesCount ) {
			$links .= "\t" . Html::element( 'link', [
					'rel' => 'next',
					'href' => $urlGenerator->getUrlForPage( $this->activePage + 1 ),
				] ) . PHP_EOL;
		}

		return $links;
	}

}
