<?php
/**
 * Class definition for \Wikia\Search\MediaWikiService
 * @author relwell
 */
namespace Wikia\Search;
/**
 * Encapsulates MediaWiki functionalities.
 * This will allow us to abstract our behavior away from MediaWiki if we want.
 * Public functions should not return instances of classes defined in MediaWiki core.
 * @author relwell
 * @package Search
 */
class MediaWikiService
{

	/**
	 * Wiki default lang
	 */
	const WIKI_DEFAULT_LANG_CODE = 'en';

	/**
	 * Thumbnails default size, used for getting article images
	 */
	const THUMB_DEFAULT_WIDTH = 160;
	const THUMB_DEFAULT_HEIGHT = 100;

	/**
	 * Application interface
	 * @var \WikiaApp
	 */
	protected $app;
	
	/**
	 * Allows us to memoize article instantiation based on pageid
	 * @var array
	 */
	static protected $pageIdsToArticles = array();
	
	/**
	 * Allows us to cache titles based on page id
	 * @var array
	 */
	static protected $pageIdsToTitles = array();
	
	/**
	 * Allows us to recover the canonical page ID
	 * @var array
	 */
	static protected $redirectsToCanonicalIds = array();
	
	/**
	 * Gives direct access to File instance from page id
	 * @var array
	 */
	static protected $pageIdsToFiles = array();
	
	/**
	 * Stores articles that are redirects (helps us grab non-canonical info)
	 * @var array
	 */
	static protected $redirectArticles = array();
	
	/**
	 * An array that corresponds wiki IDs to their wiki data sources.
	 * @var array
	 */
	static protected $wikiDataSources = array();
	
	/**
	 * Constructor method
	 */
	public function __construct() {
		$this->app = \F::app();
	}
	
	/**
	 * Given a page ID, get the title string
	 * @param int $pageId
	 * @return string
	 */
	public function getTitleStringFromPageId( $pageId ) {
		return $this->getTitleString( $this->getTitleFromPageId( $pageId ) );
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
			wfProfileOut( __METHOD__ );
			return $pageId;
		}
		
