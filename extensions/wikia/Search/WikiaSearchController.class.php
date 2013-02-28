<?php
/**
 * Class definition for WikiaSearchController. Responsible for handling search requests.
 * @author relwell
 */
class WikiaSearchController extends WikiaSpecialPageController {

	/**
	 * Default results per page
	 * @var int
	 */
	const RESULTS_PER_PAGE = 25;
	/**
	 * Default pages per window
	 * @var int
	 */
	const PAGES_PER_WINDOW = 5;
	
	/**
	 * @var Wikia\Search\QueryService\Factory
	 */
	protected $queryServiceFactory;

	/**
	 * Handles dependency-building and special page routing before calling controller actions
	 */
	public function __construct() {
        // note: this is required since we haven't constructed $this->wg yet
		global $wgWikiaSearchIsDefault;
		$specialPageName = $wgWikiaSearchIsDefault ? 'Search' : 'WikiaSearch';
		$this->queryServiceFactory = Wikia\Search\QueryService\Factory::getInstance();
		parent::__construct( $specialPageName, $specialPageName, false );
	}

	/**
	 * Controller Actions
	 *---------------------------------------------------------------------------------*/

	/**
	 * This is the main search action. Special:Search points here.
	 */
	public function index() {
		$this->handleSkinSettings();
		$searchConfig = $this->getSearchConfigFromRequest();
		
		if( $searchConfig->getQueryNoQuotes( true ) ) {
			$search = $this->queryServiceFactory->getFromConfig( $searchConfig);
			// explicity called to accommodate go-search
			$search->getMatch();
			$this->handleArticleMatchTracking( $searchConfig );
			$search->search();
		}
		
		$this->setPageTitle( $searchConfig );
		$this->setResponseValuesFromConfig( $searchConfig );
	}
	
	
	/**
	 * Sets values for the view to work with.
	 * @param Wikia\Search\Config $searchConfig
	 */
	protected function setResponseValuesFromConfig( Wikia\Search\Config $searchConfig ) {
		$format = $this->response->getFormat();
		if ( ( $format == 'json' || $format == 'jsonp' ) && ( $searchConfig->getResultsFound() > 0 ) ){
			$searchConfig->setResults( $searchConfig->getResults()->toNestedArray() );
		}
		if(! $searchConfig->getIsInterWiki() ) {
			$this->setVal( 'advancedSearchBox', $this->sendSelfRequest( 'advancedBox', array( 'config' => $searchConfig ) ) );
		}

		$format = $this->response->getFormat();
		if( ($format == 'json' || $format == 'jsonp') && ($searchConfig->getResultsFound() > 0) ){
			$searchConfig->setResults( $searchConfig->getResults()->toNestedArray( array( 'title', 'url', 'pageid' ) ) );
		}

		$tabsArgs = array(
				'config'		=> $searchConfig,
				'by_category'	=> $this->getVal( 'by_category', false )
				);
		$this->setVal( 'results',				$searchConfig->getResults() );
		$this->setVal( 'resultsFound',			$searchConfig->getResultsFound() );
		$this->setVal( 'resultsFoundTruncated', $this->wg->Lang->formatNum( $searchConfig->getTruncatedResultsNum() ) );
		$this->setVal( 'isOneResultsPageOnly',	$searchConfig->getNumPages() < 2 );
		$this->setVal( 'pagesCount', 			$searchConfig->getNumPages() );
		$this->setVal( 'currentPage', 			$searchConfig->getPage() );
		$this->setVal( 'paginationLinks',		$this->sendSelfRequest( 'pagination', $tabsArgs ) );
		$this->setVal( 'tabs', 					$this->sendSelfRequest( 'tabs', $tabsArgs ) );
		$this->setVal( 'query',					$searchConfig->getQuery( Wikia\Search\Config::QUERY_ENCODED ) );
		$this->setVal( 'resultsPerPage',		$searchConfig->getLimit() );
		$this->setVal( 'pageUrl',				$this->wg->Title->getFullUrl() );
		$this->setVal( 'debug',					$searchConfig->getDebug() );
		$this->setVal( 'solrHost',				$this->wg->SolrHost);
		$this->setVal( 'isInterWiki',			$searchConfig->getIsInterWiki() );
		$this->setVal( 'relevancyFunctionId',	6 ); //@todo do we need this?
		$this->setVal( 'namespaces',			$searchConfig->getNamespaces() );
		$this->setVal( 'hub',					$searchConfig->getHub() );
		$this->setVal( 'hasArticleMatch',		$searchConfig->hasArticleMatch() );
		$this->setVal( 'isMonobook',			($this->wg->User->getSkin() instanceof SkinMonobook) );
		$this->setVal( 'isCorporateWiki',		$this->isCorporateWiki() );
	}
	
