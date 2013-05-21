<?php
/**
 * Class definition for Infoboxes Service
 */
class InfoboxesService
{
	/**
	 * Service for accessing infobox data for a set of page IDs.
	 * @param array $expectedIds
	 * @return array
	 */
	public function getForPageIds( $expectedIds = [] ) {
		$service = new Wikia\Search\MediaWikiService;
		$mappedIds = [];
		// requested IDs may not be canonical -- we only store canonical page id in solr
		foreach ( $expectedIds as $id ) {
			$canonicalId = $service->getCanonicalPageIdFromPageId( $id );
			$mappedIds[$canonicalId] = array_merge( ( isset( $mappedIds[$canonicalId] ) ? $mappedIds[$canonicalId] : [] ),  [ $id ] );
		}
		$idQueries = [];
		$wid = $service->getWikiId();
		foreach ( array_keys( $mappedIds ) as $canonicalId ) {
			$idQueries[] = Wikia\Search\Utilities::valueForField( 'id', sprintf( '%s_%s', $wid, $canonicalId ) );
		}
		$config = new Wikia\Search\Config;
		$config->setDirectLuceneQuery( true )
		       ->setRequestedFields( [ 'pageid', 'infoboxes_txt'] )
		       ->setQuery( implode( ' OR ', $idQueries ) );
		$searchApiResponse = (new Wikia\Search\QueryService\Factory)->getFromConfig( $config )->searchAsApi( [ 'pageid', 'infoboxes_txt' ], true );
		
		$items = [];
		foreach ( $searchApiResponse['items'] as $item ) {
			$infoboxes = [];
			if ( isset( $item['infoboxes_txt'] ) ) {
				foreach ( $item['infoboxes_txt'] as $row ) {
					$cells = explode( ' | ', $row );
					$key = array_shift( $cells );
					$infoboxes[$key] = implode( ' | ', $cells );
				}
			}
			foreach ( $mappedIds[$item['pageid']] as $expectedId ) {
				$items[$expectedId] = $infoboxes;
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
}