<?php
/**
 * Class definition for Wikia\Search\ResultSet\GroupingSet
 */
namespace Wikia\Search\ResultSet;
use \Wikia\Search\MediaWikiInterface, \ArrayIterator;
use \Solarium_Result_Select;
use \WikiaSearchConfig;
/**
 * This is a search result set that contains grouped results.
 * @author relwell
 */
class GroupingSet extends Grouping
{
	/**
	 * Configures result set.
	 * @param DependencyContainer $container
	 */
	protected function configure( DependencyContainer $container ) {
		$this->searchResultObject = $container->getResult();
		$this->searchConfig       = $container->getConfig();
		$this->interface          = $container->getInterface();
		$this->results            = new ArrayIterator( array() );
		$this->resultsFound = $this->getHostGrouping()->getMatches();
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
			$resultSet = Factory::getInstance()->get( new DependencyContainer( $dependencies ) );
			$this->results[$resultSet->getHeader( 'url' )] = $resultSet;
		}
		return $this;
	}
	
	/**
	 * Prepends a wiki match if one is stored in the config.
	 * @return GroupingSet
	 */
	protected function prependWikiMatchIfExists() {
		if ( $this->searchConfig->hasWikiMatch() && $this->searchConfig->getStart() == 0 ) {
			$dependencies = array(
					'result' => $this->searchResultObject, 
					'config' => $this->searchConfig, 
					'parent' => $this, 
					'wikiMatch' => $this->searchConfig->getWikiMatch(),
					);
			;
			$resultSet = Factory::getInstance()->get( new DependencyContainer( $dependencies ) );
			$this->results[$resultSet->getHeader( 'url' )] = $resultSet;
		}
		return $this;
	}
	
}