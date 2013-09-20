<?php

/**
 *
 * Class to validate locations by parsing content
 * @since 2.0
 *
 * @file LocationValidator.php
 * @ingroup Validators
 *
 * @author Jeroen
 * @author Nischay Nahata
 */
class LocationValidator implements GeoValidator {

	/**
	 * @var string
	 */
	protected $metaDataSeparator;

	/**
	 * Constructor.
	 */
	public function __construct( $metaDataSeparator = false ) {
		parent::__construct();

		$this->metaDataSeparator = $metaDataSeparator;
	}

	/**
	 * @see GeoValidator::doValidation
	 */
	protected function doValidation( $value ) {
		//Empty string. e.g no coordinates given
		if(empty($value)){
			return true;
		}

		if ( $this->metaDataSeparator !== false ) {
			$parts = explode( $this->metaDataSeparator, $value );
			$value = $parts[0];
		}
		return MapsCoordinateParser::areCoordinates( $value );
	}

}