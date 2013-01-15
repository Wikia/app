<?php
/**
 * Class definition for \Wikia\Search\IndexService\AbstractService
 * @author relwell
 */
namespace Wikia\Search\IndexService;
/**
 * This class allows us to define a standard API for indexing services
 * @author relwell
 */
abstract class AbstractService extends \WikiaObject
{
	/**
	 * Allows us to memoize article instantiation based on pageid
	 * @var array
	 */
	public static $articles = array();
	
	/**
	 * We use this client as an interface for building documents and writing XML
	 * @var Solarium_Client
	 */
	protected $client;
	
	/**
	 * Stores page ids so that we don't need to pass it to execute method
	 * This allows us to reuse wiki-scoped logic
	 * @var array
	 */
	protected $pageIds = array();
	
	/**
	 * A pointer to the page ID we're currently operating on.
	 * Allows us to interact with a specific page ID during iteration without passing it.
	 * @var int
	 */
	protected $currentPageId;
	
    /**
	 * Handles dependency injection for solarium client
	 * @param \Solarium_Client $client
	 */
	public function __construct( \Solarium_Client $client, array $pageIds = array() ) {
	    $this->client = $client;
	    $this->pageIds = $pageIds;
	    parent::__construct();
	}
	
	/**
	 * Used when we're only executing a single iteration
	 * @param int $pageId
	 * @return WikiaSearchIndexerAbstract
	 */
	public function setPageId( $pageId ) {
		$this->currentPageId = $pageId;
		return $this;
	}
	
	/**
	 * Declares the page scope of the indexing service
	 * @param array $pageIds
	 * @return WikiaSearchIndexServiceAbstract
	 */
	public function setPageIds( array $pageIds = array() ) {
		$this->pageIds = $pageIds;
		return $this;
	}
	
	
	/**
	 * We should return an associative array that keys document fields to values
	 * If this operates within the scope of an entire wiki  
	 * @return array
	 */
	abstract public function execute();
	
    /**
	 * Standard interface for this class's services to access a page
	 * @param int $pageId
	 * @return Article
	 * @throws WikiaException
	 */
	protected function getPageFromPageId( $pageId ) {
		wfProfileIn( __METHOD__ );
		if ( isset( self::$articles[$pageId] ) ) {
			return self::$articles[$pageId];
		}
	    $page = \Article::newFromID( $pageId );
	
		if( $page === null ) {
			throw new \WikiaException( 'Invalid Article ID' );
		}
		if( $page->isRedirect() ) {
			$page = new \Article( $page->getRedirectTarget() );
			self::$articles[$page->getID()] = $page;
		}
		self::$articles[$pageId] = $page;
		
		wfProfileOut(__METHOD__);
		return $page;
	}
	
    /**
	 * Allows us to reuse the same basic JSON structure for any number of service calls
	 * @param string $fname
	 * @param array $pageIds
	 * @return Ambigous <multitype:multitype: , unknown>
	 */
	public function getResponseForPageIds() {
		wfProfileIn(__METHOD__);
		
		$result = array( 'contents' => '', 'errors' => array() );
		$documents = array();
		
		foreach ( $this->pageIds as $pageId ) {
			try {
				$this->currentPageId = $pageId;
				$responseArray = $this->execute();
				
				$document = new \Solarium_Document_AtomicUpdate( $responseArray );
				$pageIdKey = $document->pageid ?: sprintf( '%s_%s', $this->wg->CityId, $pageId );
				$document->setKey( 'pageid', $pageIdKey );
				
				foreach ( $document->getFields() as $field => $value ) {
					// for now multivalued fields will be exclusively fully written. keep that in mind
					if ( $field != 'pageid' && !in_array( array_shift( explode( '_', $field ) ), \WikiaSearch::$multiValuedFields ) ) {
						// we may eventually need to specify for some fields whether we should use ADD
    					$document->setModifierForField( $field, \Solarium_Document_AtomicUpdate::MODIFIER_SET );
					}
				}
				
				$documents[] = $document;
				
			} catch ( \WikiaException $e ) {
				$result['errors'][] = $pageId;
			}
		}
		
		$result['contents'] = $this->getUpdateXmlForDocuments( $documents );
		
		wfProfileOut(__METHOD__);
		return $result;
	}
	
    /**
	 * Sends an update query to the client, provided a document set
	 * @param array $documents
	 * @return boolean
	 */
	public function getUpdateXmlForDocuments( array $documents = array() ) {
		$updateHandler = $this->client->createUpdate()
		                              ->addDocuments( $documents )
		                              ->addCommit();
		return $this->client->createRequest( $updateHandler )->getRawData( $updateHandler );
		
	}
	
    /**
	 * Provided a page, returns the string value of that page's title
	 * This allows us to accommodate unconventional locations for titles
	 * @param Title $title
	 * @return string
	 */
	protected function getTitleString( \Title $title ) {
		if ( in_array( $title->getNamespace(), array( NS_WIKIA_FORUM_BOARD_THREAD, NS_USER_WALL_MESSAGE ) ) ){
			$wm = \WallMessage::newFromId( $title->getArticleID() );
			$wm->load();
			
			if ( !$wm->isMain() && ( $main = $wm->getTopParentObj() ) && !empty( $main ) ) {
				$main->load();
				$wm = $main;
			}
			
			return (string) $wm->getMetaTitle();
		}
		return (string) $title;
	}
}