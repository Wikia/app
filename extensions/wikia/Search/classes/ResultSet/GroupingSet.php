<?php
/**
 * Class definition for Wikia\Search\ResultSet\GroupingSet
 */
namespace Wikia\Search\ResultSet;
use \Wikia\Search\MediaWikiService, \ArrayIterator;
use \Solarium_Result_Select;
use \WikiaSearchConfig;
/**
 * This is a search result set that contains grouped results.
 * @author relwell
 * @package Search
 * @subpackage ResultSet
 */
class GroupingSet extends Grouping
{
	/**
	 * Helps us instantiate child groupings
	 * @var Factory
	 */
	protected $factory;
	
	/**
	 * Configures result set.
	 * @param DependencyContainer $container
	 */
	protected function configure( DependencyContainer $container ) {
		$this->searchResultObject = $container->getResult();
		$this->searchConfig       = $container->getConfig();
		$this->service          = $container->getService();
		$this->results            = new ArrayIterator( array() );
		$this->resultsFound       = $this->getHostGrouping()->getNumberOfGroups();
		$this->factory            = new Factory;
		$this->prependWikiMatchIfExists()
		     ->setResultGroupings();
	}
	
	/**
	 * We use this to iterate over groupings and created nested search result sets.
	 * @return GroupingSet provides fluent interface
	 */
	protected function setResultGroupings() {
		$fieldGroup = $this->getHostGrouping();
		$groups = $fieldGroup->getValueGroups();
		for ( $i = 0; $i < count( $groups ); $i++ ) {
			$dependencies = array(
					'result' => $this->searchResultObject, 
					'config' => $this->searchConfig, 
					'parent' => $this, 
					'metaposition' => $i
					);
			;
			try {
				$resultSet = $this->factory->get( new DependencyContainer( $dependencies ) );
				$this->results[$resultSet->getHeader( 'url' )] = $resultSet;
			} catch ( \Exception $e ) {}
		}
		return $this;
	}
	
	/**
	 * Prepends a wiki match if one is stored in the config.
	 * @return GroupingSet
	 */
	protected function prependWikiMatchIfExists() {
		if ( $this->searchConfig->hasWikiMatch() ) {
			if ( $this->searchConfig->getStart() == 0 ) {
				$dependencies = array(
						'result' => $this->searchResultObject, 
						'config' => $this->searchConfig, 
						'parent' => $this, 
						'wikiMatch' => $this->searchConfig->getWikiMatch(),
						);
				$resultSet = $this->factory->get( new DependencyContainer( $dependencies ) );
				$this->results[$resultSet->getHeader( 'url' )] = $resultSet;
			}
			$this->resultsFound += 1;
		}
		return $this;
	}
	
}