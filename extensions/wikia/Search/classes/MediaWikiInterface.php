<?php
/**
 * Class definition for \Wikia\Search\MediaWikiInterface
 * @author relwell
 */
namespace Wikia\Search; 
/**
 * Encapsulates MediaWiki functionalities 
 * This will allow us to abstract our behavior away from MediaWiki if we want
 * Public functions should not return instances of classes defined in MediaWiki core.
 * @author relwell
 * @todo a bunch of these methods should probably be defined in an actual interface, but until we have another "backend" the point is moot
 */
class MediaWikiInterface
{
	/**
	 * Enforce singleton
	 * @var MediaWikiInterface
	 */
	protected static $instance;
	
	/**
	 * Application interface
	 * @var \WikiaApp
	 */
	protected $app;
	
	/**
	 * Constructor method
	 */
	protected function __construct() {
		$this->app = \F::app();
	}
	
	public static function getInstance() {
		if (! isset( self::$instance ) ) {
			self::$instance = new MediaWikiInterface();
		}
		return self::$instance;
	}
	
	/**
	 * Allows us to memoize article instantiation based on pageid
	 * @var array
	 */
	protected $pageIdsToArticles = array();
	
	/**
	 * Allows us to cache titles based on page id
	 * @var array
	 */
	protected $pageIdsToTitles = array();
	
	/**
	 * Allows us to recover the canonical page ID
	 * @var array
	 */
	protected $redirectsToCanonicalIds = array();
	
	/**
	 * Gives direct access to File instance from page id
	 * @var array
	 */
	protected $pageIdsToFiles = array();
	
	/**
	 * Stores articles that are redirects (helps us grab non-canonical info)
	 * @var array
	 */
	protected $redirectArticles = array();
	
	/**
	 * An array that corresponds wiki IDs to their wiki data sources.
	 * @var array
	 */
	protected $wikiDataSources = array();

	/**
	 * Given a page ID, get the title string
	 * @param int $pageId
	 * @return string
	 */
	public function getTitleStringFromPageId( $pageId ) {
		return $this->getTitleString( $this->getTitleFromPageId( $pageId ) );
	}
	
	/**
	 * Gets a title from a page id
	 * @param int $pageId
	 * @return Title
	 */
	protected function getTitleFromPageId( $pageId ) {
		wfProfileIn( __METHOD__ );
		if (! isset( $this->pageIdsToTitles[$pageId] ) ) {
			$page = $this->getPageFromPageId( $pageId );
			$this->pageIdsToTitles[$pageId] = $page->getTitle();
		}
		wfProfileOut( __METHOD__ );
		return $this->pageIdsToTitles[$pageId];
	}
	
	/**
	 * Provided a page ID, return the canonical page ID
	 * @param int $pageId
	 * @return int
	 */
	public function getCanonicalPageIdFromPageId( $pageId ) {
		wfProfileIn( __METHOD__ );
		
		// make sure we have the right values cached
		try {
    		$this->getPageFromPageId( $pageId );
		} catch ( \Exception $e ) {
			return $pageId;
		}
		
		if ( isset( $this->redirectsToCanonicalIds[$pageId] ) ) {
			$pageId = $this->redirectsToCanonicalIds[$pageId];
		}
		wfProfileOut(__METHOD__);
		return $pageId;
	}
	
	/**
	 * Determines if the page is within content namespaces
	 * @param int $pageId
	 * @return boolean
	 */
	public function isPageIdContent( $pageId ) {
		return in_array( $this->getNamespaceFromPageId( $pageId ), $this->getGlobal( 'ContentNamespaces' ) );
	}
	
	/**
	 * Returns the two-letter language code set globally
	 */
	public function getLanguageCode() {
		return $this->getGlobal( 'ContLang' )->getCode();
	}
	
	/**
	 * Returns a string valued URL from a page id
	 * @param int $pageId
	 * @return string
	 */
	public function getUrlFromPageId( $pageId ) {
		return $this->getTitleFromPageId( $pageId )->getFullUrl();
	}
	
