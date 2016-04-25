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
 */
class Paginator {

	// configuration settings

	private $maxItemsPerPage = 48;
	private $defaultItemsPerPage = 12;
	private $minItemsPerPage = 4;

	private $config = [
		'itemsPerPage' => 8,
		'displayedNeighbours' => 3
	];

	private $paginatedData = [];
	private $pagesCount = 0;
	private $activePage = 0;

	/**
	 * Creates a new Pagination object.
	 *
	 * @param int $aData
	 * @param int $iItemsPerPage
	 * @param int $maxItemsPerPage
	 * @return Paginator
	 */
	public static function newFromCount( $aData, $iItemsPerPage = 8, $maxItemsPerPage = 48 ) {
		$aConfig = [
			'itemsPerPage' => $iItemsPerPage,
			'maxItemsPerPage' => $maxItemsPerPage,
		];

		return new Paginator( $aData, $aConfig );
	}

	/**
	 * @deprecated use newFromCount
	 * @param array $aData
	 * @param int $iItemsPerPage
	 * @param int $maxItemsPerPage
	 * @return Paginator
	 */
	public static function newFromArray( array $aData, $iItemsPerPage = 8, $maxItemsPerPage = 48 ) {
		return self::newFromCount( $aData, $iItemsPerPage, $maxItemsPerPage );
	}

	/**
	 * Creates a new Pagination object.
	 *
	 * @param   array $aData
	 * @param bool $aConfig
	 */
	private function __construct( $aData, $aConfig = false ) {
		$this->maxItemsPerPage = $aConfig['maxItemsPerPage'];
		$this->setConfig( $aConfig );
		$this->paginate( $aData );
	}

	private function setConfig( $aConfig ) {
		if ( !empty( $aConfig ) ) {
			if ( isset( $aConfig['itemsPerPage'] ) && is_int( $aConfig['itemsPerPage'] ) ) {

				if ( $aConfig['itemsPerPage'] > $this->maxItemsPerPage ) {
					$aConfig['itemsPerPage'] = $this->maxItemsPerPage;
				}
				if ( $aConfig['itemsPerPage'] < $this->minItemsPerPage ) {
					$aConfig['itemsPerPage'] = $this->minItemsPerPage;
				}

				$this->config['itemsPerPage'] = $aConfig['itemsPerPage'];

			} else {
				$this->config['itemsPerPage'] = $this->defaultItemsPerPage;
			}
		}
	}

	private function paginate( $aData ) {
		if ( is_array( $aData ) ) {
			if ( count( $aData ) > 0 ) {
				$aPaginatedData = array_chunk( $aData, $this->config['itemsPerPage'] );
				$this->paginatedData = $aPaginatedData;
			} else {
				$this->paginatedData = $aData;
			}
			$this->pagesCount = count( $this->paginatedData );
		} else if ( is_int( $aData ) ) {
			$this->pagesCount = ceil( $aData / $this->config['itemsPerPage'] );
		}
	}

	/**
	 * Set the currently active page
	 *
	 * @param int $pageNumber
	 */
	public function setActivePage( $pageNumber ) {
		$pageNumber = min( $pageNumber, $this->getPagesCount() );
		$pageNumber = max( 1, $pageNumber );
		$this->activePage = $pageNumber - 1;
	}

	/**
	 * Get the current page of the passed data
	 *
	 * @param array|null $aData data to be paginated (if null, the data passed from newFromArray is used)
	 * @return array
	 */
	public function getCurrentPage( $aData = null ) {
		if ( is_array( $aData ) ) {
			if ( count( $aData ) > 0 ) {
				$aPaginatedData = array_chunk( $aData, $this->config['itemsPerPage'] );
			} else {
				$aPaginatedData = $aData;
			}
			$iPagesCount = count( $aPaginatedData );

			if ( $this->activePage < $iPagesCount ) {
				return $aPaginatedData[$this->activePage];
			}
			return [];
		}
		return $this->paginatedData[$this->activePage];
	}

	private function getBarData() {
		$aData = [];
		$aData[] = 1;

		if ( $this->activePage - $this->config['displayedNeighbours'] > 1 ) {
			$aData[] = '';
			$beforeIterations = $this->config['displayedNeighbours'];
		} else {
			$beforeIterations = $this->activePage - 1;
		}

		for ( $i = $beforeIterations; $i > 0; $i-- ) {
			if ( $i == $this->activePage ) break;
			$aData[] = $this->activePage - $i + 1;
		}

		if ( $this->activePage != 0 && $this->activePage != $this->pagesCount ) {
			$aData[] = $this->activePage + 1;
		};

		for ( $i = 1; $this->pagesCount > ( $this->activePage + $i + 1 ); $i++ ) {
			if ( $i > $this->config['displayedNeighbours'] ) break;
			$aData[] = $this->activePage + $i + 1;
		}

		if ( $this->activePage + 2 + $this->config['displayedNeighbours'] < $this->pagesCount ) {
			$aData[] = '';
		}

		if ( $this->pagesCount > $this->activePage + 1 ) {
			$aData[] = $this->pagesCount;
		}

		$aResult = [
			'pages' => $aData,
			'currentPage' => $this->activePage + 1
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

		// Converting from 0-indexed to 1-indexed
		$currentPage = $this->activePage + 1;

		// Pages outside the pagination range
		if ( $currentPage < 1 || $currentPage > $this->pagesCount ) {
			return '';
		}

		// Has a previous page?
		if ( $currentPage > 1 ) {
			$links .= "\t" . Html::element( 'link', [
					'rel' => 'prev',
					'href' => str_replace( '%s', $currentPage - 1, $url )
				] ) . PHP_EOL;
		}

		// Has a next page?
		if ( $currentPage < $this->pagesCount ) {
			$links .= "\t" . Html::element( 'link', [
					'rel' => 'next',
					'href' => str_replace( '%s', $currentPage + 1, $url )
				] ) . PHP_EOL;
		}

		return $links;
	}

}
