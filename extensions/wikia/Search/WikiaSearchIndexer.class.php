<?php 
/**
 * Class definition for WikiaSearchIndexer
 */
use \Wikia\Search\IndexService\Factory;
use \Wikia\Search\MediaWikiInterface;
/**
 * This class is responsible for handling all the methods needed to serve up document data for indexing.
 * @author Robert Elwell
 */
class WikiaSearchIndexer extends WikiaObject {
	
	/**
	 * Used for querying Solr
	 * @var Solarium_Client
	 */
	protected $client;
	
	/**
	 * Interface to MediaWiki logic -- need to use this more
	 * @var \Wikia\Search\MediaWikiInterface
	 */
	protected $interface;
	
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
	 * @param Solarium_Client $client
	 */
	public function __construct( Solarium_Client $client ) {
	    $this->client = $client;
	    $this->interface = MediaWikiInterface::getInstance();
	    parent::__construct();
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
	 * @see WikiaSearchIndexer::getPages()
	 * @see WikiaSearchController::getPage()
	 * @param int $pageId
	 * @throws WikiaException
	 * @return array result
	 */
	public function getPage( $pageId ) {
		wfProfileIn(__METHOD__);
		// these will eventually be broken out into their own atomic updates
		$cityId = !empty( $this->wg->CityId ) ? $this->wg->CityId : $this->wg->SearchWikiId;
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
			$this->services[$serviceName] = Factory::getInstance()->get( $serviceName ); 
		}
		return $this->services[$serviceName]; 
	}
	
	/**
	 * Generates a Solr document from a page ID
	 * @param  int $pageId
	 * @return Solarium_Document_ReadWrite 
	 */
	public function getSolrDocument( $pageId ) {
		$this->wg->AppStripsHtml = true;
		
		$pageData = $this->getPage( $pageId );
		
		foreach ( WikiaSearch::$languageFields as $field ) {
			if ( isset( $pageData[$field] ) ) {
				$pageData[WikiaSearch::field( $field, $pageData['lang'] )] = $pageData[$field];
			}
		}

		return F::build( 'Solarium_Document_ReadWrite', array( $pageData ) );
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
		} catch ( Exception $e ) {
			F::build( 'Wikia' )->Log( __METHOD__, '', $e);
		}
		return true;
	}
	
	/**
	 * Emits scribe events for each page to be reindexed by the search backend
	 * @param int $wid
	 */
	public function reindexWiki( $wid ) {
		try {
			$dataSource = F::build( 'WikiDataSource', array( $wid ) );
			$dbHandler = $dataSource->getDB();
			$rows = $dbHandler->query( "SELECT page_id FROM page" );
			while ( $page = $dbHandler->fetchObject( $rows ) ) {
				$sp = F::build( 'ScribeProducer', array( 'reindex', $page->page_id ) );
				$sp->reindexPage();
			}
		} catch ( Exception $e ) {
			F::build( 'Wikia' )->Log( __METHOD__, '', $e );
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
		$query = WikiaSearch::valueForField( 'wid', $wid );
		$updateHandler->addDeleteQuery( $query );
		$updateHandler->addCommit();
		try {
			return $this->client->update( $updateHandler );
		} catch ( Exception $e ) {
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
			$query = WikiaSearch::valueForField( 'wid', $wid );
			$updateHandler->addDeleteQuery( $query );
		}
		$updateHandler->addCommit();
		try {
			return $this->client->update( $updateHandler );
		} catch ( Exception $e ) {
			F::build( 'Wikia' )->Log( __METHOD__, 'Delete: '.$query, $e);
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
		    $updateHandler->addDeleteQuery( WikiaSearch::valueForField( 'id', $id ) );
	    }
		$updateHandler->addCommit();
	    try {
	        $this->client->update( $updateHandler );
	    } catch ( Exception $e ) {
	        F::build( 'Wikia' )->Log( __METHOD__, implode( ',', $documentIds ), $e);
		}

		return true;
	}
	
	/**
	 * Written to work as a hook
	 * @param int $pageId
	 */
	public function reindexPage( $pageId ) {
		F::build( 'Wikia' )->log( __METHOD__, '', $pageId );
		$document = $this->getSolrDocument( $pageId );
		$this->reindexBatch( array( $document ) );
		
		return true;
	}
	
	/**
	 * Written to work as a hook
	 * @param int $pageId
	 */
	public function deleteArticle( $pageId) {
		
		$cityId	= $this->wg->CityId ?: $this->wg->SearchWikiId;
		$id		= sprintf( '%s_%s', $cityId, $pageId );
		
		$this->deleteBatch( array( $id ) );
		
		return true;
	}

	/**
	 * MediaWiki Hooks
	 */
	
	/**
	 * Sends delete request to article if it gets deleted
	 * @param WikiPage $article
	 * @param User $user
	 * @param integer $reason
	 * @param integer $id
	 */
	public function onArticleDeleteComplete( &$article, User &$user, $reason, $id ) {
		try {
			return $this->deleteArticle( $id );
		} catch ( Exception $e ) {
		    F::build( 'Wikia' )->log( __METHOD__, '', $e );
		    return true;
		}
	}
	
	/**
	 * Reindexes the page
	 * @param WikiPage $article
	 * @param User $user
	 * @param string $text
	 * @param string $summary
	 * @param bool $minoredit
	 * @param bool $watchthis
	 * @param string $sectionanchor
	 * @param array $flags
	 * @param Revision $revision
	 * @param int $status
	 * @param int $baseRevId
	 */
	public function onArticleSaveComplete( &$article, &$user, $text, $summary,
	        $minoredit, $watchthis, $sectionanchor, &$flags, $revision, &$status, $baseRevId ) {
		try {
			return $this->reindexBatch( array( $article->getTitle()->getArticleID() ) );
		} catch ( Exception $e ) {
		    F::build( 'Wikia' )->log( __METHOD__, '', $e );
		    return true;
		}
	}
	
	/**
	 * Reindexes page on undelete
	 * @param Title $title
	 * @param int $create
	 */
	public function onArticleUndelete( $title, $create ) {
		try {
			return $this->reindexBatch( array( $title->getArticleID() ) );
		} catch ( Exception $e ) {
			F::build( 'Wikia' )->log( __METHOD__, '', $e );
			return true;
		}
	}
	
	/**
	 * Issues a reindex event or deletes all docs, depending on whether a wiki is being closed or reopened
	 * @see    WikiaSearchIndexerTest::testOnWikiFactoryPublicStatusChangeClosed
	 * @see    WikiaSearchIndexerTest::testOnWikiFactoryPublicStatusChangeOpened
	 * @todo   Rewrite this to use is_closed_wiki when we can utilize atomic updates
	 * @param  int    $city_public
	 * @param  int    $city_id
	 * @param  string $reason
	 * @return bool
	 */
	public function onWikiFactoryPublicStatusChange( &$city_public, &$city_id, $reason ) {
		
		if ( $city_public < 1 ) {
			$this->deleteWikiDocs( $city_id );
		} else {
			$this->reindexWiki( $city_id );
		}
		
		return true;
	}
}