	/**
	 * Returns the namespace value of the provided page id
	 * @param int $pageId
	 * @return int
	 */
	public function getNamespaceFromPageId( $pageId ) {
		return $this->getTitleFromPageId( $pageId )->getNamespace();
	}
	
	/**
	 * Provides the page ID of the current wiki's main page
	 * @return int
	 */
	public function getMainPageArticleId() {
		return \Title::newMainPage()->getArticleId();
	}
	
	/**
	 * Provides the non-extended value of the language code, set globally
	 * @return string
	 */
	public function getSimpleLanguageCode() {
		return preg_replace( '/-.*$/', '', $this->getLanguageCode() );
	}
	
	/**
	 * Allows us to abstract out the MW Api for parse responses
	 * @param int $pageId
	 * @return array
	 */
	public function getParseResponseFromPageId( $pageId ) {
		return \ApiService::call( array(
					'pageid'	=> $pageId,
					'action'	=> 'parse',
				));
	}
	
	/**
	 * Returns the memcache key for the given string
	 * @param string $key
	 * @return string
	 */
	public function getCacheKey( $key ) {
		return $this->app->wf->SharedMemcKey( $key, $this->getWikiId() );
	}
	
	/**
	 * Returns what's set in memcache through the app
	 * @param string $key
	 * @return array
	 */
	public function getCacheResult( $key ) {
		return $this->getGlobal( 'Memc' )->get( $key );
	}
	
	/**
	 * Returns the cached result without the intermediate cache query in consumer logic
	 * @param string $key
	 * @return multitype
	 */
	public function getCacheResultFromString( $key ) {
		return $this->getCacheResult( $this->getCacheKey( $key ) );
	}
	
	/**
	 * Allows us to set values in global memcache without knowing the memcache key
	 * @param string $key
	 * @param mixed $value
	 * @param int $ttl
	 * @return \Wikia\Search\MediaWikiInterface
	 */
	public function setCacheFromStringKey( $key, $value, $ttl ) {
		$this->getGlobal( 'Memc' )->set( $this->getCacheKey( $key ), $value, $ttl );
		return $this;
	}
	
	/**
	 * Performs an API request, but still returns the data 
	 * @param unknown_type $pageId
	 * @return multitype:
	 **/
	public function getBacklinksCountFromPageId( $pageId ) {
		$title = $this->getTitleStringFromPageId( $pageId );
		$data = \ApiService::call( array(
				'titles'	=> $title,
				'bltitle'	=> $title,
				'action'	=> 'query',
				'list'		=> 'backlinks',
				'blcount'	=> 1
				));
		return isset($data['query']['backlinks_count'] ) ? $data['query']['backlinks_count'] : 0;
	}
	

	
	/**
	 * Provides global value as set in the Oasis wg helper
	 * @param mixed $global
	 * @return mixed
	 */
	public function getGlobal( $global ) {
		return $this->app->wg->{$global};
	}
	
	/**
	 * Gets global values set for other wikis.
	 * @param string $global
	 * @param int $wikiId
	 * @return mixed
	 */
	public function getGlobalForWiki( $global, $wikiId ) {
		$row = \WikiFactory::getVarValueByName( $global, $wikiId );
		if ( is_object( $row ) ) {
			return unserialize( $row->cv_value );
		}
		return $row;
	}
	
	/**
	 * Determines whether we are using a mobile skin.
	 * @return bool
	 */
	public function isSkinMobile() {
		return $this->app->wg->User->getSkin() instanceof \SkinWikiaMobile;
	}
	
	/**
	 * Provides global value as set in the Oasis wg helper.
	 * If the value is NULL, we return the default value set in param 2
	 * @param mixed $global
	 * @param mixed $default
	 * @return mixed
	 */
	public function getGlobalWithDefault( $global, $default = null ) {
		$result = $this->getGlobal( $global );
		return $result === null ? $default : $result;
	}
	
