<?php

/**
 * Entry point for the DataValues library.
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */

if ( defined( 'DataValues_VERSION' ) ) {
	// Do not initialize more than once.
	return 1;
}

define( 'DATAVALUES_VERSION', '1.0' );

/**
 * @deprecated
 */
define( 'DataValues_VERSION', DATAVALUES_VERSION );

if ( defined( 'MEDIAWIKI' ) ) {
	include __DIR__ . '/DataValues.mw.php';
}
