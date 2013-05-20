<?php

/**
 * Parameter manipulation ensuring that the map types list contains the map type.
 * 
 * @since 1.0.1
 * 
 * @file Maps_ParamGMap3Types.php
 * @ingroup Maps
 * @ingroup ParameterManipulations
 * @ingroup MapsGoogleMaps
 * 
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class MapsParamGMap3Types extends ListParameterManipulation {
	
	/**
	 * @see ParameterManipulation::manipulate
	 * 
	 * @since 1.0.1
	 */	
	public function manipulate( Parameter &$parameter, array &$parameters ) {
		if ( !in_array( $parameters['type']->getValue(), $parameter->getValue() ) ) {
			if ( $parameters['type']->wasSetToDefault() ) {
				if ( count( $parameter->getValue() ) > 0 ) {
					$types = $parameter->getValue();
					$parameters['type']->setValue( $types[0] );
				}
			}
			else {
				array_unshift( $parameter->getValue(), $parameters['type']->getValue() );
			}
		}
	}
	
}