		if ( isset( self::$redirectsToCanonicalIds[$pageId] ) ) {
			$pageId = self::$redirectsToCanonicalIds[$pageId];
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
	 * Provides global value as set in the Oasis wg helper. Can use wgGlobalValue or GlobalValue.
	 * @param mixed $global
	 * @return mixed
	 */
	public function getGlobal( $global ) {
		$global = substr_count( $global, 'wg', 0, 2 ) ? substr( $global, 2 ) : $global;
		return $this->app->wg->{$global};
	}
	
	/**
	 * Gets global values set for other wikis. Can use wgGlobalValue or GlobalValue
	 * @param string $global
	 * @param int $wikiId
	 * @return mixed
	 */
	public function getGlobalForWiki( $global, $wikiId ) {
		$global = substr_count( $global, 'wg', 0, 2 ) ? $global : ( 'wg' . ucfirst( $global ) );
		$row = (new \WikiFactory)->getVarValueByName( $global, $wikiId );
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
	 * @return \Wikia\Search\MediaWikiService
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
		$dbr = wfGetDB(DB_SLAVE);
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
	 * @param array $namespaces
	 * @return array of namespace strings
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
		$canonicalPageId = $this->getCanonicalPageIdFromPageId( $pageId );
		$articleService = new \ArticleService( $canonicalPageId );
		return $articleService->getTextSnippet( $snippetLength );
	}
	
	/**
	 * Returns the non-canonical title string for page ID (redirects ignored)
	 * @param int $pageId
	 * @return string
	 */
	public function getNonCanonicalTitleStringFromPageId( $pageId ) {
		if ( isset( self::$redirectArticles[$pageId] ) ) {
			return $this->getTitleString( self::$redirectArticles[$pageId]->getTitle() );
		}
		return $this->getTitleStringFromPageId( $pageId ); 
	}
	
	/**
	 * Returns the non-canonical url string for page ID (redirects ignored)
	 * @param int $pageId
	 * @return string
	 */
	public function getNonCanonicalUrlFromPageId( $pageId ) {
		if ( isset( self::$redirectArticles[$pageId] ) ) {
			return self::$redirectArticles[$pageId]->getTitle()->getFullUrl();
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
		$articleMatch = null;
		$searchEngine = new \SearchEngine();
		$title = $searchEngine->getNearMatch( $term );
		$articleId = ( $title !== null ) ? $title->getArticleId() : 0;
		if( ( $articleId > 0 ) && ( in_array( $title->getNamespace(), $namespaces ) ) ) {
			$this->getPageFromPageId( $articleId );
			$articleMatch = new \Wikia\Search\Match\Article( $title->getArticleId(), $this );
		}
		return $articleMatch;
	}
	
	/**
	 * Provided a prepped domain string, (e.g. 'runescape'), return a wiki match.
	 * @param string $domain
	 * @return \Wikia\Search\Match\Wiki|NULL
	 */
	public function getWikiMatchByHost( $domain ) {
		$match = null;
		if ( $domain !== '' ) {
			$langCode = $this->getLanguageCode();
			if ( $langCode === static::WIKI_DEFAULT_LANG_CODE ) {
				$wikiId = $this->getWikiIdByHost( $domain . '.wikia.com' );
			} else {
				$wikiId = ( $interWikiComId = $this->getWikiIdByHost( "{$langCode}.{$domain}.wikia.com" ) ) !== null ? $interWikiComId : $this->getWikiIdByHost( "{$domain}.{$langCode}" );
			}
			//exclude wikis which lang does not match current one
			$wikiLang = $this->getGlobalForWiki( 'wgLanguageCode', $wikiId );
			//if wiki lang not set display only for default language
			if ( isset( $wikiId ) && ( ( !$wikiLang && $langCode === static::WIKI_DEFAULT_LANG_CODE ) || ( $langCode === $wikiLang ) ) ) {
				$match = new \Wikia\Search\Match\Wiki( $wikiId, $this );
			}
		}
		return $match;
	}
	
	/**
	 * For a given wiki ID, get all values in the city_domain table.
	 * @param int $wikiId
	 * @return array
	 */
	public function getDomainsForWikiId( $wikiId ) {
		$dbw = wfGetDB( DB_SLAVE, [], $this->getGlobal( 'ExternalSharedDB' ) );
		$dbResult = $dbw->select(
			array( "city_domains" ),
			array( "*" ),
			array( "city_id" => $wikiId ),
			__METHOD__
		);
		$result = [];
		while( $row = $dbw->fetchObject( $dbResult ) ) {
			$result[] = $row->city_domain;
		}
		return $result;
	}
	
	/**
	 * Given a domain, returns a wiki ID.
	 * @param string $domain
	 * @return int|null
	 */
	public function getWikiIdByHost( $domain ) {
		return (new \WikiFactory)->DomainToID( $domain );
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
	 * Returns the article ID of a main page for the wiki ID passed.
	 * @param int $wikiId
	 * @return Ambigous <number, boolean>
	 */
	public function getMainPageIdForWikiId( $wikiId ) {
		return $this->getMainPageTitleForWikiId( $wikiId )->getArticleId();
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
				'titles' => $this->getMainPageTitleForWikiId( $wikiId )->getDbKey()
				);
		$response = (new \ApiService)->foreignCall( $this->getDbNameForWikiId( $wikiId ), $params, \ApiService::WIKIA );
		$item = \array_shift( $response['items'] );
		return $item['abstract'];
	}
	
	/**
	 * Returns text from the main page of a provided wiki.
	 * @param int $wikiId
	 * @return string
	 */
	public function getDescriptionTextForWikiId( $wikiId ) {
		$response = (new \ApiService)->foreignCall(
			$this->getDbNameForWikiId( $wikiId ), 
			array(
					'action'      => 'query',
					'meta'        => 'allmessages',
					'ammessages'  => 'description',
					'amlang'      => $this->getGlobalForWiki( 'wgLanguageCode', $wikiId )
					) 
			);
		return str_replace( '{{SITENAME}}', $this->getGlobalForWiki( 'wgSitename', $wikiId ), $response['query']['allmessages'][0]['*'] );
	}
	
	/**
	 * Returns the string name of the top-level hub for the provided wiki ID
	 * @param $wikiId
	 * @return string
	 */
	public function getHubForWikiId( $wikiId ) {
		return (new \HubService())->getCategoryInfoForCity( $wikiId )->cat_name;
	}
	
	/**
	 * Returns the string name of a sub-hub for the provided wiki ID.
	 * @param int $wikiId
	 * @return string
	 */
	public function getSubHubForWikiId( $wikiId ) {
		$cat = (new \WikiFactory)->getCategory( $wikiId );
		return is_object( $cat ) ? $cat->cat_name : $cat;
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
		return $this->app->wg->Lang ? $this->app->wg->Lang->date( wfTimestamp( TS_MW, $timestamp ) ) : '';
	}
	
	/**
	 * Access visualization info for a wiki.
	 * The underscore indicates that it is public exposed as a cached magic method.
	 * @param int $wikiId
	 * @return array
	 */
	public function getVisualizationInfoForWikiId( $wikiId ) {
		$visualization = (new \WikisModel )->getDetails( [ $wikiId ] );
		$visualization = empty( $visualization ) ? [ [] ] : $visualization;
		return array_shift( $visualization );
	}

	/**
	 * Uses WikiService to access stats info. 
	 * We add '_count' to each key clarify these are count values
	 * @param int $wikiId
	 * @return array
	 */
	public function getStatsInfoForWikiId( $wikiId ) {
		$service = new \WikiService;
		$statsInfo = $service->getSiteStats( $wikiId );
		$statsInfo['videos'] = $service->getTotalVideos( $wikiId ); 
		foreach ( $statsInfo as $key => $val ) {
			$statsInfo[$key.'_count'] = $val;
			unset( $statsInfo[$key] );
		}
		return $statsInfo;
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

	public function getThumbnailUrl( $pageId, $dimensions = null ) {
		$width = (isset( $dimensions[ 'width' ] ) ) ? $dimensions[ 'width' ] : static::THUMB_DEFAULT_WIDTH;
		$height = (isset( $dimensions[ 'height' ] ) ) ? $dimensions[ 'height' ] : static::THUMB_DEFAULT_HEIGHT;
		$imgSource = $this->getImageServing( $pageId, $width, $height );
		//get one image only
		$img = $imgSource->getImages( 1 );
		if ( !empty( $img ) ) {
			return $img[ $pageId ][ 0 ][ 'url' ];
		}
		return false;
	}

	/**
	 * Gets image serving for page, moved to external method for easier testing
	 * @param $pageId
	 * @param $width
	 * @param $height
	 * @return \ImageServing
	 */
	protected function getImageServing( $pageId, $width, $height ) {
		return new \ImageServing( array( $pageId ), $width, $height );
	}

	public function getThumbnailHtml( $pageId, $transformParams = null, /* WikiaGrid 1 column width */ $htmlParams = array( 'desc-link'=>true, 'img-class'=>'thumbimage', 'duration'=>true ) ) {
		$html = '';
		$img = $this->getFileForPageId( $pageId );
		if (! empty( $img ) ) {
			$transformParams[ 'width' ] = (isset( $transformParams[ 'width' ] ) ) ? $transformParams[ 'width' ] : static::THUMB_DEFAULT_WIDTH;
			$transformParams[ 'height' ] = (isset( $transformParams[ 'height' ] ) ) ? $transformParams[ 'height' ] : static::THUMB_DEFAULT_HEIGHT;
			$thumb = $img->transform( $transformParams );
			$html = $thumb->toHtml( $htmlParams );
		}
		return $html;
	}

	/**
	 * @param string $pageTitle
	 * @param array|null $transformParams
	 * @return string|null - html of thumbnail with play button
	 */
	public function getThumbnailHtmlFromPageTitle( $pageTitle, $transformParams = null ) {
		$file = null;
		try {
			$title = \Title::newFromText( $pageTitle, NS_FILE );

			$transformParams[ 'width' ] = (isset( $transformParams[ 'width' ] ) ) ? $transformParams[ 'width' ] : static::THUMB_DEFAULT_WIDTH;
			$transformParams[ 'height' ] = (isset( $transformParams[ 'height' ] ) ) ? $transformParams[ 'height' ] : static::THUMB_DEFAULT_HEIGHT;

			return \WikiaFileHelper::getVideoThumbnailHtml( $title, $transformParams['width'], $transformParams['height'], false );
		} catch ( \Exception $ex ) {
			// we have some isses on dev box (no starter database).
			// swallow the exception for now. Should we log this event ?
			return '';
		}
	}

	/**
	 * Returns the number of video views for a page ID.
	 * @param int $pageId
	 * @return string
	 */
	public function getFormattedVideoViewsForPageId( $pageId ) {
		return wfMsgExt( 'videohandler-video-views', array( 'parsemag' ), $this->formatNumber( $this->getVideoViewsForPageId( $pageId ) ) );
	}
	
	public function getVideoViewsForPageId( $pageId ) {
		$title = $this->getTitleFromPageId( $pageId );
		$videoViews = 0;
		if ( ( new \WikiaFileHelper )->isFileTypeVideo( $title ) ) {
			$videoViews = ( new \MediaQueryService )->getTotalVideoViewsByTitle( $title->getDBKey() );
		}
		return $videoViews;
	}
	
	/**
	 * Returns a number formatted according to the current language.
	 * @param string $number
	 */
	public function formatNumber( $number ) {
		return $this->app->wg->Lang->formatNum( $number ); 
	}
	
	/**
	 * Compares a pageid to the main page's article ID for this wiki.
	 * False if the main page ID is 0.
	 * @param int $pageId
	 * @return boolean
	 */
	public function isPageIdMainPage( $pageId ) {
		return $pageId !== 0 && $pageId == $this->getMainPageArticleId();
	}
	
	/**
	 * Returns the hostname for a wiki. e.g. returns 'rap.wikia.com' for $wgServer = http://rap.wikia.com.
	 * @return string
	 */
	public function getHostName() {
		return substr( $this->getGlobal( 'Server' ), 7);
	}
	
	/**
	 * Wrapper for wfMessage('foo')->text()
	 * @param string $messageName
	 * @return string
	 */
	public function getSimpleMessage( $messageName, array $params = array() ) {
		return wfMessage( $messageName, $params )->text();
	}

	/**
	 * Put a number into the i18n message based on the quantity. For $number smaller than 1000, $msgName is used.
	 * For $number between 1K and 1M a message with '-k' postfix is used to display the number of thousands.
	 * For $number 1M and greated a message with '-M' postfix is used to display the number of millions
	 * TODO: should be abstracted and added to $wg->Lang
	 *
	 * @author Rafal
	 * @author Mech
	 * @param int $number - number to be put into the i18n message
	 * @param string $msgName - message id, for bigger $number values a message with postfix is used
	 * @return string
	 */
	public function shortNumForMsg($number, $msgName) {
		if ($number >= 1000000) {
			$shortNum = floor($number / 1000000);
			$msgName = $msgName . '-M';
		} else if ($number >= 1000) {
			$shortNum = floor($number / 1000);
			$msgName = $msgName . '-k';
		} else {
			$shortNum = $number;
		}

		return wfMessage($msgName, $shortNum, $number);
	}
	
	/**
	 * Provides a relative URL provided a page id, with optional query string as array. 
	 * @param int $pageId
	 * @param array $query
	 * @param bool $query2
	 * @return string
	 */
	public function getLocalUrlForPageId( $pageId, $query = array(), $query2 = false ) {
		return $this->getTitleFromPageId( $pageId )->getLocalUrl( $query, $query2 );
	}

	/**
	 * Returns the memcache key for the given string
	 * 
	 * @param string $key
	 * @return string
	 */
	public function getCacheKey( $key ) {
		return wfSharedMemcKey( $key, $this->getWikiId() );
	}
	
	/**
	 * Returns what's set in memcache through the app
	 * 
	 * @param string $key
	 * @return array
	 */
	public function getCacheResult( $key ) {
		return $this->app->wg->Memc->get( $key );
	}
	
	/**
	 * Returns the cached result without the intermediate cache query in
	 * consumer logic
	 * 
	 * @param string $key
	 * @return multitype
	 */
	public function getCacheResultFromString( $key ) {
		return $this->getCacheResult( $this->getCacheKey( $key ) );
	}
	
	/**
	 * Wrapper for WikiaApp::registerHook
	 * @param string $event
	 * @param string $class
	 * @param string $method
	 * @deprecated
	 */
	public function registerHook( $event, $class, $method ) {
		$this->app->registerHook( $event, $class, $method );
	}
	
	/**
	 * Allows us to set values in global memcache without knowing the memcache
	 * key
	 * 
	 * @param string $key
	 * @param mixed $value
	 * @param int $ttl defaults to a day
	 * @return \Wikia\Search\MediaWikiService
	 */
	public function setCacheFromStringKey( $key, $value, $ttl = 86400 ) {
		$this->app->wg->Memc->set( $this->getCacheKey( $key ), $value, $ttl );
		return $this;
	}
	
	/**
	 * Provides a format, provided a revision's default timestamp format.
	 * @param string $timestamp
	 */
	protected function getFormattedTimestamp( $timestamp ) {
		return wfTimestamp( TS_ISO_8601, $timestamp );
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
		if (! isset( self::$pageIdsToFiles[$pageId] ) ) {
			self::$pageIdsToFiles[$pageId] = wfFindFile( $this->getTitleFromPageId( $pageId ) );
		}
		return self::$pageIdsToFiles[$pageId];
	}
	
    /**
	 * Standard interface for this class's services to access a page
	 * @param int $pageId
	 * @return Article
	 * @throws \Exception
	 */
	protected function getPageFromPageId( $pageId ) {
		wfProfileIn( __METHOD__ );
		if ( isset( self::$pageIdsToArticles[$pageId] ) ) {
			wfProfileOut( __METHOD__ );
			return self::$pageIdsToArticles[$pageId];
		}
		$page = \Article::newFromID( $pageId );

		if( $page === null ) {
			throw new \Exception( 'Invalid Article ID' );
		}

		$redirectTarget = null;
		if ( $page->isRedirect() ) {
			$redirectTarget = $page->getRedirectTarget();
		}

		if( $redirectTarget ) {
			self::$redirectArticles[$pageId] = $page;
			$page = new \Article( $redirectTarget );
			$newId = $page->getID();
			self::$pageIdsToArticles[$newId] = $page;
			self::$redirectsToCanonicalIds[$pageId] = $newId;
		}
		self::$pageIdsToArticles[$pageId] = $page;
		
		wfProfileOut(__METHOD__);
		return $page;
	}
	
    /**
	 * Provided a page, returns the string value of that page's title
	 * This allows us to accommodate unconventional locations for titles
	 * @param \Title $title
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
			wfProfileOut( __METHOD__ );

			return (string) $wm->getMetaTitle();
		}
		wfProfileOut(__METHOD__);
		return $title->getFullText();
	}
	
	/**
	 * Allows us to access an instance of WikiDataSource
	 * @param int $wikiId
	 * @return \WikiDataSource
	 */
	protected function getDataSourceForWikiId( $wikiId ) {
		if ( empty( self::$wikiDataSources[$wikiId] ) ) {
			self::$wikiDataSources[$wikiId] = new \WikiDataSource( $wikiId );
		}
		return self::$wikiDataSources[$wikiId];
	}

	/**
	 * Returns the database name for a given wiki
	 * @param int $wikiId
	 * @return string
	 */
	protected function getDbNameForWikiId( $wikiId ) {
		return $this->getDataSourceForWikiId( $wikiId )->getDbName();
	}
	
	/**
	 * Returns an instance of GlobalTitle provided a Wiki ID
	 * @param int $wikiId
	 * @return GlobalTitle
	 */
	protected function getMainPageTitleForWikiId( $wikiId ) {
		$response = (new \ApiService)->foreignCall(
			$this->getDbNameForWikiId( $wikiId ), 
			array(
					'action'      => 'query',
					'meta'        => 'allmessages',
					'ammessages'  => 'mainpage',
					'amlang'      => $this->getGlobalForWiki( 'wgLanguageCode', $wikiId )
					) 
			);
		$title = \GlobalTitle::newFromText( $response['query']['allmessages'][0]['*'], NS_MAIN, $wikiId );
		if ( $title->isRedirect() ) {
			$title = $title->getRedirectTarget();
		}
		return $title;
	}
	

	/**
	 * Gets a title from a page id
	 * @param int $pageId
	 * @return Title
	 */
	protected function getTitleFromPageId( $pageId ) {
		wfProfileIn( __METHOD__ );
		if (! isset( static::$pageIdsToTitles[$pageId] ) ) {
			$page = $this->getPageFromPageId( $pageId );
			static::$pageIdsToTitles[$pageId] = $page->getTitle();
		}
		wfProfileOut( __METHOD__ );
		return static::$pageIdsToTitles[$pageId];
	}
}
