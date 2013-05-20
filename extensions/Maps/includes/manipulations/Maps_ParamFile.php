<?php

/**
 * Parameter manipulation ensuring the value is an file url.
 * 
 * @since 1.0
 * 
 * @file Maps_ParamFile.php
 * @ingroup Maps
 * @ingroup ParameterManipulations
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class MapsParamFile extends ItemParameterManipulation {

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
		$value = MapsMapper::getFileUrl( $value );
	}
	
}
