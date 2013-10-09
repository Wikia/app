<?php
/**
 * Class definition for Wikia\Search\Indexer
 */
namespace Wikia\Search;
use \Solarium_Client, \Exception, \WikiDataSource, \Wikia, \ScribeProducer;
/**
 * This class is responsible for (soon to be) deprecated getPages functionality, and application-based indexing logic.
 * @author relwell
 * @package Search
 */
class Indexer
{
	/**
	 * Interface to MediaWiki logic -- need to use this more
	 * @var \Wikia\Search\MediaWikiService
	 */
	protected $mwService;
	
	/**
	 * Connects to Solr 
	 * @var Solarium_Client
	 */
	protected $client;
	
	/**
	 * Encapsulates Wikia::log functionality
	 * @var Wikia
	 */
	protected $logger;
	
	/**
	 * Stores any IndexServices we have instantiated
	 * @var array
	 */
	protected $indexServices;

	/**
	 * Used to determine which services to invoke during WikiaSearchIndexer::getPage()
	 * @var array
	 */
	protected $serviceNames = array( 'All' );

	/**
	 * Used to generate indexing data for a number of page IDs on a given  wiki
	 * @see WikiaSearchController::getPages()
	 * @param array $pageIds those ids we want to populate indexing data for
	 * @return array result, for JSON encoding 
	 */
	public function getPages( array $pageIds ) {
		$result = array(
				'pages'         => array(),
				'missingPages'  => array(),
		);

		foreach ( $pageIds as $pageId ) {
			try {
				$result['pages'][$pageId] = $this->getPage( $pageId );
			} catch ( Exception $e ) {
				/**
				 * here's how we will pretend that a page is empty for now. the risk is that if any of the
				 * API code is broken in the getPage() method, it will tell the indexer to queue the page up
				 * for removal from the index.
				 **/
				$result['missingPages'][] = $pageId;
			}
		}
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
		$result = array( 'id' => sprintf( '%s_%s', $this->getMwService()->getWikiId(), $this->getMwService()->getCanonicalPageIdFromPageId( $pageId ) ) );

		foreach ( $this->serviceNames as $serviceName ) {
			$serviceResult = $this->getIndexService( $serviceName )
			                      ->setPageId( $pageId )
			                      ->execute();
			
			if ( is_array( $serviceResult ) ) {
    			$result = array_merge( $result, $serviceResult );
			}
		}
		return $result;
	}
	
	/**
	 * Generates a Solr document from a page ID
	 * @param  int $pageId
	 * @return Wikia\Search\Result 
	 */
	public function getSolrDocument( $pageId ) {
		$this->getMwService()->setGlobal( 'AppStripsHtml', true );
		return new Result( $this->getPage( $pageId ) );
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
		$updateHandler = $this->getClient()->createUpdate();
		$updateHandler->addDocuments( $documents );
		$updateHandler->addCommit();
		try {
			$this->getClient()->update( $updateHandler );
		} catch ( \Exception $e ) {
			$this->getLogger()->log( __METHOD__, '', $e );
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
			$this->getLogger()->log( __METHOD__, '', $e );
		}
		return true;
	}
	
	/**
	 * Deletes all documents containing the provided wiki ID
	 * Careful, this will alter our index!
	 * @param int $wid
	 * @return Solarium_Result|null
	 */
	public function deleteWikiDocs( $wid ) {
		$updateHandler = $this->getClient()->createUpdate();
		$query = Utilities::valueForField( 'wid', $wid );
		$updateHandler->addDeleteQuery( $query );
		$updateHandler->addCommit();
		try {
			return $this->getClient()->update( $updateHandler );
		} catch ( \Exception $e ) {
			$this->getLogger()->log( __METHOD__, 'Delete: '.$query, $e);
		}
		return true;
	}

	/**
	 * Deletes all documents containing one of the provided wiki IDs
	 * Used in the handle-closed-wikis maintenance script
	 * Careful, this will alter our index!
	 * @param  array $wids
	 * @return Solarium_Result|null
	 */
	public function deleteManyWikiDocs( $wids ) {
		$updateHandler = $this->getClient()->createUpdate();
		foreach ( $wids as $wid ) {
			$query = Utilities::valueForField( 'wid', $wid );
			$updateHandler->addDeleteQuery( $query );
		}
		$updateHandler->addCommit();
		try {
			return $this->getClient()->update( $updateHandler );
		} catch ( \Exception $e ) {
			$this->getLogger()->log( __METHOD__, 'Delete: '.$query, $e);
		}
	}
	
	/**
	 * Given a set of page IDs, deletes by query
	 * @param  array $documentIds
	 * @return bool true
	 */
	public function deleteBatch( array $documentIds = array() ) {
	    $updateHandler = $this->getClient()->createUpdate();
	    foreach ( $documentIds as $id ) {
		    $updateHandler->addDeleteQuery( Utilities::valueForField( 'id', $id ) );
	    }
		$updateHandler->addCommit();
	    try {
	        $this->getClient()->update( $updateHandler );
	    } catch ( \Exception $e ) {
	        $this->getLogger()->log( __METHOD__, implode( ',', $documentIds ), $e);
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
		$id = sprintf( '%s_%s', $this->getMwService()->getWikiId(), $pageId );
		$this->deleteBatch( array( $id ) );
		return true;
	}
	
	/**
	 * Lazy-loading for the client dependency.
	 * @return \Solarium_Client
	 */
	protected function getClient() {
		if ( $this->client === null ) {
			$master = $this->getMwService()->isOnDbCluster() ? $this->getMwService()->getGlobal( 'SolrHost' ) : 'staff-search-s1';
			$params = array(
					'adapter' => 'Solarium_Client_Adapter_Curl',
					'adapteroptions' => array(
							'host' => $master,
							'port' => 8983,
							'path' => '/solr/'
							)
					);
			$this->client = new Solarium_Client( $params );
		}
		return $this->client;
	}
	
	/**
	 * Lazy loads MW service
	 * @return \Wikia\Search\MediaWikiService
	 */
	protected function getMwService() {
		$this->mwService = $this->mwService ?: new MediaWikiService;
		return $this->mwService;
	}
	
	/**
	 * Lazy loads logger
	 * @return \Wikia
	 */
	protected function getLogger() {
		$this->logger = $this->logger ?: new Wikia;
		return $this->logger;
	}
	
	/**
	 * Helper for instantiating or retrieving stored services
	 * @param string $serviceName
	 * @return WikiaSearchIndexServiceAbstract
	 */
	protected function getIndexService( $serviceName ) {
		if (! isset( $this->indexServices[$serviceName] ) ) {
			$fullServiceName = 'Wikia\Search\IndexService\\' . $serviceName;
			$this->indexServices[$serviceName] = new $fullServiceName; 
		}
		return $this->indexServices[$serviceName]; 
	}
}