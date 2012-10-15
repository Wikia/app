<?php

/**
 * Frequent Pattern Tag Cloud Plug-in
 * SQL Exception
 * 
 * @author Tobias Beck, University of Heidelberg
 * @author Andreas Fay, University of Heidelberg
 * @version 1.0
 */

class SQLException extends Exception {
	public function __construct() {
		parent::__construct(mysql_error());
	}
}
