<?php

class WikiaSearchController extends WikiaSpecialPageController {

	const RESULTS_PER_PAGE = 25;
	const PAGES_PER_WINDOW = 5;

	/**
	 * @var WikiaSearch
	 */
	protected $wikiaSearch = null;

	public function __construct() {
		$this->wikiaSearch = F::build('WikiaSearch');

		parent::__construct( 'WikiaSearch', 'WikiaSearch', false );
	}

	public function index() {
		$this->wg->Out->addHTML( F::build('JSSnippets')->addToStack( array( "/extensions/wikia/SearchV2/WikiaSearch.js" ), array(), 'WikiaSearchV2.init' ) );
		
		$query = $this->getVal('query');
		$page = $this->getVal('page', 1);
		$debug = $this->request->getBool('debug');
		$crossWikia = $this->request->getBool('crossWikia');
		$skipCache = $this->request->getBool('skipCache');
		$activeAdvancedTab = $this->getActiveAdvancedTab();
		$advanced = $this->getVal( 'advanced' );
		$searchableNamespaces = SearchEngine::searchableNamespaces();
		$wikiName = $this->wg->Sitename;
		
		if(!empty($advanced)) {
			$redirs = $this->request->getBool('redirs');
		}
		else {
			// include redirects by default
			$redirs = true;
		}

		$namespaces = array();
		foreach($searchableNamespaces as $i => $name) {
			if ($ns = $this->getVal('ns'.$i)) {
				$namespaces[] = $i;
			}
		}

		$isCorporateWiki = !empty($this->wg->EnableWikiaHomePageExt);
		//  Check for crossWikia value set in url.  Otherwise, check if we're on the corporate wiki
		$isInterWiki = $crossWikia ? true : $isCorporateWiki;

		if($isCorporateWiki) {
			OasisModule::addBodyClass('inter-wiki-search');
		}
		
		$results = false;
		$resultsFound = 0;
		$paginationLinks = '';
		if( !empty( $query ) ) {
		 	$this->wikiaSearch->setNamespaces( $namespaces );
			$this->wikiaSearch->setSkipCache( $skipCache );
			// @todo turn it back on, when backend will be fixed
			//$this->wikiaSearch->setIncludeRedirects( $redirs );

			$results = $this->wikiaSearch->doSearch( $query, $page, self::RESULTS_PER_PAGE, ( $isInterWiki ? 0 : $this->wg->CityId ), $isInterWiki );
			$resultsFound = $results->getRealResultsFound();

			if(!empty($resultsFound)) {
				$paginationLinks = $this->sendSelfRequest( 'pagination', array( 'query' => $query, 'page' => $page, 'count' => $resultsFound, 'crossWikia' => $isInterWiki, 'skipCache' => $skipCache, 'debug' => $debug, 'namespaces' => $namespaces, 'advanced' => $advanced, 'redirs' => $redirs ) );
				$resultsFound = WikiaSearchHelper::formatNumber($resultsFound);
			}

			$this->app->wg->Out->setPageTitle( $this->wf->msg( 'wikiasearch2-page-title-with-query', array(ucwords($query), $wikiName) )  );
		} else {
			if($isInterWiki) {
				$this->app->wg->Out->setPageTitle( $this->wf->msg( 'wikiasearch2-page-title-no-query-interwiki' ) );		
			} else {
				$this->app->wg->Out->setPageTitle( $this->wf->msg( 'wikiasearch2-page-title-no-query-intrawiki', array($wikiName) )  );						
			}
		}

		if(!$isInterWiki) {
			$advancedSearchBox = $this->sendSelfRequest( 'advancedBox', array( 'term' => $query, 'namespaces' => $namespaces, 'activeTab' => $activeAdvancedTab, 'searchableNamespaces' => $searchableNamespaces, 'advanced' => $advanced, 'redirs' => $redirs ) );
			$this->setval( 'advancedSearchBox', $advancedSearchBox );
		}
		
		$this->setVal( 'results', $results );
		$this->setVal( 'resultsFound', $resultsFound );
		$this->setVal( 'currentPage',  $page );
		$this->setVal( 'paginationLinks', $paginationLinks );
		$this->setVal( 'query', $query );
		$this->setVal( 'resultsPerPage', self::RESULTS_PER_PAGE );
		$this->setVal( 'pageUrl', $this->wg->Title->getFullUrl() );
		$this->setVal( 'debug', $debug );
		$this->setVal( 'solrHost', $this->wg->SolrHost);
		$this->setVal( 'debug', $this->getVal('debug', false) );
		$this->setVal( 'isInterWiki', $isInterWiki );
	}

	public function advancedBox() {
		$term = $this->getVal( 'term' );
		$namespaces = $this->getVal( 'namespaces' );
		$activeTab = $this->getVal( 'activeTab' );
		$searchableNamespaces = $this->getVal( 'searchableNamespaces' );
		$advanced = $this->getVal( 'advanced' );
		$redirs = $this->getVal( 'redirs' );

		$bareterm = $term;
		if( $this->termStartsWithImage( $term ) ) {
			// Deletes prefixes
			$bareterm = substr( $term, strpos( $term, ':' ) + 1 );
		}

		$this->setVal( 'searchProfiles', $this->getSearchProfiles( $namespaces ) );
		$this->setVal( 'term',  $term);
		$this->setVal( 'bareterm', $bareterm );
		$this->setVal( 'namespaces', $namespaces );
		$this->setVal( 'activeTab', $activeTab );
		$this->setVal( 'searchableNamespaces', $searchableNamespaces );
		$this->setVal( 'redirs', $redirs );
		$this->setVal( 'advanced', $advanced);
	}