	/**
	 * Sets a global param, abstracted away from MediaWiki
	 * @param string $global
	 * @param mixed $value
	 * @return \Wikia\Search\MediaWikiInterface
	 */
	public function setGlobal( $global, $value ) {
		$this->app->wg->{$global} = $value;
		return $this;
	}
	
	/**
	 * Provides the ID of the wiki based on current global settings
	 * @return int
	 */
	public function getWikiId() {
		return (int) $this->isOnDbCluster() ?  $this->getGlobal( 'CityId' ) : $this->getGlobal( 'SearchWikiId' );
	}
	
	/**
	 * Tells us whether we're using the DB cluster. This is how we figure out if we're on internal or not.
	 * @return boolean
	 */
	public function isOnDbCluster() {
		$shared = $this->getGlobal( 'ExternalSharedDB' );
		return !empty( $shared );
	}
	
	/**
	 * Returns a serialized array of metadata for a given page, if a file
	 * @param int $pageId
	 * @return string
	 */
	public function getMediaDataFromPageId( $pageId ) {
		if (! $this->pageIdHasFile( $pageId ) ) {
			return '';
		}
		
		return ( $file = $this->getFileForPageId( $pageId ) ) ? $file->getMetadata() : array();
	}
	
	/**
	 * Determines whether a given page has a file
	 * @param int $pageId
	 * @return boolean
	 */
	public function pageIdHasFile( $pageId ) {
		$result = $this->getFileForPageId( $pageId );
		return $result !== null;
	}
	
	/**
	 * Returns the value of a mediawiki api call for statistics
	 * @param int $pageId
	 * @return multitype:
	 */
	public function getApiStatsForPageId( $pageId ) {
		return \ApiService::call( array(
					'pageids'  => $pageId,
					'action'   => 'query',
					'prop'     => 'info',
					'inprop'   => 'url|created|views|revcount',
					'meta'     => 'siteinfo',
					'siprop'   => 'statistics|wikidesc|variables|namespaces|category'
			));
	}
	
	/**
	 * Returns page ID statistics for a given wiki
	 * @return array
	 */
	public function getApiStatsForWiki() {
		return \ApiService::call( array(
					'action'   => 'query',
					'prop'     => 'info',
					'inprop'   => 'url|created|views|revcount',
					'meta'     => 'siteinfo',
					'siprop'   => 'statistics'
			));
	}
	
	
	/**
	 * Determines whether or not a page "exists"
	 * @param unknown_type $pageId
	 * @return boolean
	 */
	public function pageIdExists( $pageId ) {
		try {
			return $this->getPageFromPageId( $pageId )->exists();
		} catch ( \Exception $e ) {
			return false;
		}
	}
	
	/**
	 * Provides redirect title text for canonical pages
	 * @param int $pageId
	 * @return array
	 */
	public function getRedirectTitlesForPageId( $pageId ) {
		$dbr = $this->app->wf->GetDB(DB_SLAVE);
		$result = array();
		$query = $dbr->select(
				array( 'redirect', 'page' ),
				array( 'page_title' ),
				array(),
				__METHOD__,
				array( 'GROUP'=>'rd_title' ),
				array( 'page' => array( 'INNER JOIN', array('rd_title'=> $this->getTitleKeyFromPageId( $pageId ), 'page_id = rd_from' ) ) )
		);
		while ( $row = $dbr->fetchObject( $query ) ) { 
				$result[] = str_replace( '_', ' ', $row->page_title );
		}
		
		return $result;
	}
	
	/**
	 * For a given NS (e.g. 'Category'), returns the integer value (e.g. 14).
	 * @param string $namespaceString
	 * @return int
	 */
	public function getNamespaceIdForString( $namespaceString ) {
		return $this->app->wg->ContLang->getNsIndex( $namespaceString );
	}
	
	/**
	 * Returns default namespaces from mediawiki.
	 * @return array
	 */
	public function getDefaultNamespacesFromSearchEngine() {
		return \SearchEngine::defaultNamespaces();
	}
	
	/**
	 * Returns searchable namespaces from MediaWiki.
	 * @return array
	 */
	public function getSearchableNamespacesFromSearchEngine() {
		return \SearchEngine::searchableNamespaces();
	}
	
