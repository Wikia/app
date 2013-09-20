<?php
/**
 * Class definition for Wikia\Search\IndexService\BacklinkText
 */
namespace Wikia\Search\IndexService;
use Wikia\Search\Config, \Wikia\Search\QueryService\Factory;
/**
 * This class populates a document's backlinks 
 * based on outgoing links pointing to that
 * document ID in other Solr documents.
 * @author relwell
 */
class BacklinkText extends AbstractService
{
	
	/**
	 * Accesses backlinks. Iterate over a result set of documents with outbound links, and store.
	 * (non-PHPdoc)
	 * @see \Wikia\Search\IndexService\AbstractService::execute()
	 */
	public function execute() {
		$docIdSeparated = $this->getCurrentDocumentId() . ' |';
		$config = new Config;
		$config->setDirectLuceneQuery( true )
		       ->setQuery( sprintf( 'outbound_links_txt:"%s"', $docIdSeparated ) );
		$factory = new Factory;
		
		$backlinks = [];
		do {
			$offset = 0;
			$limit = 100;
			$config->setStart( $offset )
			       ->setLimit( $limit );
			$resultSet = $factory->getFromConfig( $config )->search();
			foreach ( $resultSet as $result ) {
				foreach ( $result['outbound_links_txt'] as $link ) {
					if ( substr( $link, 0, strlen( $docIdSeparated ) ) == $docIdSeparated ) {
						$backlinks[] = implode( ' | ', array_slice( explode( ' | ', $link ), 1 ) );
					}
				}
			}
			$offset = $limit;
			$limit = $offset + 100;
		} while ( $config->getResultsFound() > $limit );
		return [ 'backlinks_txt' => $backlinks ];
	}
	
}