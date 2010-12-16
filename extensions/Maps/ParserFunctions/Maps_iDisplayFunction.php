<?php

/**
 * File holding interface iDisplayFunction.
 * 
 * @file Maps_iDisplayFunction.php
 * @ingroup Maps
 * 
 * @author Jeroen De Dauw
 */

if( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

/**
 * Interface that should be implemented by all display_ parser functions.
 * 
 * @author Jeroen De Dauw
 */
interface iDisplayFunction {
	public function displayMap(&$parser, array $params);
}