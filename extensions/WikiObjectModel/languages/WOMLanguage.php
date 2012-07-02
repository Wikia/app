<?php
/**
 * @author ning
 */

/**
 * Base class for all language classes.
 */
abstract class WOMLanguage {

	// the message arrays ...
	protected $wWOMTypeLabels;

	function geWOMTypeLabels() {
		return $this->wWOMTypeLabels;
	}

	/**
	 * Find the internal message id of wome localised message string
	 * for a datatype. If no type of the given name exists (maybe a
	 * custom of compound type) then FALSE is returned.
	 */
	function findWOMTypeMsgID( $label ) {
		return array_search( $label, $this->wWOMTypeLabels );
	}
}
