<?php
/**
 * Class definition for \Wikia\Search\ResultSet\Factory
 */
namespace Wikia\Search\ResultSet;

use \Solarium_Result_Select, \Solarium_Result_Select_Empty, \Wikia\Search\Config;

/**
 * A factory for instantiating search result sets.
 * This lets us make something else responsible for determining which instance to select.
 *
 * @author relwell
 * @package Search
 * @subpackage ResultSet
 */
class Factory {
	/**
	 * Inspects a dependency container and selects the appropriate result set based on what is set.
	 *
	 * @param DependencyContainer $container
	 *
	 * @todo return type hinting for DependencyContainer to constructor when we have a better solution than
	 *     WikiaMockProxy for testing. (or a dependencycontainerfactory, yuck)
	 * @throws \Exception
	 * @return \Wikia\Search\ResultSet\AbstractResultSet
	 */
	public function get( $container ) {
		$searchConfig = $container->getConfig();
		if ( $searchConfig === null ) {
			throw new \Exception(
				'An instance of Wikia\Search\Config must be set in the dependency container at a minimum in order to instantiate a result set.'
			);
		}
		$result = $container->getResult();
		$terminal = 'Base';
		if ( $result === null || $result instanceof Solarium_Result_Select_Empty ) {
			$terminal = 'EmptySet';
		} else if ( $searchConfig->getQueryService() ===
			'\\Wikia\\Search\\QueryService\\Select\\Dismax\\CombinedMedia'
		) {
			$terminal = 'CombinedMediaResultSet';
		}

		return ( new \Wikia\Search\ProfiledClassFactory )->get(
			'Wikia\\Search\\ResultSet\\' . $terminal,
			[ $container ]
		);
	}
}
