<?php

/**
 * Interface for objects that have an equals method.
 *
 * @since 0.1
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
interface Comparable {

	/**
	 * Returns if the provided value is equal to the object or not.
	 *
	 * @since 0.1
	 *
	 * @param mixed $target
	 *
	 * @return boolean
	 */
	public function equals( $target );

}