<?php
/**
 * Class definition for \Wikia\Search\IndexService\AbstractService
 * @author relwell
 */
namespace Wikia\Search\IndexService;
use Wikia\Search\MediaWikiInterface;
/**
 * This class allows us to define a standard API for indexing services
 * @author relwell
 */
abstract class AbstractService
{
	/**
	 * This allows us to abstract out logic core to MediaWiki. 
	 * Eventually, we could have other 'drivers' for our logic interface here.
	 * Sorry I didn't have a better name for this one -- maybe "driver"?
	 * @var Wikia\Search\MediaWikiInterface
	 */
	protected $interface;
	
	/**
	 * Allows us to provide timing diagnostics for different services
	 * @var bool
	 */
	protected $verbose = false;
	
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
	 * Allows us to instantiate a service with pageIds already set
	 * @param array $pageIds
	 */
	public function __construct( array $pageIds = array() ) {
	    $this->pageIds = $pageIds;
	    $this->interface = MediaWikiInterface::getInstance();
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
	 * Allows us to reuse the same basic JSON structure for any number of service calls
	 * @param string $fname
	 * @param array $pageIds
	 * @return string
	 */
	public function getResponseForPageIds() {
		wfProfileIn(__METHOD__);
		
		$result = array( 'contents' => '', 'errors' => array() );
		$documents = array();
		if ( $this->verbose ) {
    		$result['diagnostics'] = array();
		}
		
		foreach ( $this->pageIds as $pageId ) {
			$this->currentPageId = $pageId;
		    if (! $this->interface->pageIdExists( $pageId ) ) {
				$documents[] = array( "delete" => array( "id" => $this->getCurrentDocumentId() ) );
				continue;
			}
			try {
				$response = $this->execute();
				$time = microtime();
				if (! empty( $response ) ) {
				    $documents[] = $this->getJsonDocumentFromResponse( $response );
				    if ( $this->verbose ) {
				    	$timeDiff = microtime() - $time;
			    	    $result['diagnostics'][$this->currentPageId] = $timeDiff;
				    }
				}
			} catch ( \WikiaException $e ) {
				$result['errors'][] = $pageId;
			}
		}
		$result['contents'] = $documents;
		wfProfileOut(__METHOD__);
		return $result;
	}
	
	/**
	 * Generates a unique ID based on wiki ID and page ID
	 * @return string
	 */
	public function getCurrentDocumentId() {
		return sprintf( '%s_%s', $this->interface->getWikiId(), $this->currentPageId );
	}
	
	/**
	 * Returns an array formatted for the JSON response
	 * @param array $response
	 * @return array
	 */
	public function getJsonDocumentFromResponse( array $response )
	{
		$toJson = array( 'id' => $this->getCurrentDocumentId() );
		foreach ( $response as $field => $value ) {
		    if ( $field !== 'id' ) {
		    	$toJson[$field] = array( 'set' => $value ); 
		    }
		}
		return $toJson;
	}
	
	public function setVerbose( $verbose ) {
		$this->verbose = $verbose;
	}
}