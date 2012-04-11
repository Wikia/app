<?php

class WikiaSearchController extends WikiaSpecialPageController {

	const RESULTS_PER_PAGE = 25;
	const PAGES_PER_WINDOW = 10;

	protected $wikiaSearch = null;

	public function __construct() {
		$this->wikiaSearch = F::build('WikiaSearch');

		parent::__construct( 'WikiaSearch', 'WikiaSearch', false );
	}

	public function index() {
	
		$this->wg->Out->addHTML( F::build('JSSnippets')->addToStack( array( "/extensions/wikia/SearchV2/WikiaSearch.js" ), array(), 'WikiaSearchV2.init' ) );
		//$this->app->wg->Out->addStyle(AssetsManager::getInstance()->getSassCommonURL('extensions/wikia/SearchV2/css/Search.scss'));
		/*
		if( !in_array( 'staff', $this->wg->User->getEffectiveGroups() ) ) {
			$this->displayRestrictionError($this->user);
			$this->skipRendering();
			return false;
		}
		*/
		
		$query = $this->getVal('query');
		$page = $this->getVal('page', 1);
		$rankExpr = $this->getVal('rankExpr');
		$debug = $this->request->getBool('debug');
		$crossWikia = $this->request->getBool('crossWikia');

		//  Check for crossWikia value set in url.  Otherwise, check if we're on the corporate wiki
		$isInterWiki = $crossWikia ? true : !empty($wgEnableWikiaHomePageExt);
		
		$results = false;
		$resultsFound = 0;
		$paginationLinks = '';
		if( !empty( $query ) ) {
			$results = $this->wikiaSearch->doSearch( $query, $page, self::RESULTS_PER_PAGE, ( $isInterWiki ? 0 : $this->wg->CityId ), $rankExpr, $isInterWiki );
			$resultsFound = $results->getRealResultsFound();

			if(!empty($resultsFound)) {
				$paginationLinks = $this->sendSelfRequest( 'pagination', array( 'query' => $query, 'page' => $page, 'count' => $resultsFound, 'crossWikia' => $isInterWiki, 'rankExpr' => $rankExpr, 'groupResults' => $isInterWiki ) );
			}
		}

		$this->setVal( 'results', $results );
		$this->setVal( 'resultsFound', $resultsFound );
		$this->setVal( 'currentPage',  $page );
		$this->setVal( 'paginationLinks', $paginationLinks );
		$this->setVal( 'query', $query );
		$this->setVal( 'resultsPerPage', self::RESULTS_PER_PAGE );
		$this->setVal( 'pageUrl', $this->wg->Title->getFullUrl() );
		$this->setVal( 'rankExpr', $rankExpr );
		$this->setVal( 'debug', $debug );
		$this->setVal( 'solrHost', $this->wg->SolrHost);
		$this->setVal( 'debug', $this->getVal('debug', false) );
		$this->setVal( 'wgBlankImgUrl', $this->wg->BlankImgUrl );
		$this->setVal( 'isInterWiki', $isInterWiki );
	}

	public function pagination() {
		$isInterWiki = !empty($wgEnableWikiaHomePageExt); // For now, just checking if we're on wikia.com wiki
		$query = $this->getVal('query');
		$page = $this->getVal( 'page', 1 );
		$rankExpr = $this->getVal('rankExpr');
		$resultsCount = $this->getVal( 'count', 0);
		$pagesNum = ceil( $resultsCount / self::RESULTS_PER_PAGE );

		$this->setVal( 'query', $query );
		$this->setVal( 'pagesNum', $pagesNum );
		$this->setVal( 'rankExpr', $rankExpr );
		$this->setVal( 'currentPage', $page );
		$this->setVal( 'windowFirstPage', ( ( ( $page - self::PAGES_PER_WINDOW ) > 0 ) ? ( $page - self::PAGES_PER_WINDOW ) : 1 ) );
		$this->setVal( 'windowLastPage', ( ( ( $page + self::PAGES_PER_WINDOW ) < $pagesNum ) ? ( $page + self::PAGES_PER_WINDOW ) : $pagesNum ) );
		$this->setVal( 'pageTitle', $this->wg->Title );
		$this->setVal( 'isInterWiki', $isInterWiki);
	}

	public function getPage() {
		$pageId = $this->getVal('id');
		$metaData = $this->getVal('meta', true);

		if( !empty( $pageId ) ) {
			$page = $this->wikiaSearch->getPage( $pageId, $metaData );

			$this->response->setData( $page );
		}

		// force output format as there's no template file (BugId:18831)
		$this->getResponse()->setFormat('json');
	}

	public function getPages() {
	  
	  $ids = $this->getVal('ids');
	  $metaData = $this->getVal('meta', true);

	  if ( !empty( $ids ) ) {
	    $this->response->setData( $this->wikiaSearch->getPages($ids) );
	  }
	  $this->getResponse()->setFormat('json');

	}

	public function getPageMetaData() {
		$pageId = $this->getVal('id');

		if( !empty( $pageId ) ) {
			$metaData = $this->wikiaSearch->getPageMetaData( $pageId );

			$this->response->setData( $metaData );
		}
	}


	public function getRelatedVideos() {

	        $pageId = $this->getVal('id');

		if ( !empty( $pageId ) ) {

		     $responseData = $this->wikiaSearch->getRelatedVideos( $pageId );

		     $this->response->setData( $responseData );

		}

		$this->getResponse()->setFormat('json');

	}
	
	public function boostSettings() {
	}

}