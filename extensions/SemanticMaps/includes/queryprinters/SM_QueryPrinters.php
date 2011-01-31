<?php

/**
 * Initialization file for query printer functionality in the Semantic Maps extension
 *
 * @file SM_QueryPrinters.php
 * @ingroup SemanticMaps
 *
 * @author Jeroen De Dauw
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
		global $smgDir, $wgAutoloadClasses;
		
		$wgAutoloadClasses['SMQueryHandler']	= dirname( __FILE__ ) . '/SM_QueryHandler.php';
		$wgAutoloadClasses['SMMapper'] 			= dirname( __FILE__ ) . '/SM_Mapper.php';
		$wgAutoloadClasses['SMMapPrinter'] 		= dirname( __FILE__ ) . '/SM_MapPrinter.php';
		$wgAutoloadClasses['SMKMLPrinter'] 		= dirname( __FILE__ ) . '/SM_KMLPrinter.php';
		
		self::initFormat( 'kml', 'SMKMLPrinter' );
		
		$hasQueryPrinters = false;

		foreach ( MapsMappingServices::getServiceIdentifiers() as $serviceIdentifier ) {
			$service = MapsMappingServices::getServiceInstance( $serviceIdentifier );	
				
			// Check if the service has a query printer.
			$QPClass = $service->getFeature( 'qp' );
			
			// If the service has no QP, skipt it and continue with the next one.
			if ( $QPClass === false ) continue;
			
			// At least one query printer will be enabled when this point is reached.
			$hasQueryPrinters = true;
			
			// Initiate the format.
			$aliases = $service->getAliases();
			self::initFormat( $service->getName(), $QPClass, $aliases );
		}

		// Add the 'map' result format if there are mapping services that have QP's loaded.
		if ( $hasQueryPrinters ) {
			self::initFormat( 'map', 'SMMapper' );
		}
		
		return true;
	}
	
	/**
	 * Returns an array containing the parameter info.
	 * 
	 * @since 0.7
	 * 
	 * @return array
	 */
	public static function getParameterInfo() {
		global $egMapsDefaultServices, $egMapsAvailableGeoServices, $egMapsDefaultGeoService, $egMapsMapWidth, $egMapsMapHeight;
		global $egMapsDefaultLabel, $egMapsDefaultTitle;
		global $smgQPForceShow, $smgQPShowTitle, $smgQPTemplate;
		
		$params = MapsMapper::getCommonParameters();
		
		$params['staticlocations'] = new ListParameter( 'staticlocations', ';' );
		$params['staticlocations']->addAliases( 'locations' );
		$params['staticlocations']->addCriteria( new CriterionIsLocation( '~' ) );
		$params['staticlocations']->addManipulations( new MapsParamCoordSet( '~' ) );		
		$params['staticlocations']->setDefault( array() );
		
		$params['centre'] = new Parameter(
			'centre',
			Parameter::TYPE_STRING,
			'', // TODO
			array( 'center' ),
			array(
				new CriterionIsLocation(),
			)			
		);
		
		$params['icon'] = new Parameter(
			'icon',
			Parameter::TYPE_STRING,
			'', // TODO
			array(),
			array(
				New CriterionNotEmpty()
			)
		);	
		
		$params['forceshow'] = new Parameter(
			'forceshow',
			Parameter::TYPE_BOOLEAN,
			$smgQPForceShow,
			array( 'force show' )
		);
		$params['forceshow']->addManipulations( new ParamManipulationBoolean() );		

		$params['showtitle'] = new Parameter(
			'showtitle',
			Parameter::TYPE_BOOLEAN,
			$smgQPShowTitle,
			array( 'show title' )
		);
		$params['showtitle']->addManipulations( new ParamManipulationBoolean() );		
		
		$params['template'] = new Parameter(
			'template',
			Parameter::TYPE_STRING,
			$smgQPTemplate,
			array(),
			array(
				New CriterionNotEmpty()
			)
		);
		
		$params['title'] = new Parameter(
			'title',
			Parameter::TYPE_STRING,
			$egMapsDefaultTitle
		);
		
		$params['label'] = new Parameter(
			'label',
			Parameter::TYPE_STRING,
			$egMapsDefaultLabel,
			array( 'text' )
		);
		
		return $params;
	}
	
	/**
	 * Add the result format for a mapping service or alias.
	 *
	 * @param string $format
	 * @param string $formatClass
	 * @param array $aliases
	 */
	private static function initFormat( $format, $formatClass, array $aliases = array() ) {
		global $wgAutoloadClasses, $smgDir, $smwgResultAliases;

		// Add the QP to SMW.
		self::addFormatQP( $format, $formatClass );

		// If SMW supports aliasing, add the aliases to $smwgResultAliases.
		if ( isset( $smwgResultAliases ) ) {
			$smwgResultAliases[$format] = $aliases;
		}
		else { // If SMW does not support aliasing, add every alias as a format.
			foreach ( $aliases as $alias ) self::addFormatQP( $alias, $formatClass );
		}
	}

	/**
	 * Adds a QP to SMW's $smwgResultFormats array or SMWQueryProcessor
	 * depending on if SMW supports $smwgResultFormats.
	 * 
	 * @param string $format
	 * @param string $class
	 */
	private static function addFormatQP( $format, $class ) {
		global $smwgResultFormats;
		
		if ( isset( $smwgResultFormats ) ) {
			$smwgResultFormats[$format] = $class;
		}
		else {
			SMWQueryProcessor::$formats[$format] = $class;
		}
	}
	
}