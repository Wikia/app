<?php

/**
 * Class to Handle Polygons in SM.
 * This class is used to convert the string representation
 * of Polygons to concrete structures.
 * Also acts as a factory class for polygons
 *
 * @author Nischay Nahata
 */
class PolygonHandler {

	/**
	 * The string used to store this value as a string in SMW.
	 *
	 * @var string
	 */
	private $text;

	/**
	 * The string used to store this value as an object.
	 *
	 * @var object or null
	 */
	private $value = null;

	/**
	 * The array of error messages occurred in parsing.
	 *
	 * @var array
	 */
	private $errors = [];

	/**
	 * Array of classes used to validate different Geographic shapes.
	 *
	 * @var array
	 */
	private $validatorClasses = [
		'locations' => 'LocationValidator',
		'lines' => 'LineValidator',
		'polygons' => 'PolygonValidator',
		'circles' => 'CircleValidator',
		'rectangles' => 'RectangleValidator'
	];

	/**
	 * Array of classes of different Geographic shapes.
	 *
	 * @var array
	 */
	private $geoClasses = [
		'locations' => 'MapsLocation',
		'lines' => 'MapsLine',
		'polygons' => 'MapsPolygon',
		'circles' => 'MapsCircle',
		'rectangles' => 'MapsRectanlge'
	];

	/**
	 * NOTE: These need to be changed as Manipulations are deprecated.
	 * Array of classes for param handling of different Geographic shapes.
	 *
	 * @var array
	 */
	private $paramClasses = [
		'locations' => 'MapsParamLocation',
		'lines' => 'MapsParamLine',
		'polygons' => 'MapsParamPolygon',
		'circles' => 'MapsParamCircle',
		'rectangles' => 'MapsParamRectangle'
	];

	/**
	 * @param string $text
	 */
	public function __construct( $text ) {
		$this->text = $text;
	}

	public function getGeoType() {
		$parts = explode( '=', $this->text );
		return current( $parts );
	}

	public function getValidationErrors() {
		$this->validateText();
		return $this->errors;
	}

	private function validateText() {
		$parts = explode( '=', $this->text );
		if ( array_key_exists( $parts[0], $this->validatorClasses ) ) {
			$validatorClass = new $this->validatorClasses[$parts[0]]( '~' );
			if ( !$validatorClass->doValidation( $parts[1] ) ) {
				$this->errors[] = wfMessage( 'semanticmaps-shapes-improperformat', $this->text )->escaped();
			}
		} else {
			$this->errors[] = wfMessage( 'semanticmaps-shapes-missingshape', $parts[0] )->escaped();
		}
	}

	/**
	 * Gets an object of the model class the string represents.
	 *
	 * @since 2.1
	 */
	public function shapeFromText() {
		$parts = explode( '~', $this->text );
		$shape = explode( '=', array_shift( $parts ) );
		if ( array_key_exists( $shape[0], $this->geoClasses ) ) {
			$geoClass = new $this->geoClasses[$shape[0]]( explode( ':', $shape[1] ) );

			return $geoClass;
		} else {
			return false;
		}
	}
}
