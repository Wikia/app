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
	 * Allows us to reuse an atomic update for multiple documents on the backend, if it applies to a wiki and not a page.
	 */
	const PAGEID_PLACEHOLDER = '#WIKIA_PAGE_ID_VALUE#';
	
	/**
	 * We use this client as an interface for building documents and writing XML
	 * @var Solarium_Client
	 */
	protected $client;
	
	/**
	 * This allows us to abstract out logic core to MediaWiki. 
	 * Eventually, we could have other 'drivers' for our logic interface here.
	 * Sorry I didn't have a better name for this one -- maybe "driver"?
	 * @var Wikia\Search\MediaWikiInterface
	 */
	protected $interface;
	
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
		
		foreach ( $this->pageIds as $pageId ) {
			$this->currentPageId = $pageId;
			try {
				$documents[] = $this->getDocumentFromResponse( $this->execute() );
			} catch ( \WikiaException $e ) {
				$result['errors'][] = $pageId;
			}
		}
		
		$result['contents'] = $this->getUpdateXmlForDocuments( $documents );
		
		wfProfileOut(__METHOD__);
		return $result;
	}
	
	/**
	 * Given an array, creates an appropriately formatted Solarium document
	 * @param array $responseArray
	 * @return \Solarium_Document_AtomicUpdate
	 */
	protected function getDocumentFromResponse( array $responseArray ) {
		$document = new \Solarium_Document_AtomicUpdate( $responseArray );
		
		$pageIdValue = $this->currentPageId ?: self::PAGEID_PLACEHOLDER;
		$pageIdKey = $document->pageid ?: sprintf( '%s_%s', $this->interface->getGlobal( 'CityId' ), $pageIdValue );
		$document->setKey( 'pageid', $pageIdKey );
		
		foreach ( $document->getFields() as $field => $value ) {
			// for now multivalued fields will be exclusively fully written. keep that in mind
			if ( $field != 'pageid' && !in_array( array_shift( explode( '_', $field ) ), \WikiaSearch::$multiValuedFields ) ) {
				// we may eventually need to specify for some fields whether we should use ADD
				$document->setModifierForField( $field, \Solarium_Document_AtomicUpdate::MODIFIER_SET );
			}
		}
		return $document;
	}
	
    /**
	 * Sends an update query to the client, provided a document set
	 * @param array $documents
	 * @return boolean
	 */
	protected function getUpdateXmlForDocuments( array $documents = array() ) {
		$updateHandler = $this->client->createUpdate()
		                              ->addDocuments( $documents )
		                              ->addCommit();
		return $this->client->createRequest( $updateHandler )->getRawData( $updateHandler );
		
	}
}