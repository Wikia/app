<?php

/**
 * A class that holds static helper functions for generic mapping-related functions.
 * 
 * @since 0.1
 * 
 * @file Maps_Mapper.php
 * @ingroup Maps
 * 
 * @author Jeroen De Dauw
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
	 * @return array
	 */
	public static function getCommonParameters() {
		global $egMapsAvailableServices, $egMapsAvailableGeoServices, $egMapsDefaultGeoService, $egMapsMapWidth, $egMapsMapHeight, $egMapsDefaultService;

		$params = array();
		
		$params['mappingservice'] = new Parameter( 'mappingservice' );
		$params['mappingservice']->addAliases( 'service' );
		$params['mappingservice']->setDefault( $egMapsDefaultService );
		$params['mappingservice']->addCriteria( new CriterionInArray( MapsMappingServices::getAllServiceValues() ) );		
		
		$params['geoservice'] = new Parameter( 'geoservice' );
		$params['geoservice']->setDefault( $egMapsDefaultGeoService );
		$params['geoservice']->addCriteria( new CriterionInArray( $egMapsAvailableGeoServices ) );
		$params['geoservice']->addDependencies( 'mappingservice' );
		$params['geoservice']->addManipulations( new MapsParamGeoService( 'mappingservice' ) );
		$params['geoservice']->setDescription( wfMsg( 'maps-par-geoservice' ) );
		
		$params['zoom'] = new Parameter(
			'zoom', 
			Parameter::TYPE_INTEGER
		);
		$params['zoom']->setDescription( wfMsg( 'maps-par-zoom' ) );
		
		$params['width'] = new Parameter(
			'width', 
			Parameter::TYPE_STRING,
			$egMapsMapWidth,
			array(),
			array(
				new CriterionMapDimension( 'width' ),
			)
		);
		$params['width']->addManipulations( new MapsParamDimension( 'width' ) );
		$params['width']->setDescription( wfMsg( 'maps-par-width' ) );

		$params['height'] = new Parameter(
			'height', 
			Parameter::TYPE_STRING,
			$egMapsMapHeight,
			array(),
			array(
				new CriterionMapDimension( 'height' ),
			)
		);
		$params['height']->addManipulations( new MapsParamDimension( 'height' ) );
		$params['height']->setDescription( wfMsg( 'maps-par-height' ) );
		
		return $params;
	}
	
	/**
	 * Resolves the url of images provided as wiki page; leaves others alone.
	 * 
	 * @since 1.0
	 * 
	 * @param string $file
	 * 
	 * @return string
	 */
	public static function getFileUrl( $file ) {
		$title = Title::newFromText( $file, NS_FILE );

		if ( !is_null( $title ) && $title->getNamespace() == NS_FILE && $title->exists() ) {
			$imagePage = new ImagePage( $title );
			$file = $imagePage->getDisplayedFile()->getURL();
		}		
		
		return $file;
	}
	
	/**
	 * Returns JS to init the vars to hold the map data when they are not there already.
	 * 
	 * @since 1.0
	 * 
	 * @param string $serviceName
	 */
	public static function getBaseMapJSON( $serviceName ) {
		static $baseInit = false;
		static $serviceInit = array();
		
		$json = '';
		
		if ( !$baseInit ) {
			$baseInit = true;
			global $egMapsScriptPath;
			$json .= 'var egMapsScriptPath =' . FormatJson::encode( $egMapsScriptPath ) . ';';
			$json .= 'var mwmaps={};';
		}
		
		if ( !in_array( $serviceName, $serviceInit ) ) {
			$serviceInit[] = $serviceName;
			$json .= "mwmaps.$serviceName={};";
		}
		
		return $json;
	}
	
}