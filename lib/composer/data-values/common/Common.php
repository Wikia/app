<?php

/**
 * Entry point of the DataValues Common library.
 *
 * @since 0.1
 * @codeCoverageIgnore
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */

if ( defined( 'DATAVALUES_COMMON_VERSION' ) ) {
	// Do not initialize more than once.
	return 1;
}

define( 'DATAVALUES_COMMON_VERSION', '0.3.1' );

if ( defined( 'MEDIAWIKI' ) ) {
	$GLOBALS['wgExtensionCredits']['datavalues'][] = array(
		'path' => __DIR__,
		'name' => 'DataValues Common',
		'version' => DATAVALUES_COMMON_VERSION,
		'author' => array(
			'[https://www.mediawiki.org/wiki/User:Jeroen_De_Dauw Jeroen De Dauw]'
		),
		'url' => 'https://github.com/DataValues/Common',
		'description' => 'Contains common implementations of the interfaces defined by DataValuesInterfaces',
		'license-name' => 'GPL-2.0+'
	);
}
