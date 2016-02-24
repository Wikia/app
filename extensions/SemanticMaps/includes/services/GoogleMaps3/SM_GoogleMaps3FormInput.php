<?php

/**
 * Google Maps v3 form input class.
 *
 * @since 1.0
 * @file SM_GoogleMaps3FormInput.php
 * @ingroup SemanticMaps
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class SMGoogleMaps3FormInput extends SMFormInput {
	
	/**
	 * @see SMFormInput::getResourceModules
	 * 
	 * @since 1.0
	 * 
	 * @return array of string
	 */
	protected function getResourceModules() {
		return array_merge( parent::getResourceModules(), array( 'ext.sm.fi.googlemaps3' ) );
	}	
	
}
