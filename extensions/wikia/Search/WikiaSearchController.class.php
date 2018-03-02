<?php
/**
 * Class definition for WikiaSearchController.
 */

use \Wikia\Logger\WikiaLogger;
use \Wikia\Search\Result\ResultHelper;

/**
 * Responsible for handling search requests.
 *
 * @author relwell
 * @package Search
 * @subpackage Controller
 */
class WikiaSearchController extends WikiaSpecialPageController {

	use Wikia\Search\Traits\NamespaceConfigurable;

	/**
	 * Default results per page for intra wiki search
	 *
	 * @var int
	 */
	const RESULTS_PER_PAGE = 25;

	/**
	 * Default results per page for inter wiki search
	 *
	 * @var int
	 */
	const INTERWIKI_RESULTS_PER_PAGE = 10;

	/**
	 * Default pages per window
	 *
	 * @var int
	 */
	const PAGES_PER_WINDOW = 5;

	/**
	 * Default sufix for result template
	 *
	 * @var string
	 */
	const WIKIA_DEFAULT_RESULT = 'result';

	/**
	 * On what max position title can occur and still snippet will be cutted shorter
	 *
	 * @var int
	 */
	const SNIPPET_SUBSTR = 9;

	const EXACT_WIKI_MATCH_THUMBNAIL_HEIGHT = 200;
	const EXACT_WIKI_MATCH_THUMBNAIL_WIDTH = 300;

	const CROSS_WIKI_PROMO_THUMBNAIL_HEIGHT = 120;
	const CROSS_WIKI_PROMO_THUMBNAIL_WIDTH = 180;

	const FANDOM_STORIES_MEMC_KEY = 'fandom-stories-memcache-key';
	const FANDOM_SEARCH_PAGE = 'http://fandom.wikia.com/?s=';

	const NUMBER_OF_ITEMS_IN_FANDOM_STORIES_MODULE = 5;

	/**
	 * Responsible for instantiating query services based on config.
	 *
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
		global $wgEnableSpecialSearchCaching;

		$this->handleSkinSettings();
		//will change template depending on passed ab group
		$searchConfig = $this->getSearchConfigFromRequest();

		if ( !empty( $wgEnableSpecialSearchCaching ) ) {
			$this->setVarnishCacheTime( WikiaResponse::CACHE_STANDARD );
		}

		$this->handleLayoutAbTest( $this->getVal( 'ab', null ), $searchConfig->getNamespaces() );
		if ( $searchConfig->getQuery()->hasTerms() ) {
			$search = $this->queryServiceFactory->getFromConfig( $searchConfig );
			/* @var $search Wikia\Search\QueryService\Select\Dismax\OnWiki */
			$search->getMatch();

