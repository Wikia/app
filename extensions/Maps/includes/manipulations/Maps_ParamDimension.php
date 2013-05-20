<?php

/**
 * Parameter manipulation ensuring the value is width or height.
 *
 * @since 0.7
 *
 * @file Maps_ParamDimension.php
 * @ingroup Maps
 * @ingroup ParameterManipulations
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class MapsParamDimension extends ItemParameterManipulation {

	/**
	 * String indicating if this is for a width or a height.
	 *
	 * @since 0.7
	 *
	 * @var string
	 */
	protected $dimension;

	/**
	 * Constructor.
	 *
	 * @param string $dimension
	 *
	 * @since 0.7
	 */
	public function __construct( $dimension ) {
		parent::__construct();

		$this->dimension = $dimension;
	}

	/**
	 * @see ItemParameterManipulation::doManipulation
	 *
	 * @since 0.7
	 */
	public function doManipulation( &$value, Parameter $parameter, array &$parameters ) {
		global $egMapsSizeRestrictions, $egMapsMapWidth, $egMapsMapHeight;

		if ( $value == 'auto' && $this->dimension == 'width' ) {
			return;
		}

		// Set the default if the value is not valid.
		if ( !preg_match( '/^\d+(\.\d+)?(px|ex|em|%)?$/', $value ) ) {
			$value = $this->dimension == 'width' ? $egMapsMapWidth : $egMapsMapHeight;
		}

		// Determine the minimum and maximum values.
		if ( preg_match( '/^.*%$/', $value ) ) {
			if ( count( $egMapsSizeRestrictions[$this->dimension] ) >= 4 ) {
				$min = $egMapsSizeRestrictions[$this->dimension][2];
				$max = $egMapsSizeRestrictions[$this->dimension][3];
			} else {
				// This is for backward compatibility with people who have set a custom min and max before 0.6.
				// Can be removed from version 0.8.
				$min = 1;
				$max = 100;
			}
		} else {
			$min = $egMapsSizeRestrictions[$this->dimension][0];
			$max = $egMapsSizeRestrictions[$this->dimension][1];
		}

		// See if the actual value is withing the limits.
		$number = preg_replace( '/[^0-9]/', '', $value );
		if ( $number < $min ) {
			$value = $min;
		} elseif ( $number > $max ) {
			$value = $max;
		}

		if ( !preg_match( '/(px|ex|em|%)$/', $value ) ) {
			$value .= 'px';
		}
	}

}
