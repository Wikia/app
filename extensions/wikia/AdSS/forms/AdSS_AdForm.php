<?php

class AdSS_AdForm {

	public $fields;
	public $errors;

	function __construct() {
		$this->fields = array(
				'wpUrl'      => '',
				'wpText'     => '',
				'wpDesc'     => '',
				'wpType'     => '',
				'wpPage'     => '',
				'wpWeight'   => '',
				'wpEmail'    => '',
				'wpPassword' => '',
				);
		$this->errors = array();
	}

	static function newFromRequest( $r ) {
		$ad = new AdSS_AdForm();
		$ad->loadFromRequest( $r );
		return $ad;
	}

	function loadFromRequest( $r ) {
		$this->fields['wpUrl'] = $r->getText( 'wpUrl' );
		$this->fields['wpText'] = $r->getText( 'wpText' );
		$this->fields['wpDesc'] = $r->getText( 'wpDesc' );
		$this->fields['wpType'] = $r->getText( 'wpType' );
		$this->fields['wpPage'] = $r->getText( 'wpPage' );
		$this->fields['wpWeight'] = $r->getText( 'wpWeight' );
		$this->fields['wpEmail'] = $r->getText( 'wpEmail' );
		$this->fields['wpPassword'] = $r->getText( 'wpPassword' );
	}

	function isValid() {
		$nonEmptyFields = array( 'wpUrl', 'wpText', 'wpDesc', 'wpEmail' );
		foreach( $nonEmptyFields as $f ) {
			if( empty( $this->fields[$f] ) ) {
				$this->errors[$f] = wfMsgHtml( 'adss-form-field-empty-errormsg' );
			}
		}

		if( $this->fields['wpType'] == '' ) {
			$this->errors['wpType'] = wfMsgHtml( 'adss-form-pick-plan-errormsg' );
		} elseif( $this->fields['wpType'] == 'page' ) {
		       	if( empty( $this->fields['wpPage'] ) ) {
				$this->errors['wpPage'] = wfMsgHtml( 'adss-form-field-empty-errormsg' );
			} else {
				$title = Title::newFromText( $this->fields['wpPage'] );
				if( !$title || !$title->exists() ) {
					$this->errors['wpPage'] = wfMsgHtml( 'adss-form-non-existent-title-errormsg' );
				}
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
