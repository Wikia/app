<?php

/**
 * Parameter criterion stating that the value must be an OpenLayers layer.
 * 
 * @since 0.7.1
 * 
 * @file CriterionOLLayer.php
 * @ingroup Maps
 * @ingroup Criteria
 * @ingroup MapsOpenLayers
 * 
 * @author Jeroen De Dauw
 */
class CriterionOLLayer extends CriterionMapLayer {
	
	
	/**
	 * Constructor.
	 * 
	 * @since 0.7
	 */
	public function __construct() {
		parent::__construct( 'openlayers' );
	}	
	
	/**
	 * @see ItemParameterCriterion::validate
	 */	
	protected function doValidation( $value, Parameter $parameter, array $parameters ) {
		// Dynamic layers, defined in the settings file or localsettings.
		if ( in_array( strtolower( $value ), MapsOpenLayers::getLayerNames( true ) ) ) {
			return true;
		}

		return parent::doValidation( $value, $parameter, $parameters );
	}	
	
}
