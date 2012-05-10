<?php

class WikiaSearchController extends WikiaSpecialPageController {

	const RESULTS_PER_PAGE = 25;
	const PAGES_PER_WINDOW = 5;

	/**
	 * @var WikiaSearch
	 */
	protected $wikiaSearch = null;

	public function __construct() {
	        // note: this is required since we haven't constructed $this->wg yet
		global $wgWikiaSearchIsDefault;

		$this->wikiaSearch = F::build('WikiaSearch');
		$specialPageName = $wgWikiaSearchIsDefault ? 'Search' : 'WikiaSearch';
		parent::__construct( $specialPageName, $specialPageName, false );
	}

	public function index() {
		$this->wg->Out->addHTML( F::build('JSSnippets')->addToStack( array( "/extensions/wikia/SearchV2/WikiaSearch.js" ), array(), 'WikiaSearchV2.init' ) );
		
		if ( $this->wg->User->getSkin() instanceof SkinMonoBook ) {
			$this->response->addAsset('extensions/wikia/Paginator/monobook/monobook.scss');
			$this->response->addAsset('extensions/wikia/SearchV2/monobook/monobook.scss');
		}

		$query = $this->getVal('query', $this->getVal('search'));
		$page = $this->getVal('page', 1);
		$rank = $this->getVal('rank', 'default');
		$debug = $this->request->getBool('debug');
		$crossWikia = $this->request->getBool('crossWikia');
		$skipCache = $this->request->getBool('skipCache');
		$activeAdvancedTab = $this->getActiveAdvancedTab();
		$advanced = $this->getVal( 'advanced' );
		$searchableNamespaces = SearchEngine::searchableNamespaces();
		$wikiName = $this->wg->Sitename;
		$hub = ($this->getVal('nohub') != '1') ? $this->getVal('hub') : false;
		
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
			OasisController::addBodyClass('inter-wiki-search');
		}

		$results = false;
		$resultsFound = 0;
		$paginationLinks = '';
		if( !empty( $query ) ) {
			$articleMatch = $this->wikiaSearch->getArticleMatch($query);
			$go = $this->getVal('go');
			if (!empty($articleMatch) && !empty($go)) {
				extract($articleMatch);

				$title = isset($redirect) ? $redirect->getTitle() : $article->getTitle();
				
				wfRunHooks( 'SpecialSearchIsgomatch', array( &$title, $query ) );
				  
				$this->response->redirect( $title->getFullURL() );
			}

		 	$this->wikiaSearch->setNamespaces( $namespaces );
			$this->wikiaSearch->setSkipCache( $skipCache );
			// @todo turn it back on, when backend will be fixed
			//$this->wikiaSearch->setIncludeRedirects( $redirs );

			$params = array('page'=>$page, 
					'length'=>self::RESULTS_PER_PAGE, 
					'cityId'=>( $isInterWiki ? 0 : $this->wg->CityId ), 
					'groupResults'=>$isInterWiki,
					'rank'=>$rank,
					'hub'=>$hub);

			$results = $this->wikiaSearch->doSearch( $query, $params );

			$resultsFound = $results->getRealResultsFound();

			if(!empty($resultsFound)) {
				$paginationLinks = $this->sendSelfRequest( 'pagination', array( 'query' => $query, 'page' => $page, 'count' => $resultsFound, 'crossWikia' => $isInterWiki, 'skipCache' => $skipCache, 'debug' => $debug, 'namespaces' => $namespaces, 'advanced' => $advanced, 'redirs' => $redirs ) );
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
		$this->setVal( 'resultsFoundTruncated', $this->wg->Lang->formatNum( $this->getTruncatedResultsNum($resultsFound) ) );
		$this->setVal( 'isOneResultsPageOnly', ( $resultsFound <= self::RESULTS_PER_PAGE ) );
		$this->setVal( 'currentPage',  $page );
		$this->setVal( 'paginationLinks', $paginationLinks );
		$this->setVal( 'query', $query );
		$this->setVal( 'resultsPerPage', self::RESULTS_PER_PAGE );
		$this->setVal( 'pageUrl', $this->wg->Title->getFullUrl() );
		$this->setVal( 'debug', $debug );
		$this->setVal( 'solrHost', $this->wg->SolrHost);
		$this->setVal( 'debug', $this->getVal('debug', false) );
		$this->setVal( 'isInterWiki', $isInterWiki );
		$this->setVal( 'relevancyFunctionId', WikiaSearch::RELEVANCY_FUNCTION_ID );
		$this->setVal( 'namespaces', $namespaces );
		$this->setVal( 'hub', $hub );
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

	private function getTruncatedResultsNum($resultsNum) {
		$result = $resultsNum;

		$digits = strlen( $resultsNum );
		if( $digits > 1 ) {
			$zeros = ( $digits > 3 ) ? ( $digits - 1 ) : $digits;
			$result = round( $resultsNum, ( 0 - ( $zeros - 1 ) ) );
		}

		return $result;
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
	
	public function getRelatedVideos() {

	       $pageId = $this->getVal('id');
	       $params = array();
	       if ( !empty( $pageId ) ) {
		 $params['pageId'] = $pageId;
	       }
	       $responseData = $this->wikiaSearch->getRelatedVideos( $params );
	       $this->response->setData($responseData);
	       $this->response->setFormat('json');

	}

	public function getSimilarPagesExternal() {

	       $url = $this->getVal('url');
	       if ( !empty($url) ) {
		 $params = array('stream.url'=>$url);
	       } else if ($contents = $this->getVal('contents')) {
		 $params = array('stream.body'=>$contents);
	       } else {
		 throw new Exception('Please provide a url or stream contents');
	       }
	       $responseData = $this->wikiaSearch->getSimilarPages(false, $params);
	       $this->response->setData($responseData);
	       $this->response->setFormat('json');

	}

	public function getKeywords() {

       	       $pageId = $this->getVal('id');
	       $params = array();
	       if ( !empty( $pageId ) ) {
		 $params['pageId'] = $pageId;
	       }
	       $responseData = $this->wikiaSearch->getKeywords( $params );
	       $this->response->setData($responseData);
	       $this->response->setFormat('json');


	}

	public function getTagCloud() {

	  $params = $this->getTagCloudParams();

	  $this->response->setData($this->wikiaSearch->getTagCloud($params));
	  $this->response->setFormat('json');

	}

	private function getTagCloudParams()
	{
	  $params = array();
	  $params['maxpages']    = $this->getVal('maxpages', 25);
	  $params['termcount']   = $this->getVal('termcount', 50);
	  $params['maxfontsize'] = $this->getVal('maxfontsize', 56);
	  $params['minfontsize'] = $this->getVal('minfontsize', 10);
	  $params['sizetype']    = $this->getVal('sizetype', 'pt');
	  return $params;
	}

}