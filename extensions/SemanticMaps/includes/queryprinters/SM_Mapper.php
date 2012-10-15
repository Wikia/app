<?php

/**
 * Default class to assign as handler for map result formats.
 * The reason SMMapPrinter is not used for this directly is that
 * this would not allow having a deriving class of SMMapPrinter 
 * for a particular mapping service.
 *
 * @file SM_Mapper.php
 * @ingroup SemanticMaps
 *
 * @licence GNU GPL v3
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
final class SMMapper {
	
	/**
	 * @var SMMapPrinter
	 */
	protected $queryPrinter;
	
	/**
	 * @since 1.0
	 * 
	 * @var boolean
	 */
	protected $isMapFormat;
	
	/**
	 * Constructor.
	 * 
	 * @param $format String
	 * @param $inline
	 */
	public function __construct( $format, $inline ) {
		global $egMapsDefaultServices;

		$this->isMapFormat = $format == 'map';
		
		// TODO: allow service parameter to override the default
		// Note: if this is allowed, then the getParameters should only return the base parameters.
		if ( $this->isMapFormat ) $format = $egMapsDefaultServices['qp'];
		
		// Get the instance of the service class.
		$service = MapsMappingServices::getValidServiceInstance( $format, 'qp' );
		
		// Get an instance of the class handling the current query printer and service.
		$QPClass = $service->getFeature( 'qp' );	
		$this->queryPrinter = new $QPClass( $format, $inline, $service );
	}
	
	/**
	 * Intercept calls to getName, so special behaviour for the map format can be implemented.
	 * 
	 * @since 1.0
	 * 
	 * @return string
	 */
	public function getName() {
		return $this->isMapFormat ? wfMsg( 'maps_map' ) : $this->queryPrinter->getName();
	}
	
	/**
	 * Explcitly define this method, so method_exists returns true in SMW.
	 * 
	 * @see SMWResultPrinter::getParameters
	 * 
	 * @since 1.0
	 */
	public function getParameters() {
		return $this->queryPrinter->getParameters();
	}
	
	/**
	 * Explcitly define this method, so method_exists returns true in SMW.
	 * 
	 * @see SMWResultPrinter::getParameters
	 * 
	 * @since 1.0
	 */
	public function getValidatorParameters() {
		return $this->queryPrinter->getValidatorParameters();
	}
	
	/**
	 * SMW thinks this class is a SMWResultPrinter, and calls methods that should
	 * be forewarded to $this->queryPrinter on it.
	 * 
	 * @since 1.0
	 * 
	 * @param string $name
	 * @param array $arguments
	 */
	public function __call( $name, array $arguments ) {
		return call_user_func_array( array( $this->queryPrinter, $name ), $arguments );
	}
	
}
