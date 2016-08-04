<?php

/**
 * A class that holds static helper functions for generic mapping-related functions.
 * 
 * @since 0.1
 * 
 * @deprecated
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
final class MapsMapper {
	
	/**
	 * Encode a variable of unknown type to JavaScript.
	 * Arrays are converted to JS arrays, objects are converted to JS associative
	 * arrays (objects). So cast your PHP associative arrays to objects before
	 * passing them to here.
	 *
	 * This is a copy of
	 * @see Xml::encodeJsVar
	 * which fixes incorrect behaviour with floats.
	 *
	 * @since 0.7.1
	 *
	 * @param mixed $value
	 *
	 * @return string
	 */
	public static function encodeJsVar( $value ) {
		if ( is_bool( $value ) ) {
			$s = $value ? 'true' : 'false';
		} elseif ( is_null( $value ) ) {
			$s = 'null';
		} elseif ( is_int( $value ) || is_float( $value ) ) {
			$s = $value;
		} elseif ( is_array( $value ) && // Make sure it's not associative.
					array_keys($value) === range( 0, count($value) - 1 ) ||
					count($value) == 0
				) {
			$s = '[';
			foreach ( $value as $elt ) {
				if ( $s != '[' ) {
					$s .= ', ';
				}
				$s .= self::encodeJsVar( $elt );
			}
			$s .= ']';
		} elseif ( is_object( $value ) || is_array( $value ) ) {
			// Objects and associative arrays
			$s = '{';
			foreach ( (array)$value as $name => $elt ) {
				if ( $s != '{' ) {
					$s .= ', ';
				}
				$s .= '"' . Xml::escapeJsString( $name ) . '": ' .
					self::encodeJsVar( $elt );
			}
			$s .= '}';
		} else {
			$s = '"' . Xml::escapeJsString( $value ) . '"';
		}
		return $s;
	}

	/**
	 * This function returns the definitions for the parameters used by every map feature.
	 *
	 * @deprecated
	 *
	 * @return array
	 */
	public static function getCommonParameters() {
		global $egMapsAvailableGeoServices, $egMapsDefaultGeoService, $egMapsMapWidth, $egMapsMapHeight, $egMapsDefaultService;

		$params = array();

		$params['mappingservice'] = array(
			'type' => 'mappingservice',
			'aliases' => 'service',
			'default' => $egMapsDefaultService,
		);

		$params['geoservice'] = array(
			'default' => $egMapsDefaultGeoService,
			'values' => $egMapsAvailableGeoServices,
			'dependencies' => 'mappingservice',
			// TODO 'manipulations' => new MapsParamGeoService( 'mappingservice' ),
		);

		$params['width'] = array(
			'type' => 'dimension',
			'allowauto' => true,
			'units' => array( 'px', 'ex', 'em', '%', '' ),
			'default' => $egMapsMapWidth,
		);

		$params['height'] = array(
			'type' => 'dimension',
			'units' => array( 'px', 'ex', 'em', '' ),
			'default' => $egMapsMapHeight,
		);

		// TODO$manipulation = new MapsParamLocation();
		// TODO$manipulation->toJSONObj = true;

		$params['centre'] = array(
			'type' => 'mapslocation',
			'aliases' => array( 'center' ),
			'default' => false,
			'manipulatedefault' => false,
		);

		// Give grep a chance to find the usages:
		// maps-par-mappingservice, maps-par-geoservice, maps-par-width,
		// maps-par-height, maps-par-centre
		foreach ( $params as $name => &$data ) {
			$data['name'] = $name;
			$data['message'] = 'maps-par-' . $name;
		}

		return $params;
	}
	
	/**
	 * Resolves the url of images provided as wiki page; leaves others alone.
	 * 
	 * @since 1.0
	 * @deprecated
	 * 
	 * @param string $file
	 * 
	 * @return string
	 */
	public static function getFileUrl( $file ) {
		$title = Title::makeTitle( NS_FILE, $file );

		if( $title !==  null && $title->exists() ) {
			$imagePage = new ImagePage( $title );
			return $imagePage->getDisplayedFile()->getURL();
		}
		return '';
	}

	/**
	 * Returns JS to init the vars to hold the map data when they are not there already.
	 * 
	 * @since 1.0
	 * @deprecated
	 * 
	 * @param string $serviceName
	 *
	 * @return string
	 */
	public static function getBaseMapJSON( $serviceName ) {
		static $baseInit = false;
		static $serviceInit = array();

		$json = '';
		
		if ( !$baseInit ) {
			$baseInit = true;
			$json .= 'var mwmaps={};';
		}
		
		if ( !in_array( $serviceName, $serviceInit ) ) {
			$serviceInit[] = $serviceName;
			$json .= "mwmaps.$serviceName={};";
		}
		
		return $json;
	}
	
}
