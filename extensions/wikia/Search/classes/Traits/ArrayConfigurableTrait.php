<?php
/**
 * Class definition for Wikia\Search\Traits\ArrayConfigurableTrait
 */
namespace Wikia\Search\Traits;
/**
 * This trait allows us to generalize setting properties based on the values of associated array keys.
 *
 * @author relwell
 * @package Search
 * @subpackage Traits
 */
trait ArrayConfigurableTrait {
	/**
	 * Convenience method for setting dependencies by array.
	 *
	 * @param array $dependencies
	 *
	 * @return ArrayConfigurableTrait
	 */
	protected function configureByArray( array $dependencies ) {
		foreach ( $dependencies as $name => $value ) {
			$method = 'set' . ucfirst( $name );
			if ( \method_exists( $this, $method ) ) {
				$this->{$method}( $value );
			}
		}

		return $this;
	}
}
