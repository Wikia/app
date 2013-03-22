<?php
/**
 * Class definition for \Wikia\Search\ResultSet\Factory
 */
namespace Wikia\Search\ResultSet;
use \Solarium_Result_Select, \Solarium_Result_Select_Empty, \WikiaSearchConfig;
/**
 * A factory for instantiating search result sets.
 * This lets us make something else reponsible for determining which instance to select.
 * @author relwell
 * @package Search
 * @subpackage ResultSet
 */
class Factory
{
	/**
	 * Inspects a dependency container and selects the appropriate result set based on what is set.
	 * @param DependencyContainer $container
	 * @todo return type hinting for DependencyContainer to constructor when we have a better solution than WikiaMockProxy for testing. (or a dependencycontainerfactory, yuck)
	 * @throws \Exception
	 * @return \Wikia\Search\IndexService\AbstractService
	 */
	public function get( $container ) {
		$searchConfig = $container->getConfig();
		if ( $searchConfig === null ) {
			throw new \Exception( 'An instance of Wikia\Search\Config must be set in the dependency container at a mininum in order to instantiate a result set.' );
		}
		
		$parent = $container->getParent();
		$metaposition = $container->getMetaposition();
		$result = $container->getResult();
		$wikiMatch = $container->getWikiMatch();
		
		if ( $result === null || $result instanceof Solarium_Result_Select_Empty ) {
			return new EmptySet( $container );
		} else if ( $parent === null && $searchConfig->getGroupResults() ) {
			return new GroupingSet( $container );
		} else if ( $parent !== null && $metaposition !== null ) {
			$grouping = new Grouping( $container );
			if ( $grouping->getResultsNum() == 0 ) {
				// back-off for malformed groupings -- wiki match
				$subdomain = array_shift( explode( '.', $grouping->getId() ) );
				$container->setWikiMatch( $container->getService()->getWikiMatchByHost( $subdomain ) );
				$grouping = new MatchGrouping( $container );
			}
			return $grouping;
		} else if ( $parent !== null && $wikiMatch !== null ) {
			return new MatchGrouping( $container );
		}
		return new Base( $container );
	}
}