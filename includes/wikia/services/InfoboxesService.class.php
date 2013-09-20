<?php
/**
 * Class definition for Infoboxes Service -- this service is responsible for accessing infoboxes from Solr
 */
class InfoboxesService
{
	/**
	 * We store the requested page IDs in this variable
	 * @var array
	 */
	protected $expectedIds = [];
	
	/**
	 * Mapping of canonical ID to requested IDs
	 * @var array
	 */
	protected $mappedIds = [];
	
	/**
	 * Helper service for interacting with MediaWiki
	 * @var Wikia\Search\MediaWikiService
	 */
	protected $mwService;
	
	/**
	 * Service for accessing infobox data for a set of page IDs.
	 * @param array $expectedIds
	 * @return array
	 */
	public function getForPageIds( $expectedIds = [] ) {
		$this->setExpectedIds( $expectedIds );
		return $this->getItemsFromSearchResponse( $this->getSearchResponse() );
	}
	
	/**
	 * Stores the expected IDs as requested by getForPageIds
	 * @param array $expectedIds
	 * @return InfoboxesService
	 */
	protected function setExpectedIds( array $expectedIds ) {
		$this->mappedIds = []; // in case someone wants to reuse this instance 
		$this->expectedIds = $expectedIds;
		return $this;
	}
	
	/**
	 * Formulates ID queries for each page ID
	 * @return array
	 */
	protected function getIdQueries() {
		$idQueries = [];
		$wid = $this->getMwService()->getWikiId();
		foreach ( array_keys( $this->getMappedIds() ) as $canonicalId ) {
			$idQueries[] = Wikia\Search\Utilities::valueForField( 'id', sprintf( '%s_%s', $wid, $canonicalId ) );
		}
		return $idQueries;
	}
	
	/**
	 * Lazy-loaded mapping from canonical page ID to requested page IDs.
	 * @return array
	 */
	protected function getMappedIds() {
		if ( empty( $this->mappedIds ) ) {
			$service = $this->getMwService();
			$mappedIds = [];
			// requested IDs may not be canonical -- we only store canonical page id in solr
			foreach ( $this->expectedIds as $id ) {
				$canonicalId = $service->getCanonicalPageIdFromPageId( $id );
				$mappedIds[$canonicalId] = array_merge( ( isset( $mappedIds[$canonicalId] ) ? $mappedIds[$canonicalId] : [] ),  [ $id ] );
			}
			$this->mappedIds = $mappedIds;
		}
		return $this->mappedIds;
	}
	
	/**
	 * Transformed the Solr fields to the desired format and performs an integrity check 
	 * so that empty page IDs and duplicate page IDs get handled appropriately.
	 * @return array
	 */
	protected function getItemsFromSearchResponse( array $searchApiResponse ) {
		$items = [];
		$mappedIds = $this->getMappedIds();
		foreach ( $searchApiResponse['items'] as $item ) {
			$infoboxes = [];
			if ( isset( $item['infoboxes_txt'] ) ) {
				foreach ( $item['infoboxes_txt'] as $row ) {
					$cells = explode( ' | ', $row );
					$table = array_shift( $cells );
					$key = array_shift( $cells );
					if (! isset( $infoboxes[$table] ) ) {
						$infoboxes[$table] = [];
					}
					$infoboxes[$table][$key] = implode( ' | ', $cells );
				}
			}
			foreach ( $mappedIds[$item['pageid']] as $expectedId ) {
				$items[$expectedId] = array_values( $infoboxes ); // don't want infobox_1, infobox_2, etc.
			}
		}
		// integrity check
		foreach ( $mappedIds as $canonicalId => $nonCanonicalIds ) {
			foreach ( $nonCanonicalIds as $expectedId ) {
				if (! isset( $items[$expectedId] ) ) {
					$items[$expectedId] = [];
				}
			}
		}
		return $items;
	}
	
	/**
	 * Configures and invokes search methods, returning the API-style response array
	 * @return array
	 */
	protected function getSearchResponse() {
		$config = new Wikia\Search\Config;
		$config->setDirectLuceneQuery( true )
		       ->setRequestedFields( [ 'pageid', 'infoboxes_txt'] )
		       ->setQuery( implode( ' OR ', $this->getIdQueries() ) );
		return (new Wikia\Search\QueryService\Factory)->getFromConfig( $config )->searchAsApi( [ 'pageid', 'infoboxes_txt' ], true );
	}
	
	/**
	 * Lazy-loading DI
	 * @todo replace this with some kind of trait
	 * @return Wikkia\Search\MediaWikiService
	 */
	protected function getMwService() {
		if ( $this->mwService === null ) {
			$this->mwService = new Wikia\Search\MediaWikiService;
		}
		return $this->mwService;
	}
}