	public function advancedTabLink() {
		$term = $this->getVal('term');
		$namespaces = $this->getVal('namespaces');
		$label = $this->getVal('label');
		$tooltip = $this->getVal('tooltip');
		$params = $this->getVal('params');
		$redirs = $this->getVal('redirs');

		$opt = $params;
		foreach( $namespaces as $n ) {
			$opt['ns' . $n] = 1;
		}

		$opt['redirs'] = !empty($redirs) ? 1 : 0;
		$stParams = array_merge( array( 'query' => $term ), $opt );

		$title = F::build('SpecialPage', array( 'WikiaSearch' ), 'getTitleFor');

		$this->setVal( 'href', $title->getLocalURL( $stParams ) );
		$this->setVal( 'title', $tooltip );
		$this->setVal( 'label', $label );
		$this->setVal( 'tooltip', $tooltip );
	}

	/*
	 * Check if query starts with image: prefix
	 * @return bool
	 */
	protected function termStartsWithImage( $term ) {
		$p = explode( ':', $term );
		if( count( $p ) > 1 ) {
			return $this->wg->ContLang->getNsIndex( $p[0] ) == NS_FILE;
		}
		return false;
	}

	protected function getSearchProfiles($namespaces) {
		// Builds list of Search Types (profiles)
		$nsAllSet = array_keys( SearchEngine::searchableNamespaces() );

		$profiles = array(
			'default' => array(
				'message' => 'searchprofile-articles',
				'tooltip' => 'searchprofile-articles-tooltip',
				'namespaces' => SearchEngine::defaultNamespaces(),
				'namespace-messages' => SearchEngine::namespacesAsText(
					SearchEngine::defaultNamespaces()
				),
			),
			'images' => array(
				'message' => 'searchprofile-images',
				'tooltip' => 'searchprofile-images-tooltip',
				'namespaces' => array( NS_FILE ),
			),
			'help' => array(
				'message' => 'searchprofile-project',
				'tooltip' => 'searchprofile-project-tooltip',
				'namespaces' => SearchEngine::helpNamespaces(),
				'namespace-messages' => SearchEngine::namespacesAsText(
					SearchEngine::helpNamespaces()
				),
			),
			'all' => array(
				'message' => 'searchprofile-everything',
				'tooltip' => 'searchprofile-everything-tooltip',
				'namespaces' => $nsAllSet,
			),
			'advanced' => array(
				'message' => 'searchprofile-advanced',
				'tooltip' => 'searchprofile-advanced-tooltip',
				'namespaces' => $namespaces,
				'parameters' => array( 'advanced' => 1 ),
			)
		);

		$this->wf->RunHooks( 'SpecialSearchProfiles', array( &$profiles ) );

		foreach( $profiles as $key => &$data ) {
			sort($data['namespaces']);
		}

		return $profiles;
	}

	protected function getActiveAdvancedTab() {
		if($this->request->getVal('advanced')) {
			return 'advanced';
		}

		$namespaces = array_keys(SearchEngine::searchableNamespaces());
		$nsVals = array();

		foreach($namespaces as $ns) {
			if ($val = $this->request->getVal('ns'.$ns)) {
				$nsVals[] = $ns;
			}
		}

		if(empty($nsVals)) {
			return 'default';
		}

		if($nsVals == $namespaces) {
			return 'all';
		}

		if($nsVals == array( NS_FILE )) {
			return 'images';
		}

		if($nsVals == SearchEngine::helpNamespaces()) {
			return 'help';
		}

		if($nsVals == SearchEngine::defaultNamespaces()) {
			return 'default';
		}

		return 'advanced';
	}


	public function pagination() {
		$query = $this->getVal('query');
		$page = $this->getVal( 'page', 1 );
		$resultsCount = $this->getVal( 'count', 0);
		$pagesNum = ceil( $resultsCount / self::RESULTS_PER_PAGE );
		$crossWikia = $this->getVal('crossWikia');
		$debug = $this->getVal('debug');
		$skipCache = $this->getVal('skipCache');
		$namespaces = $this->getVal('namespaces', array());
		$advanced = $this->getVal( 'advanced' );
		$redirs = $this->getVal( 'redirs' );

		$this->setVal( 'query', $query );
		$this->setVal( 'pagesNum', $pagesNum );
		$this->setVal( 'currentPage', $page );
		$this->setVal( 'windowFirstPage', ( ( ( $page - self::PAGES_PER_WINDOW ) > 0 ) ? ( $page - self::PAGES_PER_WINDOW ) : 1 ) );
		$this->setVal( 'windowLastPage', ( ( ( $page + self::PAGES_PER_WINDOW ) < $pagesNum ) ? ( $page + self::PAGES_PER_WINDOW ) : $pagesNum ) );
		$this->setVal( 'pageTitle', $this->wg->Title );
		$this->setVal( 'crossWikia', $crossWikia );
		$this->setVal( 'resultsCount', $resultsCount );
		$this->setVal( 'skipCache', $skipCache );
		$this->setVal( 'debug', $debug );
		$this->setVal( 'namespaces', $namespaces );
		$this->setVal( 'advanced', $advanced );
		$this->setVal( 'redirs', $redirs );
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
	  $this->wg->AllowMemcacheWrites = false;
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
	
	public function boostSettings() {
	}

}