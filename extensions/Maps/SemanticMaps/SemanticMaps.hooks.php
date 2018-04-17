<?php

use Maps\Semantic\DataValues\CoordinateValue;
use Maps\Semantic\DataValues\GeoPolygonValue;
use SMW\DataTypeRegistry;

/**
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
		$displaying_data_section = $admin_links_tree->getSection(
			wfMessage( 'smw_adminlinks_displayingdata' )->text()
		);

		// Escape if SMW hasn't added links.
		if ( is_null( $displaying_data_section ) ) {
			return true;
		}

		$smw_docu_row = $displaying_data_section->getRow( 'smw' );

		$sm_docu_label = wfMessage( 'adminlinks_documentation', 'Semantic Maps' )->text();
		$smw_docu_row->addItem(
			AlItem::newFromExternalLink( 'http://mapping.referata.com/wiki/Semantic_Maps', $sm_docu_label )
		);

		return true;
	}

	/**
	 * Adds support for the geographical coordinates and shapes data type to Semantic MediaWiki.
	 *
	 * @since 2.0
	 *
	 * @return boolean
	 */
	public static function initGeoDataTypes() {
		DataTypeRegistry::getInstance()->registerDatatype(
			'_geo',
			CoordinateValue::class,
			SMWDataItem::TYPE_GEO
		);

		DataTypeRegistry::getInstance()->registerDatatype(
			'_gpo',
			GeoPolygonValue::class,
			SMWDataItem::TYPE_BLOB
		);

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
	 * @param SMWPrintRequest[] $printRequests The print requests made
	 * @param array $params The parameters for the query printer
	 *
	 * @return boolean
	 */
	public static function addGeoCoordsDefaultFormat( &$format, array $printRequests, array $params ) {
		// Only set the format when not set yet. This allows other extensions to override the Semantic Maps behavior.
		if ( $format === false ) {
			// Only apply when there is more then one print request.
			// This way requests comming from #show are ignored.
			if ( count( $printRequests ) > 1 ) {
				$allValid = true;
				$hasCoords = false;

				// Loop through the print requests to determine their types.
				foreach ( $printRequests as $printRequest ) {
					// Skip the first request, as it's the object.
					if ( $printRequest->getMode() == SMWPrintRequest::PRINT_THIS ) {
						continue;
					}

					$typeId = $printRequest->getTypeID();

					if ( $typeId == '_geo' ) {
						$hasCoords = true;
					} else {
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
