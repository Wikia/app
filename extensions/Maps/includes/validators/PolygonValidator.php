<?php

/**
 *
 * Class to validate polygons by parsing content and validating points
 * @since 2.0
 *
 * @file PolygonValidator.php
 * @ingroup Validators
 *
 * @author Kim Eik
 * @author Nischay Nahata
 */

class PolygonValidator implements GeoValidator {

    protected $metaDataSeparator;

    public function __construct( $metaDataSeparator ) {
        $this->metaDataSeparator = $metaDataSeparator;
    }

	/**
	 * @see GeoValidator::doValidation
	 */
    public function doValidation( $value ) {

	    //fetch locations
	    $value = explode($this->metaDataSeparator,$value);
	    $value = $value[0];

        //need atleast two points to create a polygon
        $valid = strpos($value, ':') != false;
        if (!$valid) {
            return $valid;
        }

        //strip away polygon parameters and check for valid locations
        $parts = explode(':', $value);
        foreach ($parts as $part) {
            $toIndex = strpos($part, $this->metaDataSeparator);
            if ($toIndex != false) {
                $part = substr($part, 0, $toIndex);
            }
            $valid = MapsCoordinateParser::areCoordinates($part);

            if(!$valid){
                break;
            }
        }

        return $valid;
    }
}