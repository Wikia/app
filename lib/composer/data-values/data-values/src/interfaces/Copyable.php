<?php

/**
 * Interface for objects that have a getCopy method.
 *
 * @since 0.1
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
interface Copyable {

	/**
	 * Returns a deep copy of the object.
	 *
	 * @since 0.1
	 *
	 * @return Copyable
	 */
	public function getCopy();

}
