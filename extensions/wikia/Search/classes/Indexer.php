<?php
/**
 * Class definition for Wikia\Search\Indexer
 */
namespace Wikia\Search;
use \Solarium_Client, \WikiaException, Wikia\Search\IndexService, \WikiDataSource, \Wikia, \ScribeProducer;
/**
 * This class is responsible for (soon to be) deprecated getPages functionality, and application-based indexing logic.
 * @author relwell
 * @package Search
 */
class Indexer
{
	/**
	 * Used for querying Solr
	 * @var Solarium_Client
	 */
	protected $client;
	
	/**
	 * Interface to MediaWiki logic -- need to use this more
	 * @var \Wikia\Search\MediaWikiService
	 */
	protected $service;
	
	/**
	 * Used to store pages when we make multiple invocations for the same page ID
	 * @var array
	 */
	protected $articles = array();
	
	/**
	 * Used to determine which services to invoke during WikiaSearchIndexer::getPage()
	 * @var array
	 */
	protected $serviceNames = array(
			'DefaultContent',
			'Metadata',
			'MediaData',
			'Redirects',
			'Wam',
			'WikiPromoData',
			'WikiViews'
	);
	
	/**
	 * Handles dependency injection for solarium client
	 */
	public function __construct() {
		$this->interface = new MediaWikiService;
		$master = $this->interface->isOnDbCluster() ? $this->interface->getGlobal( 'SolrHost' ) : 'staff-search-s1';
		$params = array(
				'adapter' => 'Curl',
				'adapteroptions' => array(
						'host' => $master,
						'port' => 8983,
						'path' => '/solr/'
						 )
				);
		$this->client = new Solarium_Client( $params );
		$this->logger = new Wikia();
	}
		
	/**
	 * Used to generate indexing data for a number of page IDs on a given  wiki
	 * @see WikiaSearchController::getPages()
	 * @param array $pageIds those ids we want to populate indexing data for
	 * @return array result, for JSON encoding 
	 */
	public function getPages( array $pageIds ) {
		wfProfileIn(__METHOD__);
		$result = array(
				'pages'			=> array(), 
				'missingPages'	=> array(), 
		);

		foreach ( $pageIds as $pageId ) {
			try {
				$result['pages'][$pageId] = $this->getPage( $pageId );
			} catch (WikiaException $e) {
				/**
				 * here's how we will pretend that a page is empty for now. the risk is that if any of the
				 * API code is broken in the getPage() method, it will tell the indexer to queue the page up
				 * for removal from the index.
				 **/
				$result['missingPages'][] = $pageId;
			}
		}
		wfProfileOut(__METHOD__);
		return $result;
	}

	/**
	 * This method does the brunt of the work for populating an array with the values
	 * we need when servicing the backend search indexer processes
	 * @param int $pageId
	 * @throws WikiaException
	 * @return array result
	 */
	public function getPage( $pageId ) {
		wfProfileIn(__METHOD__);
		$result = array( 'id' => sprintf( '%s_%s', $this->interface->getWikiId(), $this->interface->getCanonicalPageIdFromPageId( $pageId ) ) );

		foreach ( $this->serviceNames as $serviceName ) {
			$serviceResult = $this->getService( $serviceName )
			                      ->setPageId( $pageId )
			                      ->execute();
			
			if ( is_array( $serviceResult ) ) {
    			$result = array_merge( $result, $serviceResult );
			}
		}
		wfProfileOut(__METHOD__);
		return $result;
	}
	
	/**
	 * Helper for instantiating or retrieving stored services
	 * @param string $serviceName
	 * @return WikiaSearchIndexServiceAbstract
	 */
	public function getService( $serviceName ) {
		if (! isset( $this->services[$serviceName] ) ) {
			$this->services[$serviceName] = (new IndexService\Factory)->get( $serviceName ); 
		}
		return $this->services[$serviceName]; 
	}
	
	/**
	 * Generates a Solr document from a page ID
	 * @param  int $pageId
	 * @return Wikia\Search\Result 
	 */
	public function getSolrDocument( $pageId ) {
		$this->interface->setGlobal( 'AppStripsHtml', true );
		$pageData = $this->getPage( $pageId );
		return new Result( $pageData );
	}
	
