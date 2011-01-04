<?php

/**
 * Parameter manipulation ensuring the value is a coordinate set.
 * 
 * @since 0.7
 * 
 * @file Maps_ParamCoordSet.php
 * @ingroup Maps
 * @ingroup ParameterManipulations
 * 
 * @author Jeroen De Dauw
 */
class MapsParamCoordSet extends ItemParameterManipulation {
	
	/**
	 * In some usecases, the parameter values will contain extra location
	 * metadata, which should be ignored here. This field holds the delimiter
	 * used to seperata this data from the actual location. 
	 * 
	 * @since 0.7
	 * 
	 * @var string
	 */
	protected $metaDataSeparator;	
	
	/**
	 * Constructor.
	 * 
	 * @since 0.7
	 */
	public function __construct( $metaDataSeparator = false ) {
		parent::__construct();
		
		$this->metaDataSeparator = $metaDataSeparator;		
	}
	
	/**
	 * @see ItemParameterManipulation::doManipulation
	 * 
	 * @since 0.7
	 */	
	public function doManipulation( &$value, Parameter $parameter, array &$parameters ) {
		if ( $this->metaDataSeparator !== false ) {
			$parts = explode( $this->metaDataSeparator, $value );
			$value = array_shift( $parts );
		}
		
		if ( MapsGeocoders::canGeocode() ) {
			$value = MapsGeocoders::attemptToGeocodeToString( $value/*, $geoService, $mappingService*/ );
		} else {
			$value = MapsCoordinateParser::parseAndFormat( $value );
		}
		
		if ( $this->metaDataSeparator !== false ) {
			$value = array_merge( array( $value ), $parts );
		}
	}
	
}