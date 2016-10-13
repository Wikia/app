<?php

/**
 *
 * Class to validate Rectangles by parsing content and validating locations
 * @since 2.0
 *
 * @file RectangleValidator.php
 * @ingroup Validators
 *
 * @author Nischay Nahata
 */

class RectangleValidator implements GeoValidator {

    protected $metaDataSeparator;

    public function __construct( $metaDataSeparator ) {
        $this->metaDataSeparator = $metaDataSeparator;
    }

	/**
	 * @see GeoValidator::doValidation
	 */	
    public function doValidation( $value ) {

	    //fetch locations
	    $value = explode( $this->metaDataSeparator,$value );
	    $value = $value[0];

        $parts = explode(':', $value);
		if( count( $parts ) != 2 ) {
			return false;
		}
        foreach ($parts as $part) {
            $valid = MapsCoordinateParser::areCoordinates($part);

            if(!$valid){
                break;
            }
        }
        return $valid;
    }
}