	/**
	 * Iterates over a set of page IDs reindexes their articles
	 * @param  array $documentIds
	 * @return bool true
	 */
	public function reindexBatch( array $documentIds = array() ) {
		$documents = array();
		foreach ($documentIds as $id ) {
			$documents[] = $this->getSolrDocument( $id );
		}
		return $this->updateDocuments( $documents );
	}
	
	/**
	 * Sends an update query to the client, provided a document set
	 * @param array $documents
	 * @return boolean
	 */
	public function updateDocuments( array $documents = array() ) {
		$updateHandler = $this->client->createUpdate();
		$updateHandler->addDocuments( $documents );
		$updateHandler->addCommit();
		try {
			$this->client->update( $updateHandler );
		} catch ( \Exception $e ) {
			$this->logger->log( __METHOD__, '', $e );
		}
		return true;
	}
	
	/**
	 * Emits scribe events for each page to be reindexed by the search backend
	 * @param int $wid
	 */
	public function reindexWiki( $wid ) {
		try {
			$dataSource = new WikiDataSource( $wid );
			$dbHandler = $dataSource->getDB();
			$rows = $dbHandler->query( "SELECT page_id FROM page" );
			while ( $page = $dbHandler->fetchObject( $rows ) ) {
				$sp = new ScribeProducer( 'reindex', $page->page_id );
				$sp->reindexPage();
			}
		} catch ( \Exception $e ) {
			$this->logger->log( __METHOD__, '', $e );
		}
	}
	
	/**
	 * Deletes all documents containing the provided wiki ID
	 * Careful, this will alter our index!
	 * @param int $wid
	 * @return Solarium_Result|null
	 */
	public function deleteWikiDocs( $wid ) {
		$updateHandler = $this->client->createUpdate();
		$query = Utilities::valueForField( 'wid', $wid );
		$updateHandler->addDeleteQuery( $query );
		$updateHandler->addCommit();
		try {
			return $this->client->update( $updateHandler );
		} catch ( \Exception $e ) {
			F::build( 'Wikia' )->Log( __METHOD__, 'Delete: '.$query, $e);
		}
	}

	/**
	 * Deletes all documents containing one of the provided wiki IDs
	 * Used in the handle-closed-wikis maintenance script
	 * Careful, this will alter our index!
	 * @param  array $wids
	 * @return Solarium_Result|null
	 */
	public function deleteManyWikiDocs( $wids ) {
		$updateHandler = $this->client->createUpdate();
		foreach ( $wids as $wid ) {
			$query = Utilities::valueForField( 'wid', $wid );
			$updateHandler->addDeleteQuery( $query );
		}
		$updateHandler->addCommit();
		try {
			return $this->client->update( $updateHandler );
		} catch ( \Exception $e ) {
			$this->logger->log( __METHOD__, 'Delete: '.$query, $e);
		}
	}
	
	/**
	 * Given a set of page IDs, deletes by query
	 * @param  array $documentIds
	 * @return bool true
	 */
	public function deleteBatch( array $documentIds = array() ) {
	    $updateHandler = $this->client->createUpdate();
	    foreach ( $documentIds as $id ) {
		    $updateHandler->addDeleteQuery( Utilities::valueForField( 'id', $id ) );
	    }
		$updateHandler->addCommit();
	    try {
	        $this->client->update( $updateHandler );
	    } catch ( \Exception $e ) {
	        $this->logger->log( __METHOD__, implode( ',', $documentIds ), $e);
		}

		return true;
	}
	
	/**
	 * Written to work as a hook
	 * @param int $pageId
	 */
	public function reindexPage( $pageId ) {
		return $this->reindexBatch( array( $this->getSolrDocument( $pageId ) ) );
	}
	
	/**
	 * Written to work as a hook
	 * @param int $pageId
	 */
	public function deleteArticle( $pageId) {
		
		$id		= sprintf( '%s_%s', $this->interface->getWikiId(), $pageId );
		
		$this->deleteBatch( array( $id ) );
		
		return true;
	}
}