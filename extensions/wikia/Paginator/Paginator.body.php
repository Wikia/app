<?php

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
 *  * On the second page of paginated content rel="prev" link should point to the page without ?page=1
 *  * On any page other than the first page there should be no canonical (link rel="prev/next" is enough)
 *  * Avoid passing the same URL to getHeadItem and getBarHTML (pass to constructor instead?)
 *  * Support for indefinite pagination? 1 ... 47 48 49 _50_ 51 52 53 ...
 *  * Move template to mustache
 *  * No checking for min items per page
 */
class Paginator {

	const MIN_ITEMS_PER_PAGE = 4;
	const DISPLAYED_NEIGHBOURS = 3;

	// State
	private $itemsPerPage;
	private $pagesCount;
	private $activePage = 1;

	// Deprecated state
	private $data = [];

	/**
	 * Creates a new Pagination object.
	 *
	 * @param int $count number of items to paginate through
	 * @param int $itemsPerPage number of items to display per page (capped to between 4 and 48)
	 * @return Paginator
	 */
	public static function newFromCount( $count, $itemsPerPage ) {
		return new Paginator( $count, $itemsPerPage );
	}

	/**
	 * @deprecated use newFromCount (only used by CrunchyRoll)
	 * @param array $data
	 * @param int $itemsPerPage
	 * @return Paginator
	 */
	public static function newFromArray( array $data, $itemsPerPage ) {
		$self = self::newFromCount( count( $data ), $itemsPerPage );
		$self->data = $data;
		return $self;
	}

	/**
	 * Paginator constructor.
	 * @param int $dataCount number of data to paginate or the data to paginate
	 * @param int $itemsPerPage number of items to display per page (capped to between 4 and 48)
	 */
	private function __construct( $dataCount, $itemsPerPage ) {
		if ( !is_int( $itemsPerPage ) ) {
			throw new InvalidArgumentException( 'Paginator: need an int for $itemsPerPage' );
		}

		if ( !is_int( $dataCount ) ) {
			throw new InvalidArgumentException( 'Paginator: need an int for $data' );
		}

		$this->itemsPerPage = max( $itemsPerPage, self::MIN_ITEMS_PER_PAGE );
		$this->pagesCount = ceil( $dataCount / $this->itemsPerPage );
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
	 * @param array|null $data data to be paginated (DEPRECATED: if null, the data passed from newFromArray is used)
	 * @return array
	 */
	public function getCurrentPage( array $data = null ) {
		// deprecated case:
		if ( is_null( $data ) ) {
			$data = $this->data;
		}

		$paginatedData = array_chunk( $data, $this->itemsPerPage );

		$index = $this->activePage - 1;
		if ( isset( $paginatedData[$index] ) ) {
			return $paginatedData[$index];
		}
		return [];
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
	private function getBarData() {
		// Compute whether there's the ellipsis to the left/right of the current page
		$leftEllipsis = ( $this->activePage > self::DISPLAYED_NEIGHBOURS + 2 );
		$rightEllipsis = ( $this->activePage < $this->pagesCount - self::DISPLAYED_NEIGHBOURS - 1 );

		// Compute the range of pages between the left and right ellipsis
		// Or between the first and last page
		$leftRangeStart = max( $this->activePage - self::DISPLAYED_NEIGHBOURS, 2 );
		$rightRangeStart = min( $this->activePage + self::DISPLAYED_NEIGHBOURS, $this->pagesCount - 1 );

		$data = [ 1 ];

		if ( $leftEllipsis ) {
			$data[] = '';
		}
		for ( $i = $leftRangeStart; $i <= $rightRangeStart; $i++ ) {
			$data[] = $i;
		}
		if ( $rightEllipsis ) {
			$data[] = '';
		}

		$data[] = $this->pagesCount;

		return [
			'pages' => $data,
			'currentPage' => $this->activePage
		];
	}

	public function getBarHTML( $url, $paginatorId = false ) {
		if ( $this->pagesCount <= 1 ) {
			return '';
		}

		$data = $this->getBarData();
		$data['paginatorId'] = strip_tags( trim( stripslashes( $paginatorId ) ) );
		$data['url'] = $url;

		$template = new EasyTemplate( __DIR__ . '/templates/' );
		$template->set_vars( $data );
		return $template->render( 'paginator' );
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
	 * Get HTML to put to HTML <head> to allow search engines to identify next and previous pages
	 *
	 * @param $url the URL template. We'll replace '%s' with the page number
	 * @return string
	 */
	public function getHeadItem( $url ) {
		$links = '';

		// Has a previous page?
		if ( $this->activePage > 1 ) {
			$links .= "\t" . Html::element( 'link', [
					'rel' => 'prev',
					'href' => str_replace( '%s', $this->activePage - 1, $url )
				] ) . PHP_EOL;
		}

		// Has a next page?
		if ( $this->activePage < $this->pagesCount ) {
			$links .= "\t" . Html::element( 'link', [
					'rel' => 'next',
					'href' => str_replace( '%s', $this->activePage + 1, $url )
				] ) . PHP_EOL;
		}

		return $links;
	}
}
