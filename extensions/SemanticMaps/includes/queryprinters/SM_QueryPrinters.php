<?php

/**
 * Initialization file for query printer functionality in the Semantic Maps extension
 *
 * @file SM_QueryPrinters.php
 * @ingroup SemanticMaps
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

$wgHooks['MappingFeatureLoad'][] = 'SMQueryPrinters::initialize';

final class SMQueryPrinters {
	
	/**
	 * Initialization function for Maps query printer functionality.
	 */
	public static function initialize() {
		global $wgAutoloadClasses, $egMapsDefaultServices;
		
		$wgAutoloadClasses['SMQueryHandler']	= __DIR__ . '/SM_QueryHandler.php';
		$wgAutoloadClasses['SMMapPrinter'] 		= __DIR__ . '/SM_MapPrinter.php';
		$wgAutoloadClasses['SMKMLPrinter'] 		= __DIR__ . '/SM_KMLPrinter.php';
		
		self::initFormat( 'kml', 'SMKMLPrinter' );
		
		foreach ( MapsMappingServices::getServiceIdentifiers() as $serviceIdentifier ) {
			$service = MapsMappingServices::getServiceInstance( $serviceIdentifier );	
				
			// Check if the service has a query printer.
			$QPClass = $service->getFeature( 'qp' );
			
			// If the service has no QP, skipt it and continue with the next one.
			if ( $QPClass === false ) {
				continue;
			}

			// Initiate the format.
			$aliases = $service->getAliases();

			// Add the 'map' result format if there are mapping services that have QP's loaded.
			if ( $egMapsDefaultServices['qp'] == $serviceIdentifier ) {
				$aliases[] = 'map';
			}

			self::initFormat( $service->getName(), 'SMMapPrinter', $aliases );
		}

		return true;
	}
	
	/**
	 * Add the result format for a mapping service or alias.
	 *
	 * @param string $format
	 * @param string $formatClass
	 * @param array $aliases
	 */
	private static function initFormat( $format, $formatClass, array $aliases = array() ) {
		global $smwgResultAliases, $smwgResultFormats;

		// Add the QP to SMW.
		$smwgResultFormats[$format] = $formatClass;

		$smwgResultAliases[$format] = $aliases;
	}

}