	/**
	 * Deprecated functionality for indexing.
	 */
	public function getPages() {
		$this->wg->AllowMemcacheWrites = false;
		$indexer = new Wikia\Search\Indexer();
		$this->getResponse()->setData( $indexer->getPages( explode( '|', $this->getVal( 'ids' ) ) ) );
		$this->getResponse()->setFormat( 'json' );
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

	    $this->setVal( 'class',     str_replace( ' ', '-', strtolower( $label ) ) );
	    $this->setVal( 'href',		$title->getLocalURL( $stParams ) );
	    $this->setVal( 'title',		$tooltip );
	    $this->setVal( 'label',		$label );
	    $this->setVal( 'tooltip',	$tooltip );
	}
	
	/**
	 * Delivers a JSON response for video searches
	 */
	public function videoSearch() {
	    $searchConfig = new Wikia\Search\Config();
	    $searchConfig
	    	->setCityId			( $this->wg->CityId )
	    	->setQuery			( $this->getVal('q') )
	    	->setNamespaces		( array(NS_FILE) )
	    	->setVideoSearch	( true )
	    ;
		$wikiaSearch = $this->queryServiceFactory->getFromConfig( $searchConfig ); 
	    $results = $wikiaSearch->search();
	    $this->getResponse()->setFormat( 'json' );
	    $this->getResponse()->setData( $results->toNestedArray() );

	}

	/**
	 * Controller Helper Methods
	 *----------------------------------------------------------------------------------*/

	/**
	 * Called in index action.
	 * Based on an article match and various settings, generates tracking events and routes user to appropriate page.
	 * @param  Wikia\Search\Config $searchConfig
	 * @return boolean true if on page 1 and not routed, false if not on page 1 
	 */
	protected function handleArticleMatchTracking( Wikia\Search\Config $searchConfig ) {
		if ( $searchConfig->getPage() != 1 ) {
			return false;
		}
		$title = Title::newFromText( $searchConfig->getOriginalQuery() );
		$track = new Track();
		if ( $searchConfig->hasArticleMatch() && $this->getVal('fulltext', '0') === '0') {

		    $this->wf->RunHooks( 'SpecialSearchIsgomatch', array( $title, $searchConfig->getOriginalQuery() ) );

		    $track->event( 'search_start_gomatch', array( 'sterm' => $searchConfig->getOriginalQuery(), 'rver' => 0 ) );
		    $this->response->redirect( $title->getFullUrl() );
		}
		else if ( $searchConfig->hasArticlematch() ) {
		    $track->event( 'search_start_match', array( 'sterm' => $searchConfig->getOriginalQuery(), 'rver' => 0 ) );
		} else {
		    if ( $title !== null ) {
		        $this->wf->RunHooks( 'SpecialSearchNogomatch', array( &$title ) );
		    }
		}

		return true;
	}
	
	/**
	 * Passes the appropriate values to the config object from the request during index method.
	 * @return \Wikia\Search\Config
	 */
	protected function getSearchConfigFromRequest() {
		$searchConfig = new Wikia\Search\Config();
		$resultsPerPage = empty( $this->wg->SearchResultsPerPage ) ? self::RESULTS_PER_PAGE : $this->wg->SearchResultsPerPage;
		$searchConfig
			->setQuery                   ( $this->getVal( 'query', $this->getVal( 'search' ) ) )
			->setCityId                  ( $this->wg->CityId )
			->setLimit                   ( $this->getVal( 'limit', $resultsPerPage ) )
			->setPage                    ( $this->getVal( 'page', 1) )
			->setRank                    ( $this->getVal( 'rank', 'default' ) )
			->setAdvanced                ( $this->getRequest()->getBool( 'advanced', false ) )
			->setHub                     ( $this->getVal( 'hub', false ) )
			->setIsInterWiki             ( $this->isCorporateWiki() )
			->setVideoSearch             ( $this->getVal( 'videoSearch', false ) )
			->setGroupResults            ( $searchConfig->isInterWiki() )
			->setFilterQueriesFromCodes  ( $this->getVal( 'filters', array() ) )
		;
		$this->setNamespacesFromRequest( $searchConfig, $this->wg->User );
		return $searchConfig;
	}
	
	/**
	 * Sets values for the view to work with during index method.
	 * @param Wikia\Search\Config $searchConfig
	 */
	protected function setResponseValuesFromConfig( Wikia\Search\Config $searchConfig ) {
		$format = $this->response->getFormat();
		if ( ( $format == 'json' || $format == 'jsonp' ) && ( $searchConfig->getResultsFound() > 0 ) ){
			$searchConfig->setResults( $searchConfig->getResults()->toNestedArray() );
		}
		if(! $searchConfig->getIsInterWiki() ) {
			$this->setVal( 'advancedSearchBox', $this->sendSelfRequest( 'advancedBox', array( 'config' => $searchConfig ) ) );
		}
		$tabsArgs = array(
				'config'		=> $searchConfig,
				'by_category'	=> $this->getVal( 'by_category', false )
				);
		$this->setVal( 'results',				$searchConfig->getResults() );
		$this->setVal( 'resultsFound',			$searchConfig->getResultsFound() );
		$this->setVal( 'resultsFoundTruncated', $this->wg->Lang->formatNum( $searchConfig->getTruncatedResultsNum() ) );
		$this->setVal( 'isOneResultsPageOnly',	$searchConfig->getNumPages() < 2 );
		$this->setVal( 'pagesCount', 			$searchConfig->getNumPages() );
		$this->setVal( 'currentPage', 			$searchConfig->getPage() );
		$this->setVal( 'paginationLinks',		$this->sendSelfRequest( 'pagination', $tabsArgs ) );
		$this->setVal( 'tabs', 					$this->sendSelfRequest( 'tabs', $tabsArgs ) );
		$this->setVal( 'query',					$searchConfig->getQuery( Wikia\Search\Config::QUERY_ENCODED ) );
		$this->setVal( 'resultsPerPage',		$searchConfig->getLimit() );
		$this->setVal( 'pageUrl',				$this->wg->Title->getFullUrl() );
		$this->setVal( 'debug',					$searchConfig->getDebug() );
		$this->setVal( 'solrHost',				$this->wg->SolrHost);
		$this->setVal( 'isInterWiki',			$searchConfig->getIsInterWiki() );
		$this->setVal( 'relevancyFunctionId',	6 ); //@todo do we need this?
		$this->setVal( 'namespaces',			$searchConfig->getNamespaces() );
		$this->setVal( 'hub',					$searchConfig->getHub() );
		$this->setVal( 'hasArticleMatch',		$searchConfig->hasArticleMatch() );
		$this->setVal( 'isMonobook',			($this->wg->User->getSkin() instanceof SkinMonobook) );
		$this->setVal( 'isCorporateWiki',		$this->isCorporateWiki() );
	}
	
	/**
	 * Sets the page title during index method.
	 * @param Wikia\Search\Config $searchConfig
	 */
	protected function setPageTitle( Wikia\Search\Config $searchConfig ) {
		if ( $searchConfig->getQueryNoQuotes( true ) ) {
			$this->wg->Out->setPageTitle( $this->wf->msg( 'wikiasearch2-page-title-with-query',
												array( ucwords( $searchConfig->getQuery( Wikia\Search\Config::QUERY_RAW ) ), $this->wg->Sitename) )  );
		}
		else {
			if( $searchConfig->getIsInterWiki() ) {
				$this->wg->Out->setPageTitle( $this->wf->msg( 'wikiasearch2-page-title-no-query-interwiki' ) );
			} else {
				$this->wg->Out->setPageTitle( $this->wf->msg( 'wikiasearch2-page-title-no-query-intrawiki',
													array($this->wg->Sitename) )  );
			}
		}
	}

	/**
	 * Called in index action. Sets the SearchConfigs namespaces based on MW-core NS request style.
	 * @see    WikiSearchControllerTest::testSetNamespacesFromRequest
	 * @param  Wikia\Search\Config $searchConfig
	 * @todo return type hinting when we live in a saner world of unit testing
	 * @return boolean true
	 */
	protected function setNamespacesFromRequest( $searchConfig, User $user ) {
		$searchEngine = F::build( 'SearchEngine' );
		$searchableNamespaces = $searchEngine->searchableNamespaces();
		$namespaces = array();
		foreach( $searchableNamespaces as $i => $name ) {
		    if ( $this->getVal( 'ns'.$i, false ) ) {
		        $namespaces[] = $i;
		    }
		}
		if ( empty($namespaces) ) {
		    if ( $user->getOption( 'searchAllNamespaces' ) ) {
			    $namespaces = array_keys($searchableNamespaces);
		    } else {
		    	$profiles = $searchConfig->getSearchProfiles();
		    	// this is mostly needed for unit testing
		    	$defaultProfile = !empty( $this->wg->DefaultSearchProfile ) ? $this->wg->DefaultSearchProfile : 'default';
		    	$namespaces = $profiles[$defaultProfile]['namespaces'];
		    }

		}
		$searchConfig->setNamespaces( $namespaces );

		return true;
	}

	/**
	 * Called in index action to manipulate the view based on the user's skin
	 * @return boolean true
	 */
	protected function handleSkinSettings() {
		$this->wg->Out->addHTML( F::build('JSSnippets')->addToStack( array( "/extensions/wikia/Search/js/WikiaSearch.js" ) ) );
		$this->wg->SuppressRail = true;
		if ($this->isCorporateWiki() ) {
			OasisController::addBodyClass('inter-wiki-search');
		}
		$skin = $this->wg->User->getSkin();
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
	protected function  isCorporateWiki() {
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
		if (! $config instanceof Wikia\Search\Config ) {
			throw new Exception("This should not be called outside of self-request context.");
		}

		$searchEngine = F::build( 'SearchEngine' );

		$searchableNamespaces = $searchEngine->searchableNamespaces();

		wfRunHooks( 'AdvancedBoxSearchableNamespaces', array( &$searchableNamespaces ) );

		$this->setVal( 'namespaces', 			$config->getNamespaces() );
		$this->setVal( 'searchableNamespaces', 	$searchableNamespaces );
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

		if (! $config || (! $config instanceOf Wikia\Search\Config ) ) {
		    throw new Exception("This should not be called outside of self-request context.");
		}

		$filters = $config->getFilterQueries();
		$rank = $config->getRank();
		$is_video_wiki = $this->wg->CityId == Wikia\Search\QueryService\Select\Video::VIDEO_WIKI_ID;

		$form = array(
				'by_category' =>        $this->getVal('by_category', false),
				'cat_videogames' =>     isset( $filters['cat_videogames'] ),
				'cat_entertainment' =>  isset( $filters['cat_entertainment'] ),
				'cat_lifestyle' =>      isset( $filters['cat_lifestyle'] ),
				'is_hd' =>              isset( $filters['is_hd'] ),
				'is_image' =>           isset( $filters['is_image'] ),
				'is_video' =>           isset( $filters['is_video'] ),
				'sort_default' =>       $rank == 'default',
				'sort_longest' =>       $rank == 'longest',
				'sort_newest' =>        $rank == 'newest',
				'no_filter' =>          !( isset( $filters['is_image'] ) || isset( $filters['is_video'] ) ),
			);

		// Set video wiki to display only videos by default
		if( $is_video_wiki && $form['no_filter'] == 1 ) {
			$form['is_video'] = 1;
			$form['no_filter'] = 0;
		}

		$this->setVal( 'bareterm', 			$config->getQuery( Wikia\Search\Config::QUERY_RAW ) );
		$this->setVal( 'searchProfiles', 	$config->getSearchProfiles() );
		$this->setVal( 'redirs', 			$config->getIncludeRedirects() );
		$this->setVal( 'activeTab', 		$config->getActiveTab() );
		$this->setVal( 'form',				$form );
		$this->setVal( 'is_video_wiki',		$is_video_wiki );
	}

	/**
	 * This handles pagination via a template script.
	 * @see    WikiaSearchControllerTest::testPagination
	 * @throws Exception
	 * @return boolean|null (false if we don't want pagination, fully routed to view via sendSelfRequest if we do want pagination)
	 */
	public function pagination() {
		$config = $this->getVal('config', false);
		if (! $config || (! $config instanceOf Wikia\Search\Config ) ) {
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

		$this->setVal( 'query', 			$config->getQuery( Wikia\Search\Config::QUERY_RAW ) );
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
		$this->setVal( 'filters',			$config->getPublicFilterKeys() );
		$this->setVal( 'rank', 				$config->getRank() );
		$this->setVal( 'by_category', 		$this->getVal('by_category', false) );

	}
}
