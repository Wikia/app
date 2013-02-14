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
	 */
	public function getGlobal( $global ) {
		return $this->app->wg->{$global};
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
		$shared = $this->getGlobal( 'ExternalSharedDB' );
		return (int) ( empty( $shared ) ? $this->getGlobal( 'SearchWikiId' ) : $this->getGlobal( 'CityId' ) );
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
}