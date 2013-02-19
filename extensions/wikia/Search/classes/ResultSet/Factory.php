<?php
/**
 * Class definition for \Wikia\Search\ResultSet\Factory
 */
namespace Wikia\Search\ResultSet;

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
	 * Allows us to instantiate a service anywhere in the app by name only importing a single class
	 * @param string $terminalClassName
	 * @param array $pageIds
	 * @throws \Exception
	 * @return \Wikia\Search\IndexService\AbstractService
	 */
	public function get( Solarium_Result_Select $result, WikiaSearchConfig $searchConfig, $parent = null, $metaposition = null ) {
		if ( $parent === null && $searchConfig->getGroupResults ) {
			return new GroupingSet( $result, $searchConfig );
		} else if ( $parent !== null && $metaposition !== null ) {
			return new Grouping( $result, $searchConfig, $parent, $metaposition );
		}
		return new Base( $result, $searchConfig );
	}
}