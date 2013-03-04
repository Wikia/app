<?php
/**
 * Class definition for Wikia\Search\ResultSet\EmptySet
 */
namespace Wikia\Search\ResultSet;
use \WikiaSearchConfig, \ArrayIterator;
/**
 * Used to denote an empty result set.
 * We implement the ArrayIterator stuff here for inheritance's sake and to reduce clutter in other 
 * @author relwell
 */
class EmptySet extends AbstractResultSet
{
	/**
	 * Constructor class. Search Config is the bare minimum we need.
	 * @param DependencyContainer $container
	 */
	public function configure( DependencyContainer $container )
	{
		$this->searchConfig = $container->getConfig();
	}
		
	/**
	 * Returns originating offset of the search results
	 * @return int
	 */
	public function getResultsStart() {
		return 0;
	}
	
	/**
	 * Returns query time
	 * @return number
	 */
	public function getQueryTime() {
		return 0;
	}
}