	/**
	 * Returns text values for namespaces.
	 */
	public function getTextForNamespaces( array $namespaces ) {
		return \SearchEngine::namespacesAsText( $namespaces );
	}
	
	/**
	 * Allows us to abstract calling a hook away from other parts of the library.
	 * @param string $hookName
	 * @param array $args
	 * @return mixed
	 */
	public function invokeHook( $hookName, array $args = array() ) {
		return wfRunHooks( $hookName, $args );
	}
	
	/**
	 * Returns the output of passing a title instance fo WikiaFileHelper::getMediaDetail, which out to be an array
	 * @param int $pageId
	 * @return array
	 */
	public function getMediaDetailFromPageId( $pageId ) {
		return \WikiaFileHelper::getMediaDetail( $this->getTitleFromPageId( $pageId ) );
	}
	
	/**
	 * Determines if a page id is a video file
	 * @param int $pageId
	 * @return boolean
	 */
	public function pageIdIsVideoFile( $pageId ) {
		return \WikiaFileHelper::isVideoFile( $this->getFileForPageId( $pageId ) );
	}
	
	/**
	 * Returns the appropriately formatted timestamp for the first revision of a given page.
	 * @param int $pageId
	 * @return string
	 */
	public function getFirstRevisionTimestampForPageId( $pageId ) {
		$firstRev = $this->getTitleFromPageId( $pageId )->getFirstRevision();
		return empty( $firstRev ) ? '' : $this->getFormattedTimestamp( $firstRev->getTimestamp() );
	}
	
	/**
	 * Returns a text snippet provided a page ID.
	 * @param int $pageId
	 * @param int $snippetLength
	 * @return string
	 */
	public function getSnippetForPageId( $pageId, $snippetLength = 250 ) {
		$articleService = new \ArticleService( $this->getCanonicalPageIdFromPageId( $pageId ) );
		return $articleService->getTextSnippet( $snippetLength );
	}
	
	/**
	 * Returns the non-canonical title string for page ID (redirects ignored)
	 * @param int $pageId
	 * @return string
	 */
	public function getNonCanonicalTitleString( $pageId ) {
		if ( isset( $this->redirectArticles[$pageId] ) ) {
			return $this->getTitleString( $this->redirectArticles[$pageId]->getTitle() );
		}
		return $this->getTitleStringFromPageId( $pageId ); 
	}
	
	/**
	 * Returns the non-canonical url string for page ID (redirects ignored)
	 * @param int $pageId
	 * @return string
	 */
	public function getNonCanonicalUrlFromPageId( $pageId ) {
		if ( isset( $this->redirectArticles[$pageId] ) ) {
			return $this->redirectArticles[$pageId]->getTitle()->getFullUrl();
		}
		return $this->getUrlFromPageId( $pageId ); 
	}
	
	/**
	 * Provided a string, uses MediaWiki's ability to find article matches to instantiate a Wikia Search Article Match.
	 * @param string $term
	 * @param array $namespaces
	 * @return \Wikia\Search\Match\Article|NULL
	 */
	public function getArticleMatchForTermAndNamespaces( $term, array $namespaces ) {
		$searchEngine = new \SearchEngine();
		$title = $searchEngine->getNearMatch( $term );
		if( ( $title !== null ) && ( in_array( $title->getNamespace(), $namespaces ) ) ) {
			// initialize our memoized data
			$this->getPageFromPageId( $title->getArticleId() );
			$articleMatch = new \Wikia\Search\Match\Article( $title->getArticleId(), $this );
			return $articleMatch;
		}
		return null;
	}
	
	/**
	 * Provided a prepped domain string, (e.g. 'runescape'), return a wiki match.
	 * @param string $domain
	 * @return \Wikia\Search\Match\Wiki|NULL
	 */
	public function getWikiMatchByHost( $domain ) {
		$dbr = $this->app->wf->GetDB( DB_SLAVE, array(), $this->app->wg->ExternalSharedDB );
		$query = $dbr->select(
				array( 'city_domains' ),
				array( 'city_id' ),
				array( 'city_domain' => "{$domain}.wikia.com" )
				);
		if ( $row = $dbr->fetchObject( $query ) ) {
			return new \Wikia\Search\Match\Wiki( $row->city_id, $this );
		}
		return null;
	}
	

