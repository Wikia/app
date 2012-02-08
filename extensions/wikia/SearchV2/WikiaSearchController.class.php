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

		/*
		if( !in_array( 'staff', $this->wg->User->getEffectiveGroups() ) ) {
			$this->displayRestrictionError($this->user);
			$this->skipRendering();
			return false;
		}
		*/

		$query = $this->getVal('query');
		$start = $this->getVal('start', 0);
		$crossWikia = $this->getVal('crossWikia', false);

		$results = false;
		$paginationLinks = '';
		if( !empty( $query ) ) {
			$results = $this->wikiaSearch->doSearch( $query, $start, self::RESULTS_PER_PAGE, ( $crossWikia ? 0 : $this->wg->CityId ) );
			if(!empty($results->found)) {
				$paginationLinks = $this->sendSelfRequest( 'pagination', array( 'query' => $query, 'start' => $start, 'count' => $results->found, 'crossWikia' => $crossWikia ) );
			}
		}

		$this->setVal( 'results', $results );
		$this->setVal( 'currentPage',  ( $start / self::RESULTS_PER_PAGE ) + 1 );
		$this->setVal( 'paginationLinks', $paginationLinks );
		$this->setVal( 'query', $query );
		$this->setVal( 'resultsPerPage', self::RESULTS_PER_PAGE );
		$this->setVal( 'pageUrl', $this->wg->Title->getFullUrl() );
		$this->setVal( 'crossWikia', $crossWikia );

		$this->setVal( 'debug', $this->getVal('debug', false) );
	}

	public function pagination() {
		$query = $this->getVal('query');
		$start = $this->getVal( 'start', 0 );
		$resultsPerPage = $this->getVal( 'resultsPerPage', self::RESULTS_PER_PAGE );
		$resultsCount = $this->getVal( 'count', 0);
		$pagesNum = ceil( $resultsCount / $resultsPerPage );
		$currentPage = ( $start / $resultsPerPage ) + 1;

		$this->setVal( 'query', $query );
		$this->setVal( 'pagesNum', $pagesNum );
		$this->setVal( 'currentPage', $currentPage );
		$this->setVal( 'resultsPerPage', self::RESULTS_PER_PAGE );
		$this->setVal( 'windowFirstPage', ( ( ( $currentPage - self::PAGES_PER_WINDOW ) > 0 ) ? ( $currentPage - self::PAGES_PER_WINDOW ) : 1 ) );
		$this->setVal( 'windowLastPage', ( ( ( $currentPage + self::PAGES_PER_WINDOW ) < $pagesNum ) ? ( $currentPage + self::PAGES_PER_WINDOW ) : $pagesNum ) );
		$this->setVal( 'pageTitle', $this->wg->Title );
		$this->setVal( 'crossWikia', $this->getVal( 'crossWikia', false ) );
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

	public function getPageMetaData() {
		$pageId = $this->getVal('id');

		if( !empty( $pageId ) ) {
			$metaData = $this->wikiaSearch->getPageMetaData( $pageId );

			$this->response->setData( $metaData );
		}
	}

}