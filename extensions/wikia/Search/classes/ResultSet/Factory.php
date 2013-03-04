<?php
/**
 * Class definition for \Wikia\Search\ResultSet\Factory
 */
namespace Wikia\Search\ResultSet;
use \Solarium_Result_Select, \Solarium_Result_Select_Empty, \WikiaSearchConfig;

/**
 * A singleton instance for instantiating search result sets.
 * Yes it's a singleton -- this is easier to test than a static factory method.
 * This lets us make something else reponsible for determining which instance to select.
 * @author relwell
 */
class Factory
{
	/**
	 * Singleton instance
	 * @var Factory 
	 */
	private static $instance;
	
	/**
	 * Return a singleton instance
	 * @return \Wikia\Search\ResultSet\Factory
	 */
	public static function getInstance() {
		if (! isset( self::$instance ) ) {
			self::$instance = new Factory();
		}
		return self::$instance;
	}
	
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
			throw new \Exception( 'An instance of WikiaSearchConfig must be set in the dependency container at a mininum in order to instantiate a result set.' );
		}
		
		$parent = $container->getParent();
		$metaposition = $container->getMetaposition();
		$result = $container->getResult();
		
		if ( $result === null || $result instanceof Solarium_Result_Select_Empty ) {
			return new EmptySet( $container );
		} else if ( $parent === null && $searchConfig->getGroupResults() ) {
			return new GroupingSet( $container );
		} else if ( $parent !== null && $metaposition !== null ) {
			return new Grouping( $container );
		}
		return new Base( $container );
	}
}