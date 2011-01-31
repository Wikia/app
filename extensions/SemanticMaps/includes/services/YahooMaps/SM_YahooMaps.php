<?php

/**
 * This groupe contains all Yahoo! Maps related files of the Semantic Maps extension.
 * 
 * @defgroup SMYahooMaps Yahoo! Maps
 * @ingroup SemanticMaps
 */

/**
 * This file holds the general information for the Yahoo! Maps service.
 *
 * @file SM_YahooMaps.php
 * @ingroup SMYahooMaps
 *
 * @author Jeroen De Dauw
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

$wgHooks['MappingServiceLoad'][] = 'smfInitYahooMaps';

function smfInitYahooMaps() {
	global $wgAutoloadClasses;
	
	$wgAutoloadClasses['SMYahooMapsQP'] = dirname( __FILE__ ) . '/SM_YahooMapsQP.php';
	
	// TODO: the if should not be needed, but when omitted, a fatal error occurs cause the class that's extended by this one is not found.
	if ( defined( 'SF_VERSION' ) ) $wgAutoloadClasses['SMYahooMapsFormInput'] = dirname( __FILE__ ) . '/SM_YahooMapsFormInput.php';	
	
	MapsMappingServices::registerServiceFeature( 'yahoomaps', 'qp', 'SMYahooMapsQP' );
	MapsMappingServices::registerServiceFeature( 'yahoomaps', 'fi', 'SMYahooMapsFormInput' );		
	
	return true;
}