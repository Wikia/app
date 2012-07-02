<?php

/**
 * Frequent Pattern Tag Cloud Plug-in
 * Invalid attribute exception, thrown by TagCloud
 * 
 * @author Tobias Beck, University of Heidelberg
 * @author Andreas Fay, University of Heidelberg
 * @version 1.0
 */

class InvalidAttributeException extends Exception {
	
	/**
	 * Constructor
	 *
	 * @param string $attribute Attribute name
	 * @return InvalidAttributeException 
	 */
	public function __construct($attribute) {
		parent::__construct(sprintf("Attribute '%s' not found", $attribute ? $attribute : "<empty>"));
	}
}
