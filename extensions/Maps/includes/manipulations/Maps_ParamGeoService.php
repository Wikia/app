<?php

/**
 * Parameter manipulation ensuring the value is a geocoding service,
 * and taking care of both alias resolving and overrides handling.
 * 
 * @since 0.7.5
 * 
 * @file Maps_ParamGeoService.php
 * @ingroup Maps
 * @ingroup ParameterManipulations
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class MapsParamGeoService extends ItemParameterManipulation {
	
	/**
	 * @since 0.7.5
	 * 
	 * @var string or false
	 */
	protected $mappingServiceParam;
	
	/**
	 * Constructor.
	 * 
	 * @since 0.7.5
	 */
	public function __construct( $mappingServiceParam = false ) {
		parent::__construct();
		$this->mappingServiceParam = $mappingServiceParam;		
	}
	
	/**
	 * @see ItemParameterManipulation::doManipulation
	 * 
	 * @since 0.7.5
	 */	
	public function doManipulation( &$value, Parameter $parameter, array &$parameters ) {
		global $egMapsDefaultGeoService;
		static $validatedDefault = false;		

		if ( !MapsGeocoders::canGeocode() ) {
			throw new MWException( 'There are no geocoders registered, so no geocoding can happen.' );
		}
		
		// Get rid of any aliases.
		$value = $this->getMainIndentifier( $value );	
		
		// Override the defaulting.
		if ( $parameter->wasSetToDefault() 
			&& is_string( $this->mappingServiceParam )
			&& array_key_exists( $this->mappingServiceParam, $parameters ) ) {
			$value = self::resolveOverrides( $value, $parameters[$this->mappingServiceParam]->getValue() );
		}
		
		if ( $value === '' || !array_key_exists( $value, MapsGeocoders::$registeredGeocoders ) ) {
			if ( !$validatedDefault ) {
				if ( !array_key_exists( $egMapsDefaultGeoService, MapsGeocoders::$registeredGeocoders ) ) {
					$geoServices = array_keys( MapsGeocoders::$registeredGeocoders );
					$egMapsDefaultGeoService = array_shift( $geoServices );

					if ( is_null( $egMapsDefaultGeoService ) ) {
						throw new MWException( 'Tried to geocode while there are no geocoders available at ' . __METHOD__  );
					}
				}
			}
			
			if ( array_key_exists( $egMapsDefaultGeoService, MapsGeocoders::$registeredGeocoders ) ) {
				$value = $egMapsDefaultGeoService;
			}
			else {
				throw new MWException( 'Attempt to use the default geocoder while it does not exist.' );
			}
		}		
	}
	
	/**
	 * Replaces the geocoder identifier in case there is an override specified by
	 * one of the registered geocoders.
	 * 
	 * @since 0.7.5
	 * 
	 * @param string $geocoderIdentifier
	 * @param string $mappingService
	 * 
	 * @return string
	 */
	protected static function resolveOverrides( $geocoderIdentifier, $mappingService ) {
		static $overrides = false;

		if ( $overrides === false ) {
			$overrides = array();
			
			foreach ( MapsGeocoders::$registeredGeocoders as $key => $class ) {
				$overrides[$key] = call_user_func( array( $class, 'getOverrides' ) );
			}					
		}
		
		foreach ( $overrides as $geocoder => $services ) {
			if ( in_array( $mappingService, $services ) ) {
				return $geocoder;
			}
		}			
		
		return $geocoderIdentifier;
	}
	
	/**
	 * Gets the main geocoder identifier by resolving aliases.
	 * 
	 * @since 0.7.5
	 * 
	 * @param string $geocoderIdentifier
	 * 
	 * @return string
	 */
	protected function getMainIndentifier( $geocoderIdentifier ) {
		// TODO: implement actual function
		return $geocoderIdentifier;
	}	
	
	
}