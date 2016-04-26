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
 *  * No checking for max or min items per page
 */
class Paginator {

	const MIN_ITEMS_PER_PAGE = 4;
	const DISPLAYED_NEIGHBOURS = 3;

	// State
	private $itemsPerPage = 8;
	private $pagesCount = 0;
	private $activePage = 1;

	// Deprecated state
	private $paginatedData = [];

	/**
	 * Creates a new Pagination object.
	 *
	 * @param int $count number of items to paginate through
	 * @param int $itemsPerPage number of items to display per page (capped to between 4 and 48)
	 * @param int $maxItemsPerPage override the maximum of 48 items per page
	 * @return Paginator
	 */
	public static function newFromCount( $count, $itemsPerPage, $maxItemsPerPage = 48 ) {
		return new Paginator( $count, $itemsPerPage, $maxItemsPerPage );
	}

	/**
	 * @deprecated use newFromCount
	 * @param array $aData
	 * @param int $itemsPerPage
	 * @param int $maxItemsPerPage
	 * @return Paginator
	 */
	public static function newFromArray( array $aData, $itemsPerPage, $maxItemsPerPage = 48 ) {
		return self::newFromCount( $aData, $itemsPerPage, $maxItemsPerPage );
	}

	/**
	 * Paginator constructor.
	 * @param int|array $data number of data to paginate or the data to paginate
	 * @param int $itemsPerPage number of items to display per page (capped to between 4 and 48)
	 * @param int $maxItemsPerPage override the maximum of 48 items per page
	 */
	private function __construct( $data, $itemsPerPage, $maxItemsPerPage ) {
		if ( !is_int( $itemsPerPage ) ) {
			throw new InvalidArgumentException( 'Paginator: need an int for $itemsPerPage' );
		}

		if ( !is_int( $maxItemsPerPage ) ) {
			throw new InvalidArgumentException( 'Paginator: need an int for $maxItemsPerPage' );
		}

		if ( !is_array( $data ) && !is_int( $data ) ) {
			throw new InvalidArgumentException( 'Paginator: need an int or array for $data' );
		}

		$itemsPerPage = min( $itemsPerPage, $maxItemsPerPage );
		$itemsPerPage = max( $itemsPerPage, self::MIN_ITEMS_PER_PAGE );
		$this->itemsPerPage = $itemsPerPage;

		if ( is_array( $data ) ) {
			$dataCount = count( $data );
		} else {
			$dataCount = $data;
		}

		$this->pagesCount = ceil( $dataCount / $this->itemsPerPage );

		if ( is_array( $data ) ) {
			// deprecated case
			if ( count( $data ) > 0 ) {
				$this->paginatedData = array_chunk( $data, $this->itemsPerPage );
			} else {
				$this->paginatedData = [];
			}
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
	 * @param array|null $aData data to be paginated (DEPRECATED: if null, the data passed from newFromArray is used)
	 * @return array
	 */
	public function getCurrentPage( array $aData = null ) {
		$index = $this->activePage - 1;

		// deprecated case:
		if ( is_null( $aData ) ) {
			return $this->paginatedData[$index];
		}

		if ( count( $aData ) > 0 ) {
			$aPaginatedData = array_chunk( $aData, $this->itemsPerPage );
		} else {
			$aPaginatedData = $aData;
		}

		if ( !isset( $aPaginatedData[$index] ) ) {
			return [];
		}

		return $aPaginatedData[$index];
	}

	private function getBarData() {
		$aData = [];

		$leftEllipsis = ( $this->activePage > self::DISPLAYED_NEIGHBOURS + 2 );
		$rightEllipsis = ( $this->activePage < $this->pagesCount - self::DISPLAYED_NEIGHBOURS - 1 );
		$leftRangeStart = max( $this->activePage - self::DISPLAYED_NEIGHBOURS, 2 );
		$rightRangeStart = min( $this->activePage + self::DISPLAYED_NEIGHBOURS, $this->pagesCount - 1 );

		$aData[] = 1;

		if ( $this->pagesCount > 1 ) {
			if ( $leftEllipsis ) {
				$aData[] = '';
			}
			for ( $i = $leftRangeStart; $i <= $rightRangeStart; $i++ ) {
				$aData[] = $i;
			}
			if ( $rightEllipsis ) {
				$aData[] = '';
			}
			$aData[] = $this->pagesCount;
		}

		$aResult = [
			'pages' => $aData,
			'currentPage' => $this->activePage
		];

		return $aResult;
	}

	public function getBarHTML( $url, $paginatorId = false ) {
		if ( $this->pagesCount <= 1 ) {
			return '';
		}

		$aData = $this->getBarData();
		$aData['paginatorId'] = strip_tags( trim( stripslashes( $paginatorId ) ) );
		$aData['url'] = $url;

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . '/templates/' );
		$oTmpl->set_vars( $aData );
		return $oTmpl->render( 'paginator' );
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
