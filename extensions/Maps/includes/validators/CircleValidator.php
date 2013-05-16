<?php

/**
 * Class to validate circles by parsing content and validating radius and centre
 * @since 2.0
 *
 * @file CircleValidator.php
 * @ingroup Validators
 *
 * @author Nischay Nahata
 */

class CircleValidator implements GeoValidator {

    protected $metaDataSeparator;

    public function __construct( $metaDataSeparator ) {
        $this->metaDataSeparator = $metaDataSeparator;
    }


    /**
     *
     * @param string $value
     *
     * @since 2.0
     *
     * @return boolean
     */
    public function doValidation( $value ) {
	    //fetch locations
		$value = explode($this->metaDataSeparator,$value);
		$value = $value[0];

		//strip away line parameters and check for valid locations
		$parts = explode(':', $value);
		if( count( $parts ) != 2 ) {
			return false;
		}
		return $parts[1] > 0 ? MapsCoordinateParser::areCoordinates( $parts[0] ) : false;
	}
}