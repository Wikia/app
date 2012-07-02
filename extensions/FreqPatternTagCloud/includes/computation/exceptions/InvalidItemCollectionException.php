<?php

/**
 * Frequent Pattern Tag Cloud Plug-in
 * Invalid item collection
 * 
 * @author Tobias Beck, University of Heidelberg
 * @author Andreas Fay, University of Heidelberg
 * @version 1.0
 */

class InvalidItemCollectionException extends Exception {
	
	/**
	 * Constructor
	 *
	 * @return InvalidItemCollectionException 
	 */
	public function __construct() {
		parent::__construct("Item collection must not be empty.");
	}
}
