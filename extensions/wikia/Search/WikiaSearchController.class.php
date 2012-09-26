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

	/**
	 * Controller Actions
	 *---------------------------------------------------------------------------------*/
	
	/**
	 * This is the main search action. Special:Search points here.
	 */
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

		$this->setVal( 'results',				$searchConfig->getResults() );
		$this->setVal( 'resultsFound',			$searchConfig->getResultsFound() );
		$this->setVal( 'resultsFoundTruncated', $this->wg->Lang->formatNum( $searchConfig->getTruncatedResultsNum() ) );
		$this->setVal( 'isOneResultsPageOnly',	$searchConfig->getNumPages() < 2 );
		$this->setVal( 'pagesCount', 			$searchConfig->getNumPages() );
		$this->setVal( 'currentPage', 			$searchConfig->getPage() );
		$this->setVal( 'paginationLinks',		$this->sendSelfRequest( 'pagination',  array('config' => $searchConfig) ) ); 
		$this->setVal( 'tabs', 					$this->sendSelfRequest( 'tabs', array( 'config' => $searchConfig ) ) );
		$this->setVal( 'query',					$searchConfig->getQuery() );
		$this->setVal( 'resultsPerPage',		$searchConfig->getLimit() );
		$this->setVal( 'pageUrl',				$this->wg->Title->getFullUrl() );
		$this->setVal( 'debug',					$searchConfig->getDebug() );
		$this->setVal( 'solrHost',				$this->wg->SolrHost);
		$this->setVal( 'isInterWiki',			$searchConfig->getIsInterWiki() );
		$this->setVal( 'relevancyFunctionId',	WikiaSearch::RELEVANCY_FUNCTION_ID ); //@todo do we need this?
		$this->setVal( 'namespaces',			$searchConfig->getNamespaces() );
		$this->setVal( 'hub',					$searchConfig->getHub() );
		$this->setVal( 'hasArticleMatch',		$searchConfig->hasArticleMatch() );
		$this->setVal( 'isMonobook',			($this->wg->User->getSkin() instanceof SkinMonobook) );
		$this->setVal( 'showSearchAds',			$searchConfig->getQuery() ? $this->showSearchAds() : false );
		$this->setVal( 'isCorporateWiki',		$this->isCorporateWiki() );
	}
	
	/**
	 * Called by a view script to generate the advanced tab link in search.
	 */
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
	
	    $this->setVal( 'href',		$title->getLocalURL( $stParams ) );
	    $this->setVal( 'title',		$tooltip );
	    $this->setVal( 'label',		$label );
	    $this->setVal( 'tooltip',	$tooltip );
	}
	
	/**
	 * Service-level actions -- no view templates, just JSON responses.
	 *---------------------------------------------------------------------------------*/
	
	/**
	 * Used during indexing to retrieve data for a single page in JSON format.
	 */
	public function getPage() {
	    $pageId = $this->getVal( 'id' );
	
	    if( !empty( $pageId ) ) {
	        $page = $this->wikiaSearchIndexer->getPage( $pageId );
	
	        $this->response->setData( $page );
	    }
	
	    // force output format as there's no template file (BugId:18831)
	    $this->getResponse()->setFormat( 'json' );
	}
	
	/**
	 * Used during indexing to retrieve multiple pages in JSON format.
	 */
	public function getPages() {
	    $this->wg->AllowMemcacheWrites = false;
	    $ids = $this->getVal('ids');
	    if ( !empty( $ids ) ) {
	        $this->response->setData( $this->wikiaSearchIndexer->getPages( explode( '|', $ids ) ) );
	    }
	    $this->getResponse()->setFormat('json');
	}
	
	/**
	 * Delivers related videos in JSON format.
	 */
	public function getRelatedVideos() {
	    $searchConfig = F::build('WikiaSearchConfig');
	     
	    if ( $this->getVal('id', false) ) {
	        $searchConfig->setPageId( $this->getVal('id') );
	    }
	     
	    $searchConfig
	    	->setStart	(  0 )
	    	->setSize	( 20 );
	     
	    $responseData = $this->wikiaSearch->getRelatedVideos( $searchConfig );
	    $this->response->setData($responseData);
	    $this->response->setFormat('json');
	}
	
	/**
	 * Delivers a JSON response for video searches
	 */
	public function videoSearch() {
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
	
	/**
	 * Delivers a JSON response with similar pages to a stream or URL.
	 * @throws Exception
	 */
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
	
	/**
	 * Delivers a JSON response with keywords from the page ID
	 */
	public function getKeywords() {
	    $id = $this->getVal('id');
	    if (empty($id)) {
	        throw new Exception('Please provide an ID');
	    }
	    $searchConfig = F::build('WikiaSearchConfig');
	    $searchConfig->setPageId( $id );
	    $responseData = $this->wikiaSearch->getKeywords( $searchConfig );
	    $this->response->setData( $responseData );
	    $this->response->setFormat( 'json' );
	}
	
	
	/**
	 * Controller Helper Methods
	 *----------------------------------------------------------------------------------*/

	/**
	 * Called in index action.
	 * Based on an article match and various settings, generates tracking events and routes user to appropriate page.
	 * @param WikiaSearchConfig $searchConfig
	 * @return boolean true (if not routed to search match page)
	 */
	private function handleArticleMatchTracking( WikiaSearchConfig $searchConfig ) {
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
		
		return true;
	}

	/**
	 * Called in index action. Sets the SearchConfigs namespaces based on MW-core NS request style.
	 * @param WikiaSearchConfig $searchConfig
	 * @return boolean true
	 */
	private function setNamespacesFromRequest( WikiaSearchConfig $searchConfig ) {
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
		
		return true;
	}
	
	/**
	 * Called in index action to manipulate the view based on the user's skin
	 * @return boolean true
	 */
	private function handleSkinSettings() {
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
		
		return true;
	}
	
	/**
	 * Called in index action. Determines whether to show search ads based on skin settings.
	 * @return boolean whether to show search ads, value used in the view
	 */
	private function showSearchAds() {
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

	/**
	 * Determines whether we are on the corporate wiki
	 */
	private function  isCorporateWiki() {
	    return !empty($this->wg->EnableWikiaHomePageExt);
	}
	
	/**
	 * Self-requests -- these shouldn't be directly called from the browser 
	 */
	
	/**
	 * This is how we generate the subtemplate for the advanced search box.
	 * @throws Exception
	 */
	public function advancedBox() {
		$config = $this->getVal('config', false);
		if (! $config ) {
			throw new Exception("This should not be called outside of self-request context.");
		}

		$this->setVal( 'term',  				$config->getQuery() );
		$this->setVal( 'bareterm', 				$config->getQuery() ); // query is stored as bareterm in config
		$this->setVal( 'namespaces', 			$config->getNamespaces() );
		$this->setVal( 'searchableNamespaces', 	SearchEngine::searchableNamespaces() );
		$this->setVal( 'redirs', 				$config->getIncludeRedirects() );
		$this->setVal( 'advanced', 				$config->getAdvanced() );
	}

	/**
	 * This is how we generate the search type tabs in the left-hand rail
	 * @throws Exception
	 */
	public function tabs() {
		$config = $this->getVal('config', false);
		if (! $config ) {
		    throw new Exception("This should not be called outside of self-request context.");
		}
		
		$this->setVal( 'bareterm', 			$config->getQuery() );
		$this->setVal( 'searchProfiles', 	$config->getSearchProfiles() );
		$this->setVal( 'redirs', 			$config->getIncludeRedirects() );
		$this->setVal( 'activeTab', 		$config->getActiveTab() );
	}

	/**
	 * This handles pagination via a template script. 
	 * @throws Exception
	 * @return boolean|null (false if we don't want pagination, fully routed to view via sendSelfRequest if we do want pagination) 
	 */
	public function pagination() {
		$config = $this->getVal('config', false);
		if (! $config ) {
			throw new Exception("This should not be called outside of self-request context.");
		}
		
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

	/**
	 * Controller-level Hooks
	 */
	
	/**
	 * WikiaMobile hook to add assets so they are minified and concatenated
	 * @param array $jsHeadPackages
	 * @param array $jsBodyPackages
	 * @param array $scssPackages
	 * @return boolean
	 */
	public function onWikiaMobileAssetsPackages( &$jsHeadPackages, &$jsBodyPackages, &$scssPackages){
		if( F::app()->wg->Title->isSpecial('Search') ) {
			$jsBodyPackages[] = 'wikiasearch_js_wikiamobile';
			$scssPackages[] = 'wikiasearch_scss_wikiamobile';
		}
		return true;
	}
}
