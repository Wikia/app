<?php

/**
 * Initialization file for query printer functionality in the Semantic Maps extension
 *
 * @file SM_QueryPrinters.php
 * @ingroup SemanticMaps
 *
 * @author Jeroen De Dauw
 */

if( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

final class SMQueryPrinters {
	
	public static $parameters = array();
	
	/**
	 * Initialization function for Maps query printer functionality.
	 */
	public static function initialize() {
		global $smgDir, $wgAutoloadClasses, $egMapsServices;
		$wgAutoloadClasses['SMMapPrinter'] 	= $smgDir . 'QueryPrinters/SM_MapPrinter.php';
		
		self::initializeParams();
		
		$hasQueryPrinters = false;
		
		foreach($egMapsServices as $serviceName => $serviceData) {
			// Check if the service has a query printer
			$hasQP = array_key_exists('qp', $serviceData);
			
			// If the service has no QP, skipt it and continue with the next one.
			if (!$hasQP) continue;
			
			// At least one query printer will be enabled when this point is reached.
			$hasQueryPrinters = true;				
			
			// Initiate the format.
			self::initFormat($serviceName, $serviceData['qp'], $serviceData['aliases']);
		}	

		// Add the 'map' result format if there are mapping services that have QP's loaded.
		if ($hasQueryPrinters) self::initFormat('map', array('class' => 'SMMapper', 'file' => 'QueryPrinters/SM_Mapper.php', 'local' => true), array());
	}
	
	private static function initializeParams() {
		global $egMapsDefaultServices, $egMapsDefaultCentre, $egMapsAvailableGeoServices, $egMapsDefaultGeoService;
		global $smgQPForceShow, $smgQPShowTitle, $smgQPTemplate;

		self::$parameters = array(
			'geoservice' => array(
				'criteria' => array(
					'in_array' => array_keys($egMapsAvailableGeoServices)
					),
				'default' => $egMapsDefaultGeoService
				),
			'format' => array(
				'required' => true,
				'default' => $egMapsDefaultServices['qp']
				),	
			'centre' => array(
				'aliases' => array('center'),
				'default' => $egMapsDefaultCentre		
				),
			'forceshow' => array(
				'type' => 'boolean',
				'aliases' => array('force show'),
				'default' => $smgQPForceShow,
				'output-type' => 'boolean'
				),
			'template' => array(
				'criteria' => array(
					'not_empty' => array()
					),
				'default' => $smgQPTemplate,					
				),
			'showtitle' => array(
				'type' => 'boolean',
				'aliases' => array('show title'),
				'default' => $smgQPShowTitle,
				'output-type' => 'boolean'				
				),
			'icon' => array(
				'criteria' => array(
					'not_empty' => array()
					)					
				),						
			// SMW #Ask: parameters
			'limit' => array(
				'type' => 'integer',
				'criteria' => array(
					'in_range' => array(0)
					)				
				),
			'offset' => array(
				'type' => 'integer'
				),
			'sort' => array(),
			'order' => array(
				'criteria' => array(
					'in_array' => array('ascending', 'asc', 'descending', 'desc', 'reverse')
					)
				),
			'headers' => array(
				'criteria' => array(
					'in_array' => array('show', 'hide')
					)
				),
			'mainlabel' => array(),
			'link' => array(
				'criteria' => array(
					'in_array' => array('none', 'subject', 'all')
					)
				),
			'default' => array(),
			'intro' => array(),
			'outro' => array(),
			'searchlabel' => array(),
			'distance' => array(),
			);		
	}	
	
	/**
	 * Add the result format for a mapping service or alias.
	 *
	 * @param string $format
	 * @param array $qp
	 * @param array $aliases
	 */
	private static function initFormat($format, array $qp, array $aliases) {
		global $wgAutoloadClasses, $smgDir, $smwgResultAliases;

		// Load the QP class when it's not loaded yet.
		if (! array_key_exists($qp['class'], $wgAutoloadClasses)) {
			$file = array_key_exists('local', $qp) && $qp['local'] ? $smgDir . $qp['file'] : $qp['file'];
			$wgAutoloadClasses[$qp['class']] = $file;
		}

		// Add the QP to SMW.
		self::addFormatQP($format, $qp['class']);

		// If SMW supports aliasing, add the aliases to $smwgResultAliases.
		if (isset($smwgResultAliases)) {
			$smwgResultAliases[$format] = $aliases;
		}
		else { // If SMW does not support aliasing, add every alias as a format.
			foreach($aliases as $alias) self::addFormatQP($alias, $qp['class']);
		}
	}

	/**
	 * Adds a QP to SMW's $smwgResultFormats array or SMWQueryProcessor
	 * depending on if SMW supports $smwgResultFormats.
	 * 
	 * @param string $format
	 * @param string $class
	 */
	private static function addFormatQP($format, $class) {
		global $smwgResultFormats;
		
		if (isset($smwgResultFormats)) {
			$smwgResultFormats[$format] = $class;
		}
		else {
			SMWQueryProcessor::$formats[$format] = $class;
		}			
	}
	
	
}