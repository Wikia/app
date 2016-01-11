<?php
/**
 *
 * @package MediaWiki
 * @subpackage Pagination
 * @author Jakub Kurcek
 *
 * Object that allows auto pagination of array content
 */
class Paginator extends Service{

	// configuration settings

	protected $maxItemsPerPage	= 48;
	protected $defaultItemsPerPage	= 12;
	protected $minItemsPerPage	= 4;

	protected $config = array(
		'itemsPerPage'		=> 8,
		'displayedNeighbours'	=> 3
	);

	protected $paginatedData	= array();
	protected $pagesCount		= 0;
	protected $activePage		= 0;
	protected $cacheKey		= '';
	protected $enableCache		= false;

	/**
	 * Creates a new Pagination object.
	 *
	 * @param   array|integer  $aData
	 * @return  Paginator
	 */
	public static function newFromArray( $aData, $iItemsPerPage = 8, $iDisplayedNeighbour = 3, $bCach = false, $sCacheKey = '', $maxItemsPerPage = 48 ){
		$aConfig = array(
			'itemsPerPage' => $iItemsPerPage,
			'displayedNeighbours' => $iDisplayedNeighbour,
			'maxItemsPerPage' => $maxItemsPerPage,
		);

		return new Paginator( $aData, $aConfig, $bCach, $sCacheKey );
	}

	/**
	 * Creates a new Pagination object.
	 *
	 * @param   array  $aData
	 * @return  void
	 */
	public function __construct( $aData, $aConfig = false, $bCach = false, $sCacheKey = '' ){
		$this->maxItemsPerPage = $aConfig['maxItemsPerPage'];
		$this->enableCache = ( !empty( $bCach ) && !empty( $sCacheKey ) );
		$this->cacheKey = $sCacheKey;
		$this->setConfig( $aConfig );
		$this->paginate( $aData );
	}

	private function setConfig ( $aConfig ){
		if (!empty($aConfig)){
			if ( isset( $aConfig['itemsPerPage'] ) && is_int( $aConfig['itemsPerPage'] ) ){

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

	private function paginate( $aData ){
		if ( is_array($aData) ) {
			if ( count($aData) > 0 ) {
				$aPaginatedData = array_chunk( $aData, $this->config['itemsPerPage'] );
				$this->paginatedData = $aPaginatedData;
			}else{
				$this->paginatedData = $aData;
			}
			$this->pagesCount = count( $this->paginatedData );
		} else if ( is_int($aData) ) {
			$this->pagesCount = ceil($aData / $this->config['itemsPerPage']);
		}
	}

	public function hasContent(){
		return ( $this->pagesCount >= 1 );
	}

	/**
	 * Set the currently active page. This is 0-indexed, so you may need to
	 * set the value to $this->getRequest()->getInt( 'page' ) - 1
	 *
	 * @param int $pageNumber
	 */
	public function setActivePage( $pageNumber ){
		$this->activePage = $pageNumber;
	}

	public function getPage( $iPageNumber, $bSetToActive = false ){
		$iPageNumber = (int) $iPageNumber;
		$iPageNumber --;
		if ( $iPageNumber < $this->pagesCount && $iPageNumber >= 0 ){
			if ( !empty($bSetToActive) ){
				$this->setActivePage( $iPageNumber );
			}
			return $this->paginatedData[$iPageNumber];
		} elseif( $iPageNumber < 0 ) {
			if ( isset( $this->paginatedData[0] ) ){
				return $this->paginatedData[0];
			} else {
				return false;
			}
		} else {
			$this->setActivePage( $this->pagesCount-1 );
			return $this->paginatedData[ $this->pagesCount-1 ];
		}
	}

	public function getCurrentPage( ){
		return $this->getPage( $this->activePage );
	}

	public function getLastPage( ){
		return $this->getPage( $this->pagesCount );
	}

	public function getFirstPage( ){
		return $this->getPage( 1 );
	}

	public function getBarData( ){
		$aData = array();
		$aData[] = 1;

		if ( $this->activePage - $this->config['displayedNeighbours'] > 1 ){
			$aData[] = '';
			$beforeIterations = $this->config['displayedNeighbours'];
		} else {
			$beforeIterations = $this->activePage - 1;
		}

		for( $i = $beforeIterations; $i > 0 ; $i-- ){
			if ( $i == $this->activePage ) break;
			$aData[] = $this->activePage - $i + 1;
		}

		if ( $this->activePage != 0 &&  $this->activePage != $this->pagesCount ){
			$aData[] = $this->activePage + 1;
		};

		for( $i = 1; $this->pagesCount > ( $this->activePage + $i + 1 ) ; $i++ ){
			if ( $i > $this->config['displayedNeighbours'] ) break;
			$aData[] = $this->activePage + $i + 1;
		}

		if ( $this->activePage + 2 + $this->config['displayedNeighbours'] < $this->pagesCount ){
			$aData[] = '';
		}

		if ( $this->pagesCount > $this->activePage + 1 ){
			$aData[] = $this->pagesCount;
		}

		$aResult = array(
			'pages' => $aData,
			'currentPage' => $this->activePage + 1
		);

		return $aResult;
	}

	public function getBarHTML($url, $paginatorId = false) {
		if ( $this->pagesCount <= 1 ) {
			return '';
		}

		$aData = $this->getBarData();
		$aData['paginatorId'] = strip_tags( trim( stripslashes( $paginatorId ) ) );
		$aData['url'] = $url;

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$oTmpl->set_vars( $aData );
		return $oTmpl->render( "paginator" );
	}

	public function getPagesCount() {
		return $this->pagesCount;
	}

	/**
	 * Get HTML to put to HTML <head> to allow search engines to identify next and previous pages
	 *
	 * @param $url the URL template. We'll replace "%s" with the page number
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
