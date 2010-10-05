<?php

class AdSS_AdForm {

	public $fields;
	public $errors;

	function __construct() {
		$this->fields = array(
				'wpUrl'   => '',
				'wpText'  => '',
				'wpDesc'  => '',
				'wpType'  => 'site',
				'wpPage'  => '',
				'wpEmail' => '',
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
		$this->fields['wpEmail'] = $r->getText( 'wpEmail' );
	}

	function isValid() {
		$nonEmptyFields = array( 'wpUrl', 'wpText', 'wpDesc', 'wpEmail' );
		foreach( $nonEmptyFields as $f ) {
			if( empty( $this->fields[$f] ) ) {
				$this->errors[$f] = wfMsgHtml( 'adss-form-field-empty-errormsg' );
			}
		}

		if( $this->fields['wpType'] == 'page' ) {
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
			echo '';
		}
	}

	function getToken() {
		wfSetupSession();
		if( !isset( $_SESSION['wsAdSSToken'] ) ) {
			$token = $this->generateToken();
			$_SESSION['wsAdSSToken'] = $token;
		} else {
			$token = $_SESSION['wsAdSSToken'];
		}
		return md5( $token );
	}

	function matchToken( $token ) {
		$sessionToken = $this->getToken();
		if( $sessionToken != $token ) {
			wfDebug( __METHOD__ . ": broken session data\n" );
		}
		return $sessionToken == $token;
	}

	function generateToken() {
		$token = dechex( mt_rand() ) . dechex( mt_rand() );
		return md5( $token );
	}

	static function formatPrice( $priceConf ) {
		switch( $priceConf['period'] ) {
			case 'd': return wfMsgHtml( 'adss-form-usd-per-day', $priceConf['price'] );
			case 'w': return wfMsgHtml( 'adss-form-usd-per-week', $priceConf['price'] );
			case 'm': return wfMsgHtml( 'adss-form-usd-per-month', $priceConf['price'] );
		}
	}

	static function formatPriceAjax( $wpType, $wpPage ) {
		if( $wpType == 'site' ) {
			$wpPage = '';
		}

		wfLoadExtensionMessages( 'AdSS' );

		$priceConf = AdSS_Util::getPriceConf( Title::newFromText( $wpPage ) );
		$priceStr = self::formatPrice( $priceConf );

		$response = new AjaxResponse( Wikia::json_encode( $priceStr ) );
		$response->setContentType( 'application/json; charset=utf-8' );

		return $response;
	}
}
