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
		$this->wg->Out->addHTML( F::build('JSSnippets')->addToStack( array( "/extensions/wikia/Search/js/WikiaSearch.js" ) ) );
		$this->wg->SuppressRail = true;

		$this->handleSkinSettings();

		$searchConfig = F::build('WikiaSearchConfig');
		
		$searchConfig
			->setQuery			( htmlentities( Sanitizer::StripAllTags ( $this->getVal('query', $this->getVal('search')) ), ENT_COMPAT, 'UTF-8') )
			->setLimit			( $this->getVal('limit', self::RESULTS_PER_PAGE) )
			->setPage			( $this->getVal('page', 1) )
			->setRank			( $this->getVal('rank', 'default') )
			->setDebug			( $this->request->getBool('debug', false) )
			->setSkipCache		( $this->request->getBool('skipCache', false) )
			->setAdvanced		( $this->request->getBool( 'advanced', false ) )
			->setHub			( ($this->getVal('nohub') != '1') ? $this->getVal('hub', false) : false )
			->setRedirs			( $searchConfig->getAdvanced() ? $this->request->getBool('redirs', false) : false )
			->setIsInterWiki	( $this->request->getBool('crossWikia', false) || $this->isCorporateWiki() )
			->setVideoSearch	( $this->getVal('videoSearch', false) )
			->setGroupResults	( $searchConfig->isInterWiki() || $this->getVal('grouped', false) )
		 ;

		$this->setNamespacesFromRequest( $searchConfig );

		if($this->isCorporateWiki()) {
			OasisController::addBodyClass('inter-wiki-search');
		}

		if( $searchConfig->getQuery() ) {
			$articleMatch = null;
			if ( $searchConfig->getPage() == 1 ) {
				$this->wikiaSearch->getArticleMatch( $searchConfig );

				$this->handleArticleMatchTracking( $searchConfig );
			}

			$this->wikiaSearch->doSearch( $searchConfig );

			$this->app->wg->Out->setPageTitle( $this->wf->msg( 'wikiasearch2-page-title-with-query', 
												array(ucwords($searchConfig->getQuery()), $this->wg->Sitename) )  );
		} else {
			if( $searchConfig->getIsInterWiki() ) {
				$this->app->wg->Out->setPageTitle( $this->wf->msg( 'wikiasearch2-page-title-no-query-interwiki' ) );
			} else {
				$this->app->wg->Out->setPageTitle( $this->wf->msg( 'wikiasearch2-page-title-no-query-intrawiki', 
													array($this->wg->Sitename) )  );
			}
		}

		if(! $searchConfig->getIsInterWiki() ) {
			$this->setVal( 'advancedSearchBox', $this->sendSelfRequest( 'advancedBox', array( 'config' => $searchConfig ) ) );
		}

		$format = $this->response->getFormat();
		if( ($format == 'json' || $format == 'jsonp') && ($searchConfig->getResultsFound() > 0) ){
			$searchConfig->setResults( $searchConfig->getResults()->toNestedArray() );
		}

		$this->setVal( 'results', $searchConfig->getResults() );
		$this->setVal( 'resultsFound', $searchConfig->getResultsFound() );
		$this->setVal( 'resultsFoundTruncated', $this->wg->Lang->formatNum( $searchConfig->getTruncatedResultsNum() ) );
		$this->setVal( 'isOneResultsPageOnly', $searchConfig->getNumPages() < 2 );
		$this->setVal( 'pagesCount', $searchConfig->getNumPages() );
		$this->setVal( 'currentPage',  $searchConfig->getPage() );
		// @todo handle showing something or nothing in the controller action -- not sure how to de-register a template
		$this->setVal( 'paginationLinks', $this->sendSelfRequest( 'pagination',  array('config' => $searchConfig) ) ); 
		$this->setVal( 'tabs', $this->sendSelfRequest( 'tabs', array( 'config' => $searchConfig ) ) );
		$this->setVal( 'query', $searchConfig->getQuery() );
		$this->setVal( 'resultsPerPage', $searchConfig->getLimit() );
		$this->setVal( 'pageUrl', $this->wg->Title->getFullUrl() );
		$this->setVal( 'debug', $searchConfig->getDebug() );
		$this->setVal( 'solrHost', $this->wg->SolrHost);
		$this->setVal( 'isInterWiki', $searchConfig->getIsInterWiki() );
		$this->setVal( 'relevancyFunctionId', WikiaSearch::RELEVANCY_FUNCTION_ID );
		$this->setVal( 'namespaces', $searchConfig->getNamespaces() );
		$this->setVal( 'hub', $searchConfig->getHub() );
		$this->setVal( 'hasArticleMatch', $searchConfig->hasArticleMatch() );
		$this->setVal( 'isMonobook', ($this->wg->User->getSkin() instanceof SkinMonobook) );
		$this->setVal( 'showSearchAds', $searchConfig->getQuery() ? $this->showSearchAds() : false );
		$this->setVal( 'isCorporateWiki', $this->isCorporateWiki() );
	}
	
	public function videoSearch()
	{
	    $searchConfig = F::build('WikiaSearchConfig');
	    $searchConfig
	    ->setCityId	( $this->wg->cityId )
	    ->setQuery	( $this->getVal('q') )
	    ;
	    $this->wikiaSearch->searchVideos($searchConfig);
	    // up to whoever's using this service as to what they want from here. I'm just going to return JSON.
	    // if you just want to search for only videos in the traditional video interface, then you should
	    // be setting 'videoSearch' in the query string of the search index page
	    $this->getResponse()->setFormat('json');
	    $this->getResponse()->setData( ($searchConfig->getResults()) ? $searchConfig->getResults()->toNestedArray() : array() );
	
	}
	
	private function handleArticleMatchTracking( WikiaSearchConfig $searchConfig )
	{
		$articleMatch = $searchConfig->getArticleMatch();
		if ( !empty($articleMatch) && $this->getVal('fulltext', '0') === '0') {
		
		    $article = isset($articleMatch['redirect']) ? $articleMatch['redirect'] : $articleMatch['article'];
		    $title = $article->getTitle();
		
		    wfRunHooks( 'SpecialSearchIsgomatch', array( &$title, $searchConfig->getOriginalQuery() ) );
		
		    Track::event( 'search_start_gomatch', array( 'sterm' => $searchConfig->getOriginalQuery(), 'rver' => 0 ) );
		    $this->response->redirect( $title->getFullURL() );
		}
		elseif(!empty($articleMatch)) {
		    Track::event( 'search_start_match', array( 'sterm' => $searchConfig->getOriginalQuery(), 'rver' => 0 ) );
		} else {
		    $title = Title::newFromText( $searchConfig->getOriginalQuery() );
		    if ( !is_null( $title ) ) {
		        wfRunHooks( 'SpecialSearchNogomatch', array( &$title ) );
		    }
		}
	}
	
	private function setNamespacesFromRequest( WikiaSearchConfig $searchConfig )
	{
		$searchableNamespaces = SearchEngine::searchableNamespaces();
		$namespaces = array();
		foreach($searchableNamespaces as $i => $name) {
		    if ( $this->getVal('ns'.$i, false) ) {
		        $namespaces[] = $i;
		    }
		}
		if (empty($namespaces) && $this->wg->User->getOption('searchAllNamespaces')) {
		    $namespaces = array_keys($searchableNamespaces);
		}
		
		$searchConfig->setNamespaces( $namespaces );
	}
	
	private function handleSkinSettings()
	{
		$skin = $this->wg->User->getSkin();
		
		if ( $skin instanceof SkinMonoBook ) {
		    $this->response->addAsset('extensions/wikia/Search/monobook/monobook.scss');
		}
		if ( get_class($this->wg->User->getSkin()) == 'SkinOasis' ) {
		    $this->response->addAsset('extensions/wikia/Search/css/WikiaSearch.scss');
		}
		if ( $this->app->checkSkin( 'wikiamobile' ) ) {
		    $this->overrideTemplate( 'WikiaMobileIndex' );
		}
	}
	
	private function showSearchAds()
	{
		$skin = $this->wg->User->getSkin();
		
		if (!empty($this->wg->EnableWikiaSearchAds)) {
		    if (!empty($this->wg->NoExternals)) {
		        // don't show ads in search
		    } elseif (is_object($this->wg->User) && $this->wg->User->isLoggedIn() && !($this->wg->User->getOption('showAds') || !empty($_GET['showads']))) {
		        // don't show ads in search
		    } elseif ((! $skin instanceof SkinMonoBook) && (! $skin instanceof SkinVector)) {
		        $this->app->registerHook('MakeGlobalVariablesScript', 'WikiaSearchAdsController', 'onMakeGlobalVariablesScript');
		        $this->response->addAsset('extensions/wikia/Search/js/WikiaSearchAds.js');
		        return true;
		    }
		}
		return false;
	}

	public function advancedBox() {
		$config = $this->getVal('config');

		$this->setVal( 'term',  $config->getQuery() );
		$this->setVal( 'bareterm', $config->getQuery() ); // query is stored as bareterm in config
		$this->setVal( 'namespaces', $config->getNamespaces() );
		$this->setVal( 'searchableNamespaces', SearchEngine::searchableNamespaces() );
		$this->setVal( 'redirs', $config->getIncludeRedirects() );
		$this->setVal( 'advanced', $config->getAdvanced() );
	}

	public function tabs() {
		$config = $this->getVal('config');

		$this->setVal( 'bareterm', $config->getQuery() );
		$this->setVal( 'searchProfiles', $config->getSearchProfiles() );
		$this->setVal( 'redirs', $config->getIncludeRedirects() );
		$this->setVal( 'activeTab', $config->getActiveTab() );
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
		$stParams = array_merge( array( 'search' => $term ), $opt );

		$title = F::build('SpecialPage', array( 'WikiaSearch' ), 'getTitleFor');

		$this->setVal( 'href', $title->getLocalURL( $stParams ) );
		$this->setVal( 'title', $tooltip );
		$this->setVal( 'label', $label );
		$this->setVal( 'tooltip', $tooltip );
	}


	public function pagination() {
		$config = $this->getVal('config');
		if (! $config->getResultsFound() ) {
			return false;
		}
		
		$page = $config->getPage();
		
		$windowFirstPage = ( ( $page - self::PAGES_PER_WINDOW ) > 0 ) 
						? ( $page - self::PAGES_PER_WINDOW ) 
						: 1;
		
		$windowLastPage = ( ( ( $page + self::PAGES_PER_WINDOW ) < $config->getNumPages() ) 
						? ( $page + self::PAGES_PER_WINDOW )
						: $config->getNumPages() ) ;

		$this->setVal( 'query', 			$config->getQuery() );
		$this->setVal( 'pagesNum', 			$config->getNumPages() );
		$this->setVal( 'currentPage', 		$page );
		$this->setVal( 'windowFirstPage', 	$windowFirstPage );
		$this->setVal( 'windowLastPage', 	$windowLastPage );
		$this->setVal( 'pageTitle', 		$this->wg->Title );
		$this->setVal( 'crossWikia', 		$this->getIsInterWiki() );
		$this->setVal( 'resultsCount', 		$config->getResultsFound() );
		$this->setVal( 'skipCache', 		$config->getSkipCache() );
		$this->setVal( 'debug', 			$config->getDebug() );
		$this->setVal( 'namespaces', 		$config->getNamespaces() );
		$this->setVal( 'advanced', 			$config->getAdvanced() );
		$this->setVal( 'redirs', 			$config->getIncludeRedirects() );
		$this->setVal( 'limit', 			$config->getLimit() );
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
		$searchConfig = F::build('WikiaSearchConfig');
		$pageId = $this->getVal('id');
		if ( !empty( $pageId ) ) {
			$searchConfig->setPageId( $pageId );
		}
		$searchConfig
			->setStart	(  0 )
			->setSize	( 20 );
		
		$responseData = $this->wikiaSearch->getRelatedVideos( $searchConfig );
		$this->response->setData($responseData);
		$this->response->setFormat('json');
	}

	public function getSimilarPagesExternal() {
		$searchConfig = F::build('WikiaSearchConfig');
		$url = $this->getVal('url', null);
		$contents = $this->getVal('contents', null); 
		if ( $url !== null ) {
			$searchConfig->setContentUrl($url);
		} else if ( $contents !== null ) {
			$searchConfig->setStreamBody($contents);
		} else {
			throw new Exception('Please provide a url or stream contents');
		}
		
		$responseData = $this->wikiaSearch->getSimilarPages( $searchConfig );
		$this->response->setData($responseData);
		$this->response->setFormat('json');
	}

	public function getKeywords() {
		$searchConfig = F::build('WikiaSearchConfig');
		$searchConfig->setPageId($this->getVal('id', false));
		$responseData = $this->wikiaSearch->getKeywords( $searchConfig );
		$this->response->setData($responseData);
		$this->response->setFormat('json');
	}

	//WikiaMobile hook to add assets so they are minified and concatenated
	public function onWikiaMobileAssetsPackages( &$jsHeadPackages, &$jsBodyPackages, &$scssPackages){
		if( F::app()->wg->Title->isSpecial('Search') ) {
			$jsBodyPackages[] = 'wikiasearch_js_wikiamobile';
			$scssPackages[] = 'wikiasearch_scss_wikiamobile';
		}

		return true;
	}

	

	protected function  isCorporateWiki() {
	    return !empty($this->wg->EnableWikiaHomePageExt);
	}
	
	
}
