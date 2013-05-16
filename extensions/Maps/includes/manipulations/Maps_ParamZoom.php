<?php

/**
 * Parameter manipulation for zoom levels that overrides the default in case of multiple locations.
 * 
 * @since 0.7
 * 
 * @file Maps_ParamZoom.php
 * @ingroup Maps
 * @ingroup ParameterManipulations
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class MapsParamZoom extends ItemParameterManipulation {

	/**
	 * Constructor.
	 * 
	 * @since 0.7
	 */
	public function __construct() {
		parent::__construct();
	}
	
	/**
	 * @see ItemParameterManipulation::doManipulation
	 * 
	 * @since 0.7
	 */	
	public function doManipulation( &$value, Parameter $parameter, array &$parameters ) {
		// If there are multiple points and the value was not provided or incorrect (=defaulted),
		// set it to false, so the mapping service can figure out the optimal value.
		if ( $parameter->wasSetToDefault() && count( $parameters['coordinates']->getValue() ) > 1 ) {
			$value = false;
		}
	}
	
}
