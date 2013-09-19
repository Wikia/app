<?php
/**
 * Class definition for \Wikia\Search\IndexService\AbstractService
 * @author relwell
 */
namespace Wikia\Search\IndexService;
use Wikia\Search\MediaWikiService;
/**
 * This class allows us to define a standard API for indexing services
 * @author relwell
 * @abstract
 * @package Search
 * @subpackage IndexService
 */
abstract class AbstractService
{
	/**
	 * This allows us to abstract out logic core to MediaWiki. 
	 * Eventually, we could have other 'drivers' for our logic interface here.
	 * Sorry I didn't have a better name for this one -- maybe "driver"?
	 * @var Wikia\Search\MediaWikiService
	 */
	protected $service;
	
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
	 * Allows us to avoid duplication
	 * @var array
	 */
	protected $processedDocIds = array();
	
    /**
	 * Allows us to instantiate a service with pageIds already set
	 * @param array $pageIds
	 */
	public function __construct( array $pageIds = array() ) {
	    $this->pageIds = $pageIds;
	}
	
	/**
	 * Used when we're only executing a single iteration
	 * @param int $pageId
	 * @return Wikia\Search\IndexService\AbstractService
	 */
	public function setPageId( $pageId ) {
		$this->currentPageId = $pageId;
		return $this;
	}
	
	/**
	 * Declares the page scope of the indexing service
	 * @param array $pageIds
	 * @return Wikia\Search\IndexService\AbstractService
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
	 * @return string
	 */
	public function getResponseForPageIds() {
		wfProfileIn(__METHOD__);

		$result = array( 'contents' => '', 'errors' => array() );
		$documents = array();

		foreach ( $this->pageIds as $pageId ) {
			$this->currentPageId = $pageId;
			$currId = $this->getCurrentDocumentId();
			$actId = $this->getCurrentDocumentId(false);
		    if (! $this->getService()->pageIdExists( $pageId ) ) {
				$documents[] = array( "delete" => array( "id" =>$currId ) );
				continue;
			}

			if( $currId!=$actId)
			{
				$documents[] = array( "delete" => array( "id" => $actId ) );
				continue;
			}

			if ( in_array( $currId, $this->processedDocIds ) ) {
				continue;
			}

			try {
				$response = $this->getResponse();

				$this->processedDocIds[] = $actId;
				if (! empty( $response ) ) {
				    $documents[] = $this->getJsonDocumentFromResponse( $response );
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
	 * @param bool $resolveRedirect
	 * @return string
	 */
	public function getCurrentDocumentId($resolveRedirect = true) {
		return sprintf( '%s_%s', $this->getService()->getWikiId(), $resolveRedirect ? $this->getService()->getCanonicalPageIdFromPageId( $this->currentPageId ) :  $this->currentPageId );
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
	
	/**
	 * Lazy-loads service dependency
	 * @return MediaWikiService
	 */
	protected function getService() {
		if ( $this->service === null ) {
			$this->service = new MediaWikiService;
		}
		return $this->service;
	}
	

	/**
	 * Hook for resetting any state specific to a single page
	 * @return \Wikia\Search\IndexService\AbstractService
	 */
	protected function reinitialize() {
		return $this;
	}
	
	/**
	 * Execute with hook to reinitialize
	 * @return \Wikia\Search\IndexService\AbstractService
	 */
	protected function getResponse() {
		try {
			$response = $this->execute();
		} catch ( \Exception $e ) {
			$this->reinitialize();
			throw $e;
		}
		$this->reinitialize();
		return $response;
	}
	
}