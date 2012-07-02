<?php

/**
 * Yahoo! Maps form input class.
 *
 * @file SM_GoogleMaps3FormInput.php
 * @ingroup SemanticMaps
 *
 * @licence GNU GPL v3
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class SMYahooMapsFormInput extends SMFormInput {

	/**
	 * @see SMFormInput::getResourceModules
	 *
	 * @since 1.0
	 *
	 * @return array of string
	 */
	protected function getResourceModules() {
		return array_merge( parent::getResourceModules(), array( 'ext.sm.fi.yahoomaps' ) );
	}

}