	/**
	 * Returns the URL string for a wiki ID
	 * @param int $wikiId
	 * @return string
	 */
	public function getMainPageUrlForWikiId( $wikiId ) {
		return $this->getMainPageTitleForWikiId( $wikiId )->getFullUrl();
	}
	
	/**
	 * Returns text from the main page of a provided wiki.
	 * @param int $wikiId
	 * @return string
	 */
	public function getMainPageTextForWikiId( $wikiId ) {
		$params = array(
				'controller' => 'ArticlesApiController', 
				'method' => 'getDetails', 
				'titles' => $this->getMainPageTitle()->getDbKey()
				);
		$response = \ApiService::foreignCall( $this->getDbNameForWikiId( $wikiId ), $params, \ApiService::WIKIA );
		$item = \array_shift( $response['items'] );
		return $item['abstract'];
	}
	
	/**
	 * Returns the appropriately formatted timestamp for the most recent revision of a given page.
	 * @param int $pageId
	 * @return string
	 */
	public function getLastRevisionTimestampForPageId( $pageId ) {
		$lastRev = \Revision::newFromId( $this->getTitleFromPageId( $pageId )->getLatestRevID() );
		return empty( $lastRev ) ? '' : $this->getFormattedTimestamp( $lastRev->getTimestamp() ); 
	}
	
	/**
	 * Returns mediawiki-formatted timestamps.
	 * @param string $timestamp
	 * @return string
	 */
	public function getMediaWikiFormattedTimestamp( $timestamp ) { 
		return $this->app->wg->Lang ? $this->app->wg->Lang->date( $this->app->wf->Timestamp( TS_MW, $timestamp ) ) : '';
	}
	
	
	
	/**
	 * Determines if the current globally registered language code is supported by search for dynamic support.
	 * @return boolean
	 */
	public function searchSupportsCurrentLanguage() {
		return $this->searchSupportsLanguageCode( $this->getLanguageCode() );
	}
	
	/**
	 * Determines if a given language code is supported for dynamic search
	 * @param string $languageCode
	 * @return boolean
	 */
	public function searchSupportsLanguageCode( $languageCode ) {
		return in_array( $languageCode, $this->getGlobal( 'WikiaSearchSupportedLanguages' ) );
	}
	
	/**
	 * Returns the HTML needed to get a thumbnail provided a page ID
	 * @param int $pageId
	 * @param array $transformParams
	 * @param array $htmlParams
	 */
	public function getThumbnailHtmlForPageId(
			$pageId, 
			$transformParams = array( 'width' => 160 ), 
			$htmlParams = array('desc-link'=>true, 'img-class'=>'thumbimage', 'duration'=>true) 
			) {
		$img = $this->getFileForPageId( $pageId );
		if (! empty( $img ) ) {
			$thumb = $img->transform( array( 'width' => 160 ) ); // WikiaGrid 1 column width
			return $thumb->toHtml( $htmlParams );
		}
	}
	
	/**
	 * Returns the number of video views for a page ID.
	 * @param int $pageId
	 * @return string
	 */
	public function getVideoViewsForPageId( $pageId ) {
		$videoViews = '';
		$title = $this->getTitleFromPageId( $pageId );
		if ( \F::build( 'WikiaFileHelper' )->isFileTypeVideo( $title ) ) {
			$videoViews = \F::build( 'MediaQueryService' )->getTotalVideoViewsByTitle( $title->getDBKey() );
			$videoViews = \F::app()->wf->MsgExt( 'videohandler-video-views', array( 'parsemag' ), \F::app()->wg->Lang->formatNum($videoViews) );
		}
		return $videoViews;
	}
	
