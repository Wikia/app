<?php

/**
 * File holding the registration and handling functions for the display_uk_point parser function.
 *
 * @file UKG_DisplayUkPoint.php
 * @ingroup UKGeocodingForMaps
 *
 * @author Jeroen De Dauw
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

$wgAutoloadClasses['UKGDisplayUkPoint'] 	= $ukggDir . 'ParserFunctions/DisplayUkPoint/UKG_DisplayUkPoint.php';
$wgAutoloadClasses['UKGBaseUkPointMap'] 	= $ukggDir . 'ParserFunctions/DisplayUkPoint/UKG_BaseUkPointMap.php';

$wgHooks['ParserFirstCallInit'][] 			= 'efUKGRegisterDisplayPoint';

$egMapsFeatures['pf'][]	= 'UKGDisplayUkPoint::initialize';

/**
 * Adds the parser function hooks
 */
function efUKGRegisterDisplayPoint( &$wgParser ) {
	// Hooks to enable the '#display_uk_point' and '#display_uk_points' parser functions.
	$wgParser->setFunctionHook( 'display_uk_point', array( 'UKGDisplayUkPoint', 'displayUkPointRender' ) );
	return true;
}

/**
 * Class containing the rendering functions for the display_uk_point parser function.
 *
 * @ingroup UKGeocodingForMaps
 *
 * @author Jeroen De Dauw
 */
final class UKGDisplayUkPoint {

	public static $parameters = array();

	public static function initialize() {
		self::initializeParams();
	}

	/**
	 * Returns the output for a display_uk_point call.
	 * A lot of this code has been copied from @see MapsParserFunctions::getMapHtml in Maps.
	 *
	 * @param unknown_type $parser
	 *
	 * @return array
	 */
	public static function displayUkPointRender( &$parser ) {
		global $wgLang, $egValidatorErrorLevel;

		$params = func_get_args();

        array_shift( $params ); // We already know the $parser.

        $map = array();
        $coordFails = array();

        $paramInfo = array_merge( MapsMapper::getMainParams(), self::$parameters );

		// Go through all parameters, split their names and values, and put them in the $map array.
        foreach ( $params as $param ) {
			$split = explode( '=', $param );
			if ( count( $split ) > 1 ) {
                $paramName = strtolower( trim( $split[0] ) );
                $paramValue = trim( $split[1] );
                if ( strlen( $paramName ) > 0 && strlen( $paramValue ) > 0 ) {
                	$map[$paramName] = $paramValue;
                	if ( MapsParserFunctions::inParamAliases( $paramName, 'coordinates', $paramInfo ) ) {
                		$coordFails = MapsParserFunctions::filterInvalidCoords( $map[$paramName] );
                	}
                }
            }
            elseif ( count( $split ) == 1 ) { // Default parameter (without name)
            	$split[0] = trim( $split[0] );
                if ( strlen( $split[0] ) > 0 ) $map['coordinates'] = $split[0];
            }
        }

		if ( ! MapsParserFunctions::paramIsPresent( 'service', $map, $paramInfo ) ) $map['service'] = '';

		$map['service'] = MapsMapper::getValidService( $map['service'], 'display_uk_point' );

		$mapClass = MapsParserFunctions::getParserClassInstance( $map['service'], 'display_uk_point' );

		// Call the function according to the map service to get the HTML output
		$output = $mapClass->displayMap( $parser, $map );

		if ( $egValidatorErrorLevel >= Validator_ERRORS_WARN && count( $coordFails ) > 0 ) {
			$output .= '<i>' . wfMsgExt( 'maps_unrecognized_coords_for', array( 'parsemag' ), $wgLang->listToText( $coordFails ), count( $coordFails ) ) . '</i>';
		}

        // Return the result
        return $parser->insertStripItem( $output, $parser->mStripState );
	}

	private static function initializeParams() {
		global $egMapsDefaultCentre, $egMapsDefaultTitle, $egMapsDefaultLabel, $egMapsAvailableServices, $egMapsDefaultServices;

		self::$parameters = array(
			'service' => array(
				'criteria' => array(
					'in_array' => $egMapsAvailableServices
				),
				'default' => $egMapsDefaultServices['display_uk_point']
			),
			'coordinates' => array(
				'aliases' => array( 'coords', 'location', 'locations' ),
			),
			'title' => array(
				'default' => $egMapsDefaultTitle
			),
			'label' => array(
				'default' => $egMapsDefaultLabel
			),
			'icon' => array(
				'criteria' => array(
					'not_empty' => array()
				),
			),
		);
	}
}