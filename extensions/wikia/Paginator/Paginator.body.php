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
	 * @param   array  configuration
	 * @return  Pagination
	 */
	public static function newFromArray( $aData, $iItemsPerPage = 8, $iDisplayedNeighbour = 3, $bCach = false, $sCacheKey = '' ){

		$aConfig = array(
			'itemsPerPage'		=> $iItemsPerPage,
			'displayedNeighbours'	=> $iDisplayedNeighbour
		);
		
		return new Paginator( $aData, $aConfig, $bCach, $sCacheKey );
	}

	/**
	 * Creates a new Pagination object.
	 *
	 * @param   array  configuration
	 * @return  void
	 */
	public function __construct( $aData, $aConfig = false, $bCach = false, $sCacheKey = ''  ){

		$this->enableCache = ( !empty( $bCach ) && !empty( $sCacheKey ) );
		$this->cacheKey = $sCacheKey;
		$this->setConfig( $aConfig, $aData );
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
		
		if ( ( is_array($aData) ) && ( count($aData) > 0 ) ){
			$aPaginatedData = array_chunk( $aData, $this->config['itemsPerPage'] );
			$this->paginatedData = $aPaginatedData;
		}else{
			$this->paginatedData = $aData;
		}
		$this->pagesCount = count( $this->paginatedData );
	}

	public function hasContent(){

		return ( $this->pagesCount >= 1 );

	}

	public function setActivePage( $iPageNumber ){

		$this->activePage = $iPageNumber;
	}

	public function getPage( $iPageNumber, $bSetToActive = false ){

		$iPageNumber = (int) $iPageNumber;
		$iPageNumber --;
		if ( $iPageNumber <= $this->pagesCount && $iPageNumber >= 0 ){
			if ( !empty($bSetToActive) ){
				$this->setActivePage( $iPageNumber );
			}
			return $this->paginatedData[$iPageNumber];
		} elseif( $iPageNumber < 0 ) {
			return $this->paginatedData[0];
		} else {
			return $this->paginatedData[$this->pagesCount];
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

	public function getBarHTML($url, $paginatorId = false ){

		if ( $this->pagesCount <= 1 ){
			return '';
		}
		wfLoadExtensionMessages( 'Paginator' );

		$aData = $this->getBarData();
		$aData['paginatorId'] = strip_tags( trim( stripslashes( $paginatorId ) ) );
		$aData['url'] = $url;

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$oTmpl->set_vars( $aData );
		return $oTmpl->execute( "paginator" );
	}
	
}

