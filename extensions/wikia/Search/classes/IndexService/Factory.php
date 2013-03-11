<?php
/**
 * Class definition for \Wikia\Search\IndexService\Factory
 * @author relwell
 */
namespace Wikia\Search\IndexService;
/**
 * A responsible for instantiating services.
 * This lets us make something else reponsible for dependency injection.
 * @author relwell
 */
class Factory
{
	/**
	 * Allows us to instantiate a service anywhere in the app by name only importing a single class
	 * @param string $terminalClassName
	 * @param array $pageIds
	 * @throws \Exception
	 * @return \Wikia\Search\IndexService\AbstractService
	 */
	public function get( $terminalClassName, array $pageIds = array() ) {
		$className = 'Wikia\\Search\\IndexService\\' . $terminalClassName;
		if ( class_exists( $className ) ) {
			return new $className( $pageIds );
		} else {
			throw new \Exception( "No class by name of {$className}" );
		}
	}
}