			$this->handleArticleMatchTracking( $searchConfig );
			$search->search();
		}

		$this->setPageTitle( $searchConfig );
		$this->setResponseValuesFromConfig( $searchConfig );
	}

	/**
	 * Accesses top wiki articles for right rail, see PLA-466
	 */
	public function topWikiArticles() {
		$this->response->setVal( 'pages', $this->getVal( 'pages', [] ) );
	}

	public function fandomStories() {
		$this->response->setValues(
			[
				'stories' => $this->getVal( 'stories', [] ),
				'viewMoreLink' => $this->getVal( 'viewMoreLink', null ),
			]
		);
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
		$term = $this->getVal( 'term' );
		$namespaces = $this->getVal( 'namespaces' );
		$label = $this->getVal( 'label' );
		$tooltip = $this->getVal( 'tooltip' );
		$params = $this->getVal( 'params' );

		$opt = $params;
		foreach ( $namespaces as $n ) {
			$opt['ns' . $n] = 1;
		}

		$stParams = array_merge( [ 'search' => $term ], $opt );

		$title = SpecialPage::getTitleFor( 'Search' );

		$this->setVal( 'class', str_replace( ' ', '-', strtolower( $label ) ) );
		$this->setVal( 'href', $title->getLocalURL( $stParams ) );
		$this->setVal( 'title', $tooltip );
		$this->setVal( 'label', $label );
		$this->setVal( 'tooltip', $tooltip );
	}

	/**
	 * Delivers a JSON response for video searches
	 */
	public function videoSearch() {
		$searchConfig = new Wikia\Search\Config();
		$searchConfig->setCityId( $this->wg->CityId )
			->setQuery( $this->getVal( 'q' ) )
			->setNamespaces( [ NS_FILE ] )
			->setVideoSearch( true );
		$wikiaSearch = $this->queryServiceFactory->getFromConfig( $searchConfig );
		$this->getResponse()->setFormat( 'json' );
		$this->getResponse()->setData( $wikiaSearch->searchAsApi() );
	}

	/**
	 * Given a "title" parameter, tests if there's a near match, and then returns the canonical title
	 */
	public function resolveEntities() {
		$request = $this->getRequest();
		$entities = explode( '|', $request->getVal( 'entities' ) );
		$entityResponse = [];
		$service = new Wikia\Search\MediaWikiService();
		foreach ( $entities as $entity ) {
			$match = $service->getArticleMatchForTermAndNamespaces( $entity, $this->wg->ContentNamespaces );
			$entityResponse[$entity] = ( $match === null ) ? '' : $match->getResult()->getTitle();
		}
		$response = $this->getResponse();
		$response->setFormat( 'json' );
		$response->setData( $entityResponse );
	}

	/**
	 * JSON service that supports the access of video (and optionally photo) content from the current wiki
	 *
	 *  Request params:
	 *  -- q (required) the query
	 *  -- videoOnly (optional) whether to only include videos (false by default)
	 *  -- next (optional) pagination value
	 *
	 */
	public function combinedMediaSearch() {
		$request = $this->getRequest();
		$query = $request->getVal( 'q' );
		if ( strlen( $query ) == 0 ) {
			throw new Exception( "Please include a query value for parameter 'q'" );
		}
		$config = new Wikia\Search\Config;
		$videoOnly = (bool) $request->getVal( 'videoOnly', false );
		$config->setQuery( $query )
			->setCombinedMediaSearch( true )
			->setCombinedMediaSearchIsVideoOnly( $videoOnly )
			->setLimit( 4 )
			->setStart( $this->getVal( 'next', 0 ) );

		$results = $this->queryServiceFactory->getFromConfig( $config )->searchAsApi(
			[ 'url', 'id', 'pageid', 'wid', 'title' ],
			true
		);
		$dimensions = [ 'width' => 120, 'height' => 90 ];
		$service = new \Wikia\Search\MediaWikiService();
		foreach ( $results['items'] as &$result ) {
			if ( !isset( $result['thumbnail'] ) ) {
				$result['thumbnail'] = $service->getThumbnailHtmlFromFileTitle( $result['title'], $dimensions );
			}
		}
		$title = SpecialPage::getTitleFor( "Search" );
		$results['videoUrl'] = $title->getLocalURL(
			[
				'ns6' => 1,
				'fulltext' => 'Search',
				'search' => $query,
				'filters[]' => $videoOnly ? 'is_video' : ''
			]
		);

		$response = $this->getResponse();
		$response->setFormat( 'json' );
		$response->setData( $results );
	}

	/**
	 * Powers the category page view
	 */
	public function categoryTopArticles() {
		$pages = [];
		$category = '';
		$result = $this->getVal( 'result' );
		if ( !empty( $result ) ) {
			try {
				$category = $result['title'];
				$colonSploded = explode( ':', $category );
				$namespace = ( new Wikia\Search\MediaWikiService )->getNamespaceIdForString( $colonSploded[0] );
				// remove "Category:", since it doesn't work with ArticlesApiController
				$category = ( is_int( $namespace ) && $namespace == NS_CATEGORY ) ?
					implode( ':', array_slice( $colonSploded, 1 ) ) : $category;
				//@todo use single API call here when expansion is released
				$pageData = $this->app->sendRequest(
					'ArticlesApiController',
					'getTop',
					[ 'namespaces' => 0, 'category' => $category ]
				)->getData();
				$ids = [];
				$counter = 0;
				foreach ( $pageData['items'] as $pageDatum ) {
					$ids[] = $pageDatum['id'];
					if ( $counter++ >= 9 ) {
						break;
					}
				}
				if ( !empty( $ids ) ) {
					$params = [ 'ids' => implode( ',', $ids ), 'height' => 50, 'width' => 50, 'abstract' => 150 ];
					$detailResponse =
						$this->app->sendRequest( 'ArticlesApiController', 'getDetails', $params )->getData();
					foreach ( $detailResponse['items'] as $item ) {
						$processed = static::processArticleItem( $item );
						if ( !empty( $processed ) ) {
							$pages[] = $processed;
						}
					}
				}
			} catch ( Exception $e ) {
			} // ignoring api errors for gracefulness
		}
		//limit number of results
		$pages = array_slice( $pages, 0, 3 );

		$this->setVal( 'category', $category );
		$this->setVal( 'pages', $pages );
		$this->setVal( 'result', $result );
		$this->setVal( 'gpos', $this->getVal( 'gpos' ) );
		$this->setVal( 'pos', $this->getVal( 'pos' ) );
		$this->setVal( 'query', $this->getVal( 'query' ) );
	}

	/**
	 * Controller Helper Methods
	 *----------------------------------------------------------------------------------*/

	public static function processArticleItem( $item, $maxlen = 150 ) {
		if ( empty( $item['thumbnail'] ) ) {
			//add placeholder
			$item['thumbnail'] = '';
		}
		//sanitize strings first
		$trimTitle = trim( strtolower( $item['title'] ) );
		$bracketPos = strpos( $trimTitle, '(' );
		if ( $bracketPos !== false ) {
			$trimTitleWObrackets = substr( $trimTitle, 0, $bracketPos - 1 );
		}
		$normSpacesAbs = preg_replace( '|\s+|', ' ', $item['abstract'] );
		$lowerAbstract = strtolower( $normSpacesAbs );

		if ( !empty( $trimTitle ) ) {
			$pos = strpos( $lowerAbstract, $trimTitle );
			if ( $pos !== false ) {
				if ( $pos <= static::SNIPPET_SUBSTR ) {
					$cutIn = $pos + strlen( $trimTitle );
				}
			} elseif ( isset( $trimTitleWObrackets ) ) {
				$pos = strpos( $lowerAbstract, $trimTitleWObrackets );
				if ( $pos !== false && $pos <= static::SNIPPET_SUBSTR ) {
					$cutIn = $pos + strlen( $trimTitleWObrackets );
				}
			}
		}
		//dont substr if next char is alphanumeric
		$splitted = str_split( $lowerAbstract );
		if ( isset( $cutIn ) && ( ctype_punct( $splitted[$cutIn] ) || ctype_space( $splitted[$cutIn] ) ) ) {
			$item['abstract'] = substr( $normSpacesAbs, $cutIn );
		} elseif ( !empty( $item['abstract'] ) ) {
			$item['abstract'] = ' - ' . preg_replace( '|^[^\pL\pN\p{Pi}"]+|', '', $normSpacesAbs );
		}
		if ( !empty( $item['abstract'] ) ) {
			$maxlen -= strlen( $trimTitle );
			if ( $maxlen > 0 ) {
				$item['abstract'] = wfShortenText( $item['abstract'], $maxlen, true );
			} else {
				$item['abstract'] = '';
			}

			return $item;
		}

		return null;
	}

	/**
	 * Called in index action.
	 * Based on an article match and various settings, generates tracking events and routes user to appropriate page.
	 *
	 * @param  Wikia\Search\Config $searchConfig
	 *
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
			if ( $this->useGoSearch() ) {
				Hooks::run( 'SpecialSearchIsgomatch', [ $title, $query ] );
				$this->setVarnishCacheTime( WikiaResponse::CACHE_DISABLED );
				$this->response->redirect( $title->getFullUrl() );
			}
		} else {
			$title = Title::newFromText( $query );
			if ( $title !== null ) {
				Hooks::run( 'SpecialSearchNogomatch', [ &$title ] );
			}
		}

		return true;
	}

	/**
	 * Determine whether we should use "Go" search for exact title matches.
	 *
	 * This supports both the user preference and has backwards compatibility for
	 * Monobook's "Go" button and "go" URL parameter on search.
	 *
	 * @return bool
	 */
	private function useGoSearch() {
		$fulltext = $this->getVal( 'fulltext' );

		// For backwards compatibility ?fulltext=0 means use Go search
		// and if fulltext is set and not equal to 0, it means that the
		// user is trying to manually go to search and override their preference
		// such as with Monobook's "Search" button
		return $fulltext === '0' ||
		$this->getVal( 'go' ) !== null ||
		( $fulltext === null && $this->getUser()->getGlobalPreference( 'enableGoSearch' ) );
	}

	/**
	 * Passes the appropriate values to the config object from the request during index method.
	 *
	 * @return \Wikia\Search\Config
	 */
	protected function getSearchConfigFromRequest() {
		global $wgRequest;

		// Use WebRequest instead of Nirvana request
		// Nirvana request does not process certain Unicode stuff correctly which causes HTTP 500
		$request = $wgRequest;
		$searchConfig = new Wikia\Search\Config();
		$resultsPerPage = $this->isCorporateWiki() ? self::INTERWIKI_RESULTS_PER_PAGE : self::RESULTS_PER_PAGE;
		$resultsPerPage = empty( $this->wg->SearchResultsPerPage ) ? $resultsPerPage : $this->wg->SearchResultsPerPage;
		$searchConfig->setQuery( $request->getVal( 'query', $request->getVal( 'search' ) ) )
			->setCityId(
				$this->wg->CityId
			)
			->setLimit( $request->getInt( 'limit', $resultsPerPage ) )
			->setPage( $request->getInt( 'page', 1 ) )
			->setRank( $request->getVal( 'rank', 'default' ) )
			->setHub( $request->getBool( 'hub', false ) )
			->setInterWiki( $this->isCorporateWiki() )
			->setVideoSearch( $request->getBool( 'videoSearch', false ) )
			->setFilterQueriesFromCodes( $request->getArray( 'filters', [] ) )
			->setBoostGroup( $request->getVal( 'ab' ) );

		if ( $this->isCorporateWiki() ) {
			$searchConfig->setLanguageCode( $request->getVal( 'resultsLang' ) );

			$languageService = new \Wikia\Search\Language\LanguageService();
			$languageService->setLanguageCode( $searchConfig->getLanguageCode() );
			$wikiArticleThreshold = $languageService->getWikiArticlesThreshold();

			if ( in_array( 'staff', $this->wg->user->getEffectiveGroups() ) ) {
				$wikiArticleThreshold = $request->getVal( 'minArticleCount', $wikiArticleThreshold );
			}
			$searchConfig->setXwikiArticleThreshold( $wikiArticleThreshold );
		}

		$this->setNamespacesFromRequest( $searchConfig, $this->wg->User );
		if ( substr( $this->getResponse()->getFormat(), 0, 4 ) == 'json' ) {
			$searchConfig->setRequestedFields( explode( ',', $request->getVal( 'jsonfields', '' ) ) );
		}

		return $searchConfig;
	}

	/**
	 * Sets values for the view to work with during index method.
	 *
	 * @param Wikia\Search\Config $searchConfig
	 */
	protected function setResponseValuesFromConfig( Wikia\Search\Config $searchConfig ) {
		$response = $this->getResponse();
		$format = $response->getFormat();
		if ( $format == 'json' || $format == 'jsonp' ) {
			$results = $searchConfig->getResults();
			if ( $results ) {
				$response->setData(
					$results->toArray( explode( ',', $this->getVal( 'jsonfields', 'title,url,pageid' ) ) )
				);
			} else {
				$response->setData( [] );
			}

			return;
		}
		if ( !$searchConfig->getInterWiki() ) {
			$this->setVal(
				'advancedSearchBox',
				$this->sendSelfRequest( 'advancedBox', [ 'config' => $searchConfig ] )
			);
		}

		$isGridLayoutEnabled = BodyController::isGridLayoutEnabled();

		$tabsArgs = [
			'config' => $searchConfig,
			'filters' => $this->getVal( 'filters', [] ),
		];

		$isMonobook = $this->app->checkSkin( 'monobook' );

		$this->setVal( 'results', $searchConfig->getResults() );
		$this->setVal( 'resultsFound', $searchConfig->getResultsFound() );
		$this->setVal( 'resultsFoundTruncated', $searchConfig->getTruncatedResultsNum( true ) );
		$this->setVal( 'isOneResultsPageOnly', $searchConfig->getNumPages() < 2 );
		$this->setVal( 'pagesCount', $searchConfig->getNumPages() );
		$this->setVal( 'currentPage', $searchConfig->getPage() );
		$this->setVal( 'paginationLinks', $this->sendSelfRequest( 'pagination', $tabsArgs ) );
		$this->setVal( 'tabs', $this->sendSelfRequest( 'tabs', $tabsArgs ) );
		$this->setVal( 'query', $searchConfig->getQuery()->getQueryForHtml() );
		$this->setVal( 'resultsPerPage', $searchConfig->getLimit() );
		$this->setVal( 'specialSearchUrl', $this->wg->Title->getFullUrl() );
		$this->setVal( 'isInterWiki', $searchConfig->getInterWiki() );
		$this->setVal( 'namespaces', $searchConfig->getNamespaces() );
		$this->setVal( 'hub', $searchConfig->getHub() );
		$this->setVal( 'hasArticleMatch', $searchConfig->hasArticleMatch() );
		$this->setVal( 'isMonobook', $isMonobook );
		$this->setVal( 'isCorporateWiki', $this->isCorporateWiki() );
		$this->setVal( 'wgExtensionsPath', $this->wg->ExtensionsPath );
		$this->setVal( 'isGridLayoutEnabled', $isGridLayoutEnabled );
		$this->setVal( 'shownResultsBegin', $this->resultsPerPage * $this->currentPage - $this->resultsPerPage + 1 );

		if ( $this->isCorporateWiki() ) {
			$resultsLang = $searchConfig->getLanguageCode();
			if ( $resultsLang != $this->app->wg->ContLang->getCode() ) {
				$this->setVal( 'resultsLang', $resultsLang );
			}
		}

		if ( $this->currentPage == $this->pagesCount ) {
			$this->setVal( 'shownResultsEnd', $this->resultsFound );
		} else {
			$this->setVal( 'shownResultsEnd', $this->resultsPerPage * $this->currentPage );
		}

		$sanitizedQuery = $searchConfig->getQuery()->getSanitizedQuery();
		if ( strlen( $sanitizedQuery ) > 0 &&
			in_array( 0, $searchConfig->getNamespaces() ) &&
			!in_array( 6, $searchConfig->getNamespaces() )
		) {
			$combinedMediaResult = $this->sendSelfRequest(
				'combinedMediaSearch',
				[ 'q' => $sanitizedQuery, 'videoOnly' => true ]
			)->getData();
			if ( isset( $combinedMediaResult ) && sizeof( $combinedMediaResult['items'] ) == 4 ) {
				$this->setVal( 'mediaData', $combinedMediaResult );
			}
		} else {
			$this->setVal( 'mediaData', [] );
		}

		if ( $searchConfig->hasWikiMatch() ) {
			$this->registerWikiMatch( $searchConfig );
		}

		$this->addRightRailModules( $searchConfig );
	}

	protected function addRightRailModules( Wikia\Search\Config $searchConfig ) {
		global $wgLang, $wgEnableFandomStoriesOnSearchResultPage;

		$isMonobook = $this->response->getVal( 'isMonobook' );
		$this->response->setValues(
			[
				'fandomStories' => [],
				'topWikiArticles' => [],
			]
		);

		if ( $searchConfig->getInterWiki() || $isMonobook ) {
			return;
		}

		// SUS-1219: Use proper sanity check to handle space-only queries correctly
		$hasTerms = $searchConfig->getQuery()->hasTerms();
		if ( $wgEnableFandomStoriesOnSearchResultPage && $wgLang->getCode() === 'en' && $hasTerms ) {
			$query = $searchConfig->getQuery()->getSanitizedQuery();

			WikiaLogger::instance()->info( __METHOD__ . ' - Querying Fandom Stories', [
				'query' => $query,
			] );

			$fandomStories = \WikiaDataAccess::cache(
				wfSharedMemcKey( static::FANDOM_STORIES_MEMC_KEY, $query ),
				\WikiaResponse::CACHE_STANDARD,
				function() use ( $query ) {
					return ( new \Wikia\Search\Services\ESFandomSearchService() )->query( $query );
				}
			);

			if ( !empty( $fandomStories ) ) {
				if ( count( $fandomStories ) === \Wikia\Search\Services\FandomSearchService::RESULTS_COUNT ) {
					$viewMoreFandomStoriesLink = static::FANDOM_SEARCH_PAGE . urlencode( $query );
				} else {
					$viewMoreFandomStoriesLink = null;
				}

				$this->response->setValues(
					[
						'fandomStories' => array_slice(
							$fandomStories,
							0,
							static::NUMBER_OF_ITEMS_IN_FANDOM_STORIES_MODULE
						),
						'viewMoreFandomStoriesLink' => $viewMoreFandomStoriesLink,
					]
				);

				return;
			}
		}

		$topWikiArticles = \Wikia\Search\TopWikiArticles::getArticlesWithCache(
			$this->wg->CityId,
			$this->response->getVal( 'isGridLayoutEnabled' )
		);

		if ( !empty( $topWikiArticles ) ) {
			$this->setVal( 'topWikiArticles', $topWikiArticles );
		}
	}

	/**
	 * Includes wiki match partial for non cross-wiki searches
	 *
	 * @param Wikia\Search\Config $searchConfig
	 */
	protected function registerWikiMatch( Wikia\Search\Config $searchConfig ) {
		$matchResult = $searchConfig->getWikiMatch()->getResult();
		if ( $matchResult !== null ) {
			$matchResult['onWikiMatch'] = true;
			$this->setVal(
				'wikiMatch',
				$this->getApp()->getView(
					'WikiaSearch',
					'exactWikiMatch',
					ResultHelper::extendResult(
						$matchResult,
						'wiki',
						ResultHelper::MAX_WORD_COUNT_EXACT_MATCH,
						[
							'width' => WikiaSearchController::EXACT_WIKI_MATCH_THUMBNAIL_WIDTH,
							'height' => WikiaSearchController::EXACT_WIKI_MATCH_THUMBNAIL_HEIGHT
						],
						$searchConfig->getQuery()->getSanitizedQuery()
					)
				)
			);
		}
	}

	/**
	 * Sets the page title during index method.
	 *
	 * @param Wikia\Search\Config $searchConfig
	 */
	protected function setPageTitle( Wikia\Search\Config $searchConfig ) {
		if ( $searchConfig->getQuery()->hasTerms() ) {
			$this->wg->Out->setPageTitle(
				wfMsg(
					'wikiasearch2-page-title-with-query',
					[ ucwords( $searchConfig->getQuery()->getSanitizedQuery() ), $this->wg->Sitename ]
				)
			);
		} else {
			if ( $searchConfig->getInterWiki() ) {
				$this->wg->Out->setPageTitle( wfMsg( 'wikiasearch2-page-title-no-query-interwiki' ) );
			} else {
				$this->wg->Out->setPageTitle(
					wfMsg(
						'wikiasearch2-page-title-no-query-intrawiki',
						[ $this->wg->Sitename ]
					)
				);
			}
		}
	}

	/**
	 * Called in index action to manipulate the view based on the user's skin
	 *
	 * @return boolean true
	 */
	protected function handleSkinSettings() {
		global $wgCityId;
		$this->wg->Out->addHTML( JSSnippets::addToStack( [ "/extensions/wikia/Search/js/WikiaSearch.js" ] ) );
		$this->wg->SuppressRail = true;
		if ( $this->isCorporateWiki() ) {
			OasisController::addBodyClass( 'inter-wiki-search' );

			$this->setVal( 'corporateWikiId', $wgCityId );
			$this->overrideTemplate( 'CrossWiki_index' );
		}
		$skin = $this->wg->User->getSkin();
		if ( $skin instanceof SkinMonoBook ) {
			$this->response->addAsset( 'extensions/wikia/Search/monobook/monobook.scss' );
		}
		if ( $skin instanceof SkinOasis ) {
			$this->response->addAsset( 'extensions/wikia/Search/css/WikiaSearch.scss' );
		}
		if ( $skin instanceof SkinWikiaMobile ) {
			WikiaLogger::instance()->info( 'SUS-4233 - Mobile search has been rendered' );
			$this->overrideTemplate( 'WikiaMobileIndex' );
		}

		return true;
	}

	/**
	 * Called in index action to handle overriding template for different abTests
	 */
	protected function handleLayoutAbTest( $abGroup, $ns = null ) {
		$abs = explode( ',', $abGroup );
		//check if template for ab test exists
		$view = static::WIKIA_DEFAULT_RESULT;
		$categoryModule = false;
		if ( !empty( $abs ) ) {
			//set ab for category
			if ( in_array( 47, $abs ) ) {
				$categoryModule = true;
			}
			foreach ( $abs as $abGroup ) {
				if ( $this->templateExists( $abGroup ) ) {
					$view = $abGroup;
				}
			}
		}
		$this->setVal( 'resultView', $view );
		$this->setVal( 'categoryModule', $categoryModule );

		return true;
	}

	/**
	 * Checks if template with given sufix exists
	 *
	 * @param $name string Template sufix
	 *
	 * @return bool
	 */
	protected function templateExists( $name ) {
		//build path to templates dir
		$path = __DIR__ . '/templates';

		return file_exists( "{$path}/WikiaSearch_{$name}.php" );
	}

	/**
	 * Determines whether we are on the corporate wiki
	 *
	 * @see SearchControllerTest::testIsCorporateWiki
	 */
	protected function isCorporateWiki() {
		return WikiaPageType::isCorporatePage();
	}

	/**
	 * Self-requests -- these shouldn't be directly called from the browser
	 */

	/**
	 * This is how we generate the subtemplate for the advanced search box.
	 *
	 * @see    SearchControllerTest::testAdvancedBox
	 * @throws Exception
	 */
	public function advancedBox() {
		$config = $this->getVal( 'config', false );
		if ( !$config instanceof Wikia\Search\Config ) {
			throw new Exception( "This should not be called outside of self-request context." );
		}

		$searchEngine = ( new SearchEngine );

		$searchableNamespaces = $searchEngine->searchableNamespaces();

		Hooks::run( 'AdvancedBoxSearchableNamespaces', [ &$searchableNamespaces ] );

		$this->setVal( 'namespaces', $config->getNamespaces() );
		$this->setVal( 'searchableNamespaces', $searchableNamespaces );
	}

	/**
	 * This is how we generate the search type tabs in the left-hand rail
	 *
	 * @see    SearchControllerTest::tabs
	 * @throws Exception
	 */
	public function tabs() {
		$config = $this->getVal( 'config', false );

		if ( !$config || ( !$config instanceOf Wikia\Search\Config ) ) {
			throw new Exception( "This should not be called outside of self-request context." );
		}

		$filters = $config->getFilterQueries();
		$rank = $config->getRank();

		$form = [
			'cat_videogames' => isset( $filters['cat_videogames'] ),
			'cat_entertainment' => isset( $filters['cat_entertainment'] ),
			'cat_lifestyle' => isset( $filters['cat_lifestyle'] ),
			'is_hd' => isset( $filters['is_hd'] ),
			'is_image' => isset( $filters['is_image'] ),
			'is_video' => isset( $filters['is_video'] ),
			'sort_default' => $rank == 'default',
			'sort_longest' => $rank == 'longest',
			'sort_newest' => $rank == 'newest',
			'no_filter' => !( isset( $filters['is_image'] ) || isset( $filters['is_video'] ) ),
		];

		$this->setVal( 'bareterm', $config->getQuery()->getSanitizedQuery() );
		$this->setVal( 'searchProfiles', $config->getSearchProfiles() );
		$this->setVal( 'activeTab', $config->getActiveTab() );
		$this->setVal( 'form', $form );
	}

	/**
	 * This handles pagination via a template script.
	 *
	 * @see    SearchControllerTest::testPagination
	 * @return boolean|null (false if we don't want pagination, fully routed to view via sendSelfRequest if we do want pagination)
	 */
	public function pagination() {
		$config = $this->getVal( 'config', false );
		if ( ( !$config instanceof Wikia\Search\Config ) || !$this->request->isInternal() ) {
			$this->response->setCode( WikiaResponse::RESPONSE_CODE_BAD_REQUEST );
			$this->skipRendering();
			return false;
		}

		if ( !$config->getResultsFound() ) {
			$this->skipRendering();
			return false;
		}

		$page = $config->getPage();

		$windowFirstPage = ( ( $page - self::PAGES_PER_WINDOW ) > 0 ) ? ( $page - self::PAGES_PER_WINDOW ) : 1;

		$windowLastPage =
			( ( ( $page + self::PAGES_PER_WINDOW ) < $config->getNumPages() ) ? ( $page + self::PAGES_PER_WINDOW ) :
				$config->getNumPages() );

		if ( $windowLastPage <= 1 ) {
			$this->skipRendering();
			return false;
		}

		$pageTitle = SpecialPage::getTitleFor( 'Search' );

		// set up extra query string parameters to be appended to each pagination link
		$extraParams = [];

		if ( $config->getInterWiki() ) {
			$extraParams['crossWikia'] = 1;
		}

		foreach ( $config->getPublicFilterKeys() as $filter ) {
			$extraParams['filters'][] = $filter;
		}

		foreach ( $config->getNamespaces() as $ns ) {
			$extraParams['ns'.$ns] = 1;
		}

		$limit = $config->getLimit();
		if (  $limit !== WikiaSearchController::RESULTS_PER_PAGE ) {
			$extraParams['limit'] = $limit;
		}

		// SUS-495: add resultsLang parameter if present in original request (global search)
		$resultsLang = $this->getContext()->getRequest()->getVal( 'resultsLang' );
		if ( !empty( $resultsLang ) ) {
			$extraParams['resultsLang'] = $resultsLang;
		}

		$this->setVal( 'query', 			$config->getQuery()->getSanitizedQuery() );
		$this->setVal( 'pagesNum', 			$config->getNumPages() );
		$this->setVal( 'currentPage', 		$page );
		$this->setVal( 'windowFirstPage', 	$windowFirstPage );
		$this->setVal( 'windowLastPage', 	$windowLastPage );
		$this->setVal( 'pageTitle', 		$pageTitle );
		$this->setVal( 'extraParams',       $extraParams );
	}
}

