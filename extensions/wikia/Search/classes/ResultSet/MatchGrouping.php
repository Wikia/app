<?php
/**
 * Class definition for Wikia\Search\ResultSet\MatchGrouping
 * @author relwell
 *
 */
namespace Wikia\Search\ResultSet;
/**
 * This class is used to create a "grouping" based on a wiki match.
 * @author relwell
 * @package Search
 * @subpackage ResultSet
 */
class MatchGrouping extends Grouping {
	
	/**
	 * Uses DependencyContainer to pre-populate attributes, and then configures stuff.
	 * Note that we're skipping adding headers or ingesting results from result groupings.
	 * @param DependencyContainer $container
	 */
	protected function configure( DependencyContainer $container ) {
		$this->searchResultObject = $container->getResult();
		$this->searchConfig       = $container->getConfig();
		$this->service          = $container->getService();
		$this->parent             = $container->getParent();
		$this->metaposition       = $container->getMetaposition();
		$result                   = $container->getWikiMatch()->getResult();
		$this->results            = new \ArrayIterator( array( $result ) );
		
		$this->addHeaders( $result->getFields() );
	}
}