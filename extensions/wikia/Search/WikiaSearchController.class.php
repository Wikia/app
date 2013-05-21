<?php
/**
 * Class definition for WikiaSearchController.
 */
// Someday there will be a namespace declaration here.
/**
 * Responsible for handling search requests.
 * @author relwell
 * @package Search
 * @subpackage Controller
 */
class WikiaSearchController extends WikiaSpecialPageController {

	/**
	 * Default results per page for intra wiki search
	 * @var int
	 */
	const RESULTS_PER_PAGE = 25;

	/**
	 * Default results per page for inter wiki search
	 * @var int
	 */
	const INTERWIKI_RESULTS_PER_PAGE = 7;

	/**
	 * Default pages per window
	 * @var int
	 */
	const PAGES_PER_WINDOW = 5;
	
	/**
	 * Responsible for instantiating query services based on config.
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
		$this->queryServiceFactory = new Wikia\Search\QueryService\Factory;
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
		if ( $searchConfig->getQuery()->hasTerms() ) {
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

	    $opt = $params;
	    foreach( $namespaces as $n ) {
	        $opt['ns' . $n] = 1;
	    }

	    $stParams = array_merge( array( 'search' => $term ), $opt );

	    $title = F::build('SpecialPage', array( 'WikiaSearch' ), 'getTitleFor');

	    $this->setVal( 'class',     str_replace( ' ', '-', strtolower( $label ) ) );
	    $this->setVal( 'href',      $title->getLocalURL( $stParams ) );
	    $this->setVal( 'title',     $tooltip );
	    $this->setVal( 'label',     $label );
	    $this->setVal( 'tooltip',   $tooltip );
	}
	
	/**
	 * Delivers a JSON response for video searches
	 */
	public function videoSearch() {
	    $searchConfig = new Wikia\Search\Config();
	    $searchConfig
	    	->setCityId         ( $this->wg->CityId )
	    	->setQuery          ( $this->getVal('q') )
	    	->setNamespaces     ( array(NS_FILE) )
	    	->setVideoSearch    ( true )
	    ;
		$wikiaSearch = $this->queryServiceFactory->getFromConfig( $searchConfig ); 
	    $this->getResponse()->setFormat( 'json' );
	    $this->getResponse()->setData( $wikiaSearch->searchAsApi() );

	}
	
	/**
	 * Delivers a JSON response for videos matching a provided title
	 * Expects query param "title" for the title value.
	 */
	public function searchVideosByTitle() {
		$searchConfig = new Wikia\Search\Config;
		$title = $this->getVal( 'title' );
		if ( empty( $title ) ) {
			throw new Exception( "Please include a value for 'title'." );
		}
		$searchConfig
		    ->setVideoTitleSearch( true )
		    ->setQuery( $title );
		$this->getResponse()->setFormat( 'json' );
		$this->getResponse()->setData( $this->queryServiceFactory->getFromConfig( $searchConfig )->searchAsApi() );
	}
	
	/**
	 * Delivers a JSON response for infoboxes for a given page ID
	 * @todo find a better place for this
	 */
	public function getInfoboxes() {
		$expectedIds = explode( '|', $this->getRequest()->getVal( 'ids', '' ) );
		if ( empty( $expectedIds ) ) {
			throw new InvalidParameterApiException( 'ids' );
		}
		$response = $this->getResponse();
		$response->setFormat( 'json' );
		$response->setData( (new InfoboxesService())->getForPageIds( $expectedIds ) );
		
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
		$query = $searchConfig->getQuery()->getSanitizedQuery();
		if ( $searchConfig->hasArticleMatch() ) {
			$article = Article::newFromID( $searchConfig->getArticleMatch()->getId() );
			$title = $article->getTitle();
			$track = new Track();
			if ( $this->getVal('fulltext', '0') === '0') {
				$this->wf->RunHooks( 'SpecialSearchIsgomatch', array( $title, $query ) );
				$track->event( 'search_start_gomatch', array( 'sterm' => $query, 'rver' => 0 ) );
				$this->response->redirect( $title->getFullUrl() );
			} else {
				$track->event( 'search_start_match', array( 'sterm' => $query, 'rver' => 0 ) );
			}
		} else {
			$title = Title::newFromText( $query );
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
		$resultsPerPage = $this->isCorporateWiki() ? self::INTERWIKI_RESULTS_PER_PAGE : self::RESULTS_PER_PAGE;
		$resultsPerPage = empty( $this->wg->SearchResultsPerPage ) ? $resultsPerPage : $this->wg->SearchResultsPerPage;
		$searchConfig
			->setQuery                   ( $this->getVal( 'query', $this->getVal( 'search' ) ) )
			->setCityId                  ( $this->wg->CityId )
			->setLimit                   ( $this->getVal( 'limit', $resultsPerPage ) )
			->setPage                    ( $this->getVal( 'page', 1) )
			->setRank                    ( $this->getVal( 'rank', 'default' ) )
			->setAdvanced                ( $this->getRequest()->getBool( 'advanced', false ) )
			->setHub                     ( $this->getVal( 'hub', false ) )
			->setInterWiki               ( $this->isCorporateWiki() )
			->setVideoSearch             ( $this->getVal( 'videoSearch', false ) )
			->setFilterQueriesFromCodes  ( $this->getVal( 'filters', array() ) )
		;
		$this->setNamespacesFromRequest( $searchConfig, $this->wg->User );
		if ( substr( $this->getResponse()->getFormat(), 0, 4 ) == 'json' ) {
			$requestedFields = $searchConfig->getRequestedFields();
			$jsonFields = $this->getVal( 'jsonfields' );
			if (! empty( $jsonFields ) ) {
				foreach ( explode( ',', $jsonFields ) as $field ) {
					if (! in_array( $field, $requestedFields ) ) {
						$requestedFields[] = $field;
					}
				}
				$searchConfig->setRequestedFields( $requestedFields );
			}
		}
		return $searchConfig;
	}
	
	/**
	 * Sets values for the view to work with during index method.
	 * @param Wikia\Search\Config $searchConfig
	 */
	protected function setResponseValuesFromConfig( Wikia\Search\Config $searchConfig ) {

		global $wgExtensionsPath;

		$response = $this->getResponse();
		$format = $response->getFormat();
		if ( $format == 'json' || $format == 'jsonp' ){
			$response->setData( $searchConfig->getResults()->toArray( explode( ',', $this->getVal( 'jsonfields', 'title,url,pageid' ) ) ) );
			return;
		}
		if(! $searchConfig->getInterWiki() ) {
			$this->setVal( 'advancedSearchBox', $this->sendSelfRequest( 'advancedBox', array( 'config' => $searchConfig ) ) );
		}
		$tabsArgs = array(
				'config'		=> $searchConfig,
				'by_category'	=> $this->getVal( 'by_category', false ),
				'filters'       => $this->getVal( 'filters', array() ),
				);
		$this->setVal( 'results',               $searchConfig->getResults() );
		$this->setVal( 'resultsFound',          $searchConfig->getResultsFound() );
		$this->setVal( 'resultsFoundTruncated', $searchConfig->getTruncatedResultsNum( true ) );
		$this->setVal( 'isOneResultsPageOnly',  $searchConfig->getNumPages() < 2 );
		$this->setVal( 'pagesCount',            $searchConfig->getNumPages() );
		$this->setVal( 'currentPage',           $searchConfig->getPage() );
		$this->setVal( 'paginationLinks',       $this->sendSelfRequest( 'pagination', $tabsArgs ) );
		$this->setVal( 'tabs',                  $this->sendSelfRequest( 'tabs', $tabsArgs ) );
		$this->setVal( 'query',                 $searchConfig->getQuery()->getQueryForHtml() );
		$this->setVal( 'resultsPerPage',        $searchConfig->getLimit() );
		$this->setVal( 'pageUrl',               $this->wg->Title->getFullUrl() );
		$this->setVal( 'isInterWiki',           $searchConfig->getInterWiki() );
		$this->setVal( 'namespaces',            $searchConfig->getNamespaces() );
		$this->setVal( 'hub',                   $searchConfig->getHub() );
		$this->setVal( 'hasArticleMatch',       $searchConfig->hasArticleMatch() );
		$this->setVal( 'isMonobook',            ( $this->wg->User->getSkin() instanceof SkinMonobook ) );
		$this->setVal( 'isCorporateWiki',       $this->isCorporateWiki() );
		$this->setVal( 'wgExtensionsPath',      $wgExtensionsPath);
		
		if ( $this->wg->OnWikiSearchIncludesWikiMatch && $searchConfig->hasWikiMatch() ) {
			$this->registerWikiMatch( $searchConfig );
		}
	}
	
	/**
	 * Sets wiki match view script variable in view
	 * @param Wikia\Search\Config $searchConfig
	 */
	protected function registerWikiMatch( Wikia\Search\Config $searchConfig ) {
		//check if corporate wiki or community wiki
		if ( !$this->isCorporateWiki() && $this->wg->CityId != 177 ) {
			return;
		}

		$resultSet = new Wikia\Search\ResultSet\MatchGrouping( new Wikia\Search\ResultSet\DependencyContainer( ['config' => $searchConfig, 'wikiMatch' => $searchConfig->getWikiMatch() ] ) );

		$image = $resultSet->getHeader( 'image' );
		$imageUrl = empty( $image ) ? $this->wg->ExtensionsPath . '/wikia/Search/images/wiki_image_placeholder.png' : (new \WikiaHomePageHelper)->getImageUrl( $image, 180, 120 );
		$thumbTracking = 'class="wiki-thumb-tracking" data-pos="-1" data-event="search_click_wiki-';
		$thumbTracking .= empty( $image ) ? 'no-thumb"' : 'thumb"';

		//use default exacteResult template
		$template = 'exactResult';
		if ( $this->isCorporateWiki() ) {
			$template = 'CrossWiki_exactResult';
		}
		$this->setVal(
				'wikiMatch',
				$this->getApp()->getView( 'WikiaSearch', $template,
						[ 'pos' => -1, 
						'resultSet' => $resultSet, 
						'pagesMsg' => $resultSet->getArticlesCountMsg(), 
						'imgMsg' => $resultSet->getImagesCountMsg(), 
						'videoMsg' => $resultSet->getVideosCountMsg(), 
						'imageURL' => $imageUrl,
						'thumbTracking' => $thumbTracking
						]
						) 
				);
	}
	
	/**
	 * Sets the page title during index method.
	 * @param Wikia\Search\Config $searchConfig
	 */
	protected function setPageTitle( Wikia\Search\Config $searchConfig ) {
		if ( $searchConfig->getQuery()->hasTerms() ) {
			$this->wg->Out->setPageTitle( $this->wf->msg( 'wikiasearch2-page-title-with-query',
												array( ucwords( $searchConfig->getQuery()->getSanitizedQuery() ), $this->wg->Sitename) )  );
		}
		else {
			if( $searchConfig->getInterWiki() ) {
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
	 * @param  User $user 
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
			$this->overrideTemplate('CrossWiki_index');
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
		if( $is_video_wiki && $form['no_filter'] == 1 && !in_array( 'no_filter', $this->getVal( 'filters', array() ) ) ) {
			$form['is_video'] = 1;
			$form['no_filter'] = 0;
		}

		$this->setVal( 'bareterm', 			$config->getQuery()->getSanitizedQuery() );
		$this->setVal( 'searchProfiles', 	$config->getSearchProfiles() );
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

		$this->setVal( 'query', 			$config->getQuery()->getSanitizedQuery() );
		$this->setVal( 'pagesNum', 			$config->getNumPages() );
		$this->setVal( 'currentPage', 		$page );
		$this->setVal( 'windowFirstPage', 	$windowFirstPage );
		$this->setVal( 'windowLastPage', 	$windowLastPage );
		$this->setVal( 'pageTitle', 		$this->wg->Title );
		$this->setVal( 'crossWikia', 		$config->getInterWiki() );
		$this->setVal( 'resultsCount', 		$config->getResultsFound() );
		$this->setVal( 'namespaces', 		$config->getNamespaces() );
		$this->setVal( 'advanced', 			$config->getAdvanced() );
		$this->setVal( 'limit', 			$config->getLimit() );
		$this->setVal( 'filters',			$config->getPublicFilterKeys() );
		$this->setVal( 'rank', 				$config->getRank() );
		$this->setVal( 'by_category', 		$this->getVal('by_category', false) );

	}
}
