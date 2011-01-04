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
	 * Add a JavaScript file out of skins/common, or a given relative path.
	 * 
	 * This is a copy of the native function in OutputPage to work around a pre MW 1.16 bug.
	 * Should be used for adding external files, like the Google Maps API.
	 * 
	 * @param OutputPage $out
	 * @param string $file
	 */
	public static function addScriptFile( OutputPage $out, $file ) {
		global $wgStylePath, $wgStyleVersion;
		if( substr( $file, 0, 1 ) == '/' || preg_match( '#^[a-z]*://#i', $file ) ) {
			$path = $file;
		} else {
			$path =  "{$wgStylePath}/common/{$file}";
		}
		$out->addScript( Html::linkedScript( wfAppendQuery( $path, $wgStyleVersion ) ) );		
	}
	
	/**
	 * Adds a string of JavaScript as dependency for a mapping service
	 * after wrapping it in an onload hook and script tag. This is sort
	 * of a hack, but it takes care of the difference between artciles
	 * and special pages.
	 * 
	 * @since 0.7
	 * 
	 * @param iMappingService $service 
	 * @param string $script
	 */
	public static function addInlineScript( iMappingService $service, $script ) {
		static $addOnloadJs = false;
		
		if ( method_exists( 'OutputPage', 'addModules' ) && !$addOnloadJs ) {
			global $egMapsScriptPath, $egMapsStyleVersion;
			
			$service->addDependency(
				Html::linkedScript( "$egMapsScriptPath/includes/mapsonload.js?$egMapsStyleVersion" )
			);
			
			$addOnloadJs = true;
		} 		
		
		$service->addDependency( Html::inlineScript( 
			( method_exists( 'OutputPage', 'addModules' ) ? 'addMapsOnloadHook' : 'addOnloadHook' ) . "( function() { $script } );"
		) );
	}
	
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
		
		$params['geoservice'] = new Parameter(
			'geoservice', 
			Parameter::TYPE_STRING,
			$egMapsDefaultGeoService,
			array(),
			array(
				new CriterionInArray( $egMapsAvailableGeoServices ),
			),
			array( 'mappingservice' )
		);
		
		$params['zoom'] = new Parameter(
			'zoom', 
			Parameter::TYPE_INTEGER
		);
		
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
		
		return $params;
	}
	
	/**
	 * Resolves the url of images provided as wiki page; leaves others alone.
	 * 
	 * @since 0.7.1
	 * 
	 * @param string $image
	 * 
	 * @return string
	 */
	public static function getImageUrl( $image ) {
		$title = Title::newFromText( $image, NS_FILE );

		if ( !is_null( $title ) && $title->getNamespace() == NS_FILE && $title->exists() ) {
			$imagePage = new ImagePage( $title );
			$image = $imagePage->getDisplayedFile()->getURL();
		}		
		
		return $image;
	}
	
}