<?php

/**
 * HTMLForm date field input.
 * Requires jquery.datepicker
 *
 * @since 0.1
 *
 * @file EPHTMLDateField.php
 * @ingroup EducationProgram
 *
 * @licence GNU GPL v3 or later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class EPHTMLDateField extends HTMLTextField {

	public function __construct( $params ) {
		parent::__construct( $params );

		$this->mClass .= " ep-datepicker-tr";
	}

	function getSize() {
		return isset( $this->mParams['size'] )
			? $this->mParams['size']
			: 20;
	}

	function getInputHTML( $value ) {
		$value = explode( 'T',  wfTimestamp( TS_ISO_8601, strtotime( $value ) ) );
		return parent::getInputHTML( $value[0] );
	}

	function validate( $value, $alldata ) {
		$p = parent::validate( $value, $alldata );

		if ( $p !== true ) {
			return $p;
		}

		$value = trim( $value );

		// TODO: further validation

		return true;
	}

}
