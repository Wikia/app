<?php
class WikiaSearchController extends WikiaSpecialPageController {

	const RESULTS_PER_PAGE = 25;
	const PAGES_PER_WINDOW = 5;

	/**
	 * Responsible for search queries
	 * @var WikiaSearch
	 */
	private $wikiaSearch;
	
	/**
	 * Responsible for building data used in indexing
	 * @var WikiaSearchIndexer
	 */
	private $wikiaSearchIndexer;

	/**
	 * Handles dependency-building and special page routing before calling controller actions 
	 */
	public function __construct() {
        // note: this is required since we haven't constructed $this->wg yet
		global $wgWikiaSearchIsDefault;
		// Solarium_Client dependency handled in class constructor call in WikiaSearch.setup.php
		$this->wikiaSearch			= F::build('WikiaSearch'); 
		$this->wikiaSearchIndexer	= F::build('WikiaSearchIndexer');
		$specialPageName 			= $wgWikiaSearchIsDefault ? 'Search' : 'WikiaSearch';

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

		$this->handleSkinSettings( $this->wg->User->getSkin() );

		$searchConfig = F::build('WikiaSearchConfig');
		
		$searchConfig
			->setQuery			( $this->getVal('query', $this->getVal('search') ) )
			->setCityId			( $this->wg->CityId )
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

		$this->setNamespacesFromRequest( $searchConfig, $this->wg->User );

		if($this->isCorporateWiki()) {
			OasisController::addBodyClass('inter-wiki-search');
		}

		if( $searchConfig->getQueryNoQuotes( true ) ) {
			$articleMatch = null;
			$this->wikiaSearch->getArticleMatch( $searchConfig );
			if ( $searchConfig->getPage() == 1 ) {
				$this->handleArticleMatchTracking( $searchConfig );
			}

			$this->wikiaSearch->doSearch( $searchConfig );

			$this->app->wg->Out->setPageTitle( $this->wf->msg( 'wikiasearch2-page-title-with-query', 
												array( ucwords( $searchConfig->getQuery( WikiaSearchConfig::QUERY_RAW ) ), $this->wg->Sitename) )  );
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
		$this->setVal( 'query',					$searchConfig->getQuery( WikiaSearchConfig::QUERY_ENCODED ) );
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
	     
	    $mltResult = $this->wikiaSearch->getRelatedVideos( $searchConfig );
	    
	    $responseData = array();
	    foreach ( $mltResult as $document ) {
	    	$responseData[$document['url']] = $document->getFields();
	    }
	    
	    $this->response->setData($responseData);
	    $this->response->setFormat('json');
	}
	
	/**
	 * Delivers a JSON response for video searches
	 */
	public function videoSearch() {
	    $searchConfig = F::build('WikiaSearchConfig');
	    $searchConfig
	    	->setCityId			( $this->wg->cityId )
	    	->setQuery			( $this->getVal('q') )
	    	->setNamespaces		( array(NS_FILE) )
	    	->setVideoSearch	( true )
	    ;
	    
	    $this->wikiaSearch->doSearch( $searchConfig );
	    // up to whoever's using this service as to what they want from here. I'm just going to return JSON.
	    // if you just want to search for only videos in the traditional video interface, then you should
	    // be setting 'videoSearch' in the query string of the search index page
	    $this->getResponse()->setFormat( 'json' );
	    $this->getResponse()->setData( ( $searchConfig->getResults() ) ? $searchConfig->getResults()->toNestedArray() : array() );
	
	}
	
	/**
	 * Delivers a JSON response with similar pages to a stream or URL.
	 * @throws Exception
	 */
	public function getSimilarPagesExternal() {
	    $searchConfig 	= F::build('WikiaSearchConfig');
	    $query 			= $this->getVal( 'q', null );
	    $url 			= $this->getVal( 'url', null );
	    $contents 		= $this->getVal( 'contents', null );
	    if ( $query !== null ) {
	    	$searchConfig->setQuery( $query );
	    } else if ( $url !== null ) {
	        $searchConfig->setStreamUrl( $url );
	    } else if ( $contents !== null ) {
	        $searchConfig->setStreamBody( $contents );
	    } else {
	        throw new Exception('Please provide a query, url or stream contents');
	    }
	    
	    $this->response->setData( $this->wikiaSearch->getSimilarPages( $searchConfig ) );
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
	    $searchConfig 	= F::build		('WikiaSearchConfig');
	    $searchConfig	->setPageId		( $id );
	    $responseData 	= $this->wikiaSearch->getKeywords( $searchConfig );
	    $this->response	->setData		( $responseData );
	    $this->response	->setFormat		( 'json' );
	}
	
	
	/**
	 * Controller Helper Methods
	 *----------------------------------------------------------------------------------*/

	/**
	 * Called in index action.
	 * Based on an article match and various settings, generates tracking events and routes user to appropriate page.
	 * @see    WikiaSearchControllerTest::testArticleMatchTracking
	 * @param  WikiaSearchConfig $searchConfig
	 * @return boolean true (if not routed to search match page)
	 */
	private function handleArticleMatchTracking( WikiaSearchConfig $searchConfig ) {
		$articleMatch	=	$searchConfig->getArticleMatch();
		$track			=	F::build( 'Track' );
		
		if ( !empty($articleMatch) && $this->getVal('fulltext', '0') === '0') {
		
		    $article = $articleMatch->getArticle();
		    
		    $title = $article->getTitle();
		
		    $this->wf->RunHooks( 'SpecialSearchIsgomatch', array( &$title, $searchConfig->getOriginalQuery() ) );
		
		    $track->event( 'search_start_gomatch', array( 'sterm' => $searchConfig->getOriginalQuery(), 'rver' => 0 ) );
		    $this->response->redirect( $title->getFullURL() );
		}
		elseif(! empty( $articleMatch ) ) {
		    $track->event( 'search_start_match', array( 'sterm' => $searchConfig->getOriginalQuery(), 'rver' => 0 ) );
		} else {
		    $title = F::build( 'Title', array( $searchConfig->getOriginalQuery() ), 'newFromText');
		    if ( $title !== null ) {
		        $this->wf->RunHooks( 'SpecialSearchNogomatch', array( &$title ) );
		    }
		}
		
		return true;
	}

	/**
	 * Called in index action. Sets the SearchConfigs namespaces based on MW-core NS request style.
	 * @see    WikiSearchControllerTest::testSetNamespacesFromRequest
	 * @param  WikiaSearchConfig $searchConfig
	 * @return boolean true
	 */
	private function setNamespacesFromRequest( WikiaSearchConfig $searchConfig, User $user ) {
		$searchEngine = F::build( 'SearchEngine' );
		$searchableNamespaces = $searchEngine->searchableNamespaces();
		$namespaces = array();
		foreach($searchableNamespaces as $i => $name) {
		    if ( $this->getVal('ns'.$i, false) ) {
		        $namespaces[] = $i;
		    }
		}
		if ( empty($namespaces) && $user->getOption('searchAllNamespaces')) {
		    $namespaces = array_keys($searchableNamespaces);
		}
		
		$searchConfig->setNamespaces( $namespaces );
		
		return true;
	}
	
	/**
	 * Called in index action to manipulate the view based on the user's skin
	 * @see    WikiaSearchControllerTest::testSkinSettings
	 * @param  SkinTemplate $skin
	 * @return boolean true
	 */
	private function handleSkinSettings( $skin ) {
	
		if ( $skin instanceof SkinMonoBook ) {
		    $this->response->addAsset ('extensions/wikia/Search/monobook/monobook.scss' );
		}
		if ( $skin instanceof SkinOasis ) {
		    $this->response->addAsset( 'extensions/wikia/Search/css/WikiaSearch.scss' );
		}
		if ( $skin instanceof SkinWikiaMobile ) {
		    $this->overrideTemplate( 'WikiaMobileIndex' );
		}
		
		return true;
	}

	/**
	 * Determines whether we are on the corporate wiki
	 * @see WikiaSearchControllerTest::testIsCorporateWiki
	 */
	private function  isCorporateWiki() {
	    return !empty($this->wg->EnableWikiaHomePageExt);
	}
	
	/**
	 * Self-requests -- these shouldn't be directly called from the browser 
	 */
	
	/**
	 * This is how we generate the subtemplate for the advanced search box.
	 * @see    WikiaSearchControllerTest::testAdvancedBox
	 * @throws Exception
	 */
	public function advancedBox() {
		$config = $this->getVal('config', false);
		if (! $config ) {
			throw new Exception("This should not be called outside of self-request context.");
		}

		$searchEngine = F::build( 'SearchEngine' );
		
		$this->setVal( 'namespaces', 			$config->getNamespaces() );
		$this->setVal( 'searchableNamespaces', 	$searchEngine->searchableNamespaces() );
		$this->setVal( 'redirs', 				$config->getIncludeRedirects() );
		$this->setVal( 'advanced', 				$config->getAdvanced() );
	}

	/**
	 * This is how we generate the search type tabs in the left-hand rail
	 * @see    WikiaSearchControllerTest::tabs
	 * @throws Exception
	 */
	public function tabs() {
		$config = $this->getVal('config', false);
		if (! $config || (! $config instanceOf WikiaSearchConfig ) ) {
		    throw new Exception("This should not be called outside of self-request context.");
		}
		
		$this->setVal( 'bareterm', 			$config->getQuery( WikiaSearchConfig::QUERY_RAW ) );
		$this->setVal( 'searchProfiles', 	$config->getSearchProfiles() );
		$this->setVal( 'redirs', 			$config->getIncludeRedirects() );
		$this->setVal( 'activeTab', 		$config->getActiveTab() );
	}

	/**
	 * This handles pagination via a template script. 
	 * @see    WikiaSearchControllerTest::testPagination
	 * @throws Exception
	 * @return boolean|null (false if we don't want pagination, fully routed to view via sendSelfRequest if we do want pagination) 
	 */
	public function pagination() {
		$config = $this->getVal('config', false);
		if (! $config || (! $config instanceOf WikiaSearchConfig ) ) {
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

		$this->setVal( 'query', 			$config->getQuery( WikiaSearchConfig::QUERY_RAW ) );
		$this->setVal( 'pagesNum', 			$config->getNumPages() );
		$this->setVal( 'currentPage', 		$page );
		$this->setVal( 'windowFirstPage', 	$windowFirstPage );
		$this->setVal( 'windowLastPage', 	$windowLastPage ); 
		$this->setVal( 'pageTitle', 		$this->wg->Title );
		$this->setVal( 'crossWikia', 		$config->getIsInterWiki() );
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
	 * @see    WikiaSearchControllerTest::testOnWikiaMobileAssetsPackages
	 * @param  array $jsHeadPackages
	 * @param  array $jsBodyPackages
	 * @param  array $scssPackages
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