	/**
	 * Provides a format, provided a revision's default timestamp format.
	 * @param string $timestamp
	 */
	protected function getFormattedTimestamp( $timestamp ) {
		return $this->app->wf->Timestamp( TS_ISO_8601, $timestamp );
	}

	/**
	 * Gets the DB key of a title provided a page id
	 * @param int $pageId
	 * @return string
	 */
	protected function getTitleKeyFromPageId( $pageId ) {
		return $this->getTitleFromPageId( $pageId )->getDbKey();
	}
	
	/**
	 * Give a page id, provide a file
	 * @param int $pageId
	 * @return File
	 */
	protected function getFileForPageId( $pageId ) {
		if (! isset( $this->pageIdsToFiles[$pageId] ) ) {
			$this->pageIdsToFiles[$pageId] = $this->app->wf->findFile( $this->getTitleStringFromPageId( $pageId ) );
		}
		return $this->pageIdsToFiles[$pageId];
	}
	
    /**
	 * Standard interface for this class's services to access a page
	 * @param int $pageId
	 * @return Article
	 * @throws WikiaException
	 */
	protected function getPageFromPageId( $pageId ) {
		wfProfileIn( __METHOD__ );
		if ( isset( $this->pageIdsToArticles[$pageId] ) ) {
			return $this->pageIdsToArticles[$pageId];
		}
	    $page = \Article::newFromID( $pageId );
	
		if( $page === null ) {
			throw new \WikiaException( 'Invalid Article ID' );
		}
		if( $page->isRedirect() ) {
			$this->redirectArticles[$pageId] = $page;
			$page = new \Article( $page->getRedirectTarget() );
			$newId = $page->getID();
			$this->pageIdsToArticles[$newId] = $page;
			$this->redirectsToCanonicalIds[$pageId] = $newId;
		}
		$this->pageIdsToArticles[$pageId] = $page;
		
		wfProfileOut(__METHOD__);
		return $page;
	}
	
    /**
	 * Provided a page, returns the string value of that page's title
	 * This allows us to accommodate unconventional locations for titles
	 * @param Title $title
	 * @return string
	 */
	protected function getTitleString( \Title $title ) {
		wfProfileIn( __METHOD__ );
		if ( in_array( $title->getNamespace(), array( NS_WIKIA_FORUM_BOARD_THREAD, NS_USER_WALL_MESSAGE ) ) ){
			$wm = \WallMessage::newFromId( $title->getArticleID() );
			$wm->load();
			
			if ( !$wm->isMain() && ( $main = $wm->getTopParentObj() ) && !empty( $main ) ) {
				$main->load();
				$wm = $main;
			}
			
			return (string) $wm->getMetaTitle();
		}
		wfProfileOut(__METHOD__);
		return (string) $title;
	}
	
	/**
	 * Allows us to access an instance of WikiDataSource
	 * @param int $wikiId
	 * @return \WikiDataSource
	 */
	protected function getDataSourceForWikiId( $wikiId ) {
		if ( empty( $this->wikiDataSources[$wikiId] ) ) {
			$this->wikiDataSources[$wikiId] = new \WikiDataSource( $wikiId );
		}
		return $this->wikiDataSources[$wikiId];
	}

	protected function getDbNameForWikiId( $wikiId ) {
		return $this->getDataSourceForWikiId( $wikiId )->getDbName();
	}
	
	/**
	 * Returns an instance of GlobalTitle provided a Wiki ID
	 * @param int $wikiId
	 * @return GlobalTitle
	 */
	protected function getMainPageTitleForWikiId( $wikiId ) {
		$response = \ApiService::foreignCall(
			$this->getDbNameForWikiId( $wikiId ), 
			array(
					'action'      => 'query',
					'meta'        => 'allmessages',
					'ammessages'  => 'mainpage',
					'amlang'      => $this->getGlobalForWiki( 'LanguageCode', $wikiId )
					) 
			);
	    return \GlobalTitle::newFromText( $response['query']['allmessages'][0]['*'], NS_MAIN, $wikiId );
	}
}