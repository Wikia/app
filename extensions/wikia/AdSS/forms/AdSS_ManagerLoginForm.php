<?php

class AdSS_ManagerLoginForm {

	public $fields;
	public $errors;

	function __construct() {
		$this->fields = array(
				'wpEmail'    => '',
				'wpPassword' => '',
				);
		$this->errors = array();
	}

	static function newFromRequest( $r ) {
		$ad = new self();
		$ad->loadFromRequest( $r );
		return $ad;
	}

	function loadFromRequest( $r ) {
		$this->fields['wpEmail'] = $r->getText( 'wpEmail' );
		$this->fields['wpPassword'] = $r->getText( 'wpPassword' );
	}

	function isValid() {
		$nonEmptyFields = array( 'wpEmail', 'wpPassword' );
		foreach( $nonEmptyFields as $f ) {
			if( empty( $this->fields[$f] ) ) {
				$this->errors[$f] = wfMsgHtml( 'adss-form-field-empty-errormsg' );
			}
		}

		return ( count( $this->errors ) == 0 );
	}

	function get( $name ) {
		return $this->fields[$name];
	}

	function set( $name, $value ) {
		$this->fields[$name] = $value;
	}

	function output( $name ) {
		echo htmlspecialchars( $this->fields[$name] );
	}

	function error( $field ) {
		if( isset( $this->errors[$field] ) ) {
			echo '<div class="error">' . $this->errors[$field] . '</div>';
		} else {
			echo '<div class="error"></div>';
		}
	}

}
