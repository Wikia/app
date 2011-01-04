<?php

/**
 * Parameter manipulation ensuring the value is an image url.
 * 
 * @since 0.7.1
 * 
 * @file Maps_ParamImage.php
 * @ingroup Maps
 * @ingroup ParameterManipulations
 * 
 * @author Jeroen De Dauw
 */
class MapsParamImage extends ItemParameterManipulation {

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
		$value = MapsMapper::getImageUrl( $value );
	}
	
}