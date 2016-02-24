<?php

/**
 * Static class for hooks handled by the Semantic Maps extension.
 *
 * @since 0.7
 *
 * @file SemanticMaps.hooks.php
 * @ingroup SemanticMaps
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
final class SemanticMapsHooks {

	/**
	 * Adds a link to Admin Links page.
	 *
	 * @since 0.7
	 *
	 * @param ALTree $admin_links_tree
	 *
	 * @return boolean
	 */
	public static function addToAdminLinks( ALTree &$admin_links_tree ) {
	    $displaying_data_section = $admin_links_tree->getSection( wfMessage( 'smw_adminlinks_displayingdata' )->text() );

	    // Escape if SMW hasn't added links.
	    if ( is_null( $displaying_data_section ) ) {
			return true;
		}

	    $smw_docu_row = $displaying_data_section->getRow( 'smw' );

	    $sm_docu_label = wfMessage( 'adminlinks_documentation', 'Semantic Maps' )->text();
	    $smw_docu_row->addItem( AlItem::newFromExternalLink( 'http://mapping.referata.com/wiki/Semantic_Maps', $sm_docu_label ) );

	    return true;
	}

	/**
	 * Hook to add PHPUnit test cases.
	 * @see https://www.mediawiki.org/wiki/Manual:Hooks/UnitTestsList
	 *
	 * @since 2.0
	 *
	 * @param array $files
	 *
	 * @return boolean
	 */
	public static function registerUnitTests( array &$files ) {
		$testFiles = array(
			'printers/KMLPrinter',
			'printers/MapPrinter',
		);

		foreach ( $testFiles as $file ) {
			$files[] = __DIR__ . '/tests/phpunit/' . $file . 'Test.php';
		}

		return true;
	}

	/**
	 * Adds support for the geographical coordinates and shapes data type to Semantic MediaWiki.
	 *
	 * @since sm.polygons
	 *
	 * @return true
	 */
	public static function initGeoDataTypes() {
		SMWDataValueFactory::registerDatatype( '_geo', 'SMGeoCoordsValue', SMWDataItem::TYPE_GEO );
		SMWDataValueFactory::registerDatatype( '_gpo', 'SMGeoPolygonsValue', SMWDataItem::TYPE_BLOB );
		return true;
	}

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

}
