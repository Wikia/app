<?php
 
/**
 * Initialization file for parser function functionality in the Maps extension
 *
 * @file Maps_ParserFunctions.php
 * @ingroup Maps
 *
 * @author Jeroen De Dauw
 */

if( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

/**
 * A class that holds handlers for the mapping parser functions.
 * Spesific functions are located in @see MapsUtils
 * 
 * @author Jeroen De Dauw
 *
 */
final class MapsParserFunctions {
	
	/**
	 * Initialize the parser functions feature. This function handles the parser function hook,
	 * and will load the required classes.
	 * 
	 */
	public static function initialize() {
		global $egMapsIP, $IP, $wgAutoloadClasses, $egMapsAvailableFeatures, $egMapsServices;
		
		$wgAutoloadClasses['MapsParserGeocoder'] = $egMapsIP. '/ParserFunctions/Maps_ParserGeocoder.php';
		
		foreach($egMapsServices as $serviceName => $serviceData) {
			// Check if the service has parser function support
			$hasPFs = array_key_exists('pf', $serviceData);
			
			// If the service has no parser function support, skipt it and continue with the next one.
			if (!$hasPFs) continue;
			
			// Go through the parser functions supported by the mapping service, and load their classes.
			foreach($serviceData['pf'] as $parser_name => $parser_data) {
				$file = $parser_data['local'] ? $egMapsIP . '/' . $parser_data['file'] : $IP . '/extensions/' . $parser_data['file'];
				$wgAutoloadClasses[$parser_data['class']] = $file;
			}
		}				
	}
	


}