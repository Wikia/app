<?php

/**
 * Implementation of datavalues that are geographic coordinates.
 * 
 * @since 1.0
 * 
 * @file SM_GeoCoordsHooks.php
 * @ingroup SemanticMaps
 * 
 * @licence GNU GPL v3
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
final class SMGeoCoordsHooks {

	/**
	 * Set the default format to 'map' when the requested properties are
	 * of type geographic coordinates.
	 * 
	 * TODO: have a setting to turn this off and have it off by default for #show
	 * 
	 * @since 1.0
	 * 
	 * @param $format Mixed: The format (string), or false when not set yet 
	 * @param $printRequests Array: The print requests made
	 * @param $params Array: The parameters for the query printer
	 * 
	 * @return true
	 */
	public static function addGeoCoordsDefaultFormat( &$format, array $printRequests, array $params ) {
		// Only set the format when not set yet. This allows other extensions to override the Semantic Maps behaviour. 
		if ( $format === false ) {
			// Only apply when there is more then one print request.
			// This way requests comming from #show are ignored. 
			if ( count( $printRequests ) > 1 ) {
				$allValid = true;
				$hasCoords = false;
				
				// Loop through the print requests to determine their types.
				foreach( $printRequests as /* SMWPrintRequest */ $printRequest ) {
					// Skip the first request, as it's the object.
					if ( $printRequest->getMode() == SMWPrintRequest::PRINT_THIS ) {
						continue;
					}
					
					$typeId = $printRequest->getTypeID();
					
					if ( $typeId == '_geo' ) {
						$hasCoords = true;
					}
					else {
						$allValid = false;
						break;
					}
				}
	
				// If they are all coordinates, set the result format to 'map'.
				if ( $allValid && $hasCoords ) {
					$format = 'map';
				}				
			}

		}
		
		return true;
	}
	
	/**
	 * Adds support for the geographical coordinate data type to Semantic MediaWiki.
	 * 
	 * @since 1.0
	 * 
	 * TODO: i18n keys still need to be moved
	 * 
	 * @return true
	 */
	public static function initGeoCoordsType() {
		SMWDataValueFactory::registerDatatype( '_geo', 'SMGeoCoordsValue', SMWDataItem::TYPE_GEO );
		return true;
	}
	
}
