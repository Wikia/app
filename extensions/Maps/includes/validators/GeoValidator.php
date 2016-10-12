<?php


/**
 * Interface defining classes for Geographic shapes' validators
 * @since 2.0
 *
 * @author Nischay Nahata
 */

interface GeoValidator {

	/**
	 * Constructor.
	 * MetaDataSeparator is used to separate metadata from geographic data for the shape
	 * usually ~ is used by default as separator
	 *
	 * @since 2.0
	 */
	public function __construct( $metaDataSeparator );

	/**
	 * Returns a boolean indicating if the given string is a proper representation
	 * of the Geo Shape
	 *
	 * @since 2.0
	 */
	public function doValidation( $value );

}