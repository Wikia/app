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
 *
 */
class MatchGrouping extends Grouping {
	
	/**
	 * Uses DependencyContainer to pre-populate attributes, and then configures stuff.
	 * @param DependencyContainer $container
	 */
	protected function configure( DependencyContainer $container ) {
		$this->searchResultObject = $container->getResult();
		$this->searchConfig       = $container->getConfig();
		$this->interface          = $container->getInterface();
		$this->parent             = $container->getParent();
		$this->metaposition       = $container->getMetaposition();
		$this->results            = new \ArrayIterator( array( $container->getWikiMatch()->getResult() ) );
		
		$this->configureHeaders();
	}
	
}