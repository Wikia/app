<?php

/**
 * Parameter criterion stating that the value must be a set of coordinates or an address.
 * 
 * @since 0.7
 * 
 * @file CriterionIsLocation.php
 * @ingroup Maps
 * @ingroup Criteria
 * 
 * @author Jeroen De Dauw
 */
class CriterionIsLocation extends ItemParameterCriterion {
	
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
	 * @see ItemParameterCriterion::validate
	 */	
	protected function doValidation( $value, Parameter $parameter, array $parameters ) {
		//Empty string. e.g no coordinates given
		if(empty($value)){
			return true;
		}

		if ( $this->metaDataSeparator !== false ) {
			$parts = explode( $this->metaDataSeparator, $value );
			$value = $parts[0];
		}

		if ( MapsGeocoders::canGeocode() ) {
			$geoService = $parameter->hasDependency( 'geoservice' ) ? $parameters['geoservice']->getValue() : '';
			$mappingService = $parameter->hasDependency( 'mappingservice' ) ? $parameters['mappingservice']->getValue() : false;

			return MapsGeocoders::isLocation(
				$value,
				$geoService,
				$mappingService
			);
		} else {
			return MapsCoordinateParser::areCoordinates( $value );
		}
	}
	
	/**
	 * @see ItemParameterCriterion::getItemErrorMessage
	 */	
	protected function getItemErrorMessage( Parameter $parameter ) {
		return wfMsgExt( 'validation-error-invalid-location', 'parsemag', $parameter->getOriginalName() );
	}
	
	/**
	 * @see ItemParameterCriterion::getFullListErrorMessage
	 */	
	protected function getFullListErrorMessage( Parameter $parameter ) {
		return wfMsgExt( 'validation-error-invalid-locations', 'parsemag', $parameter->getOriginalName() );
	}	
	
}