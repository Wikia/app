<?php

/**
 *
 * @file
 * @ingroup SF
 */

/**
 * Ajax handler for the autoedit parser function and for the
 * submit and continue button in forms
 *
 * @author Stephan Gambke
 * @ingroup SF
 */
class SFAutoEditAjaxHandler {

	private $mOptions = array( );

	static function handleAutoEdit ( $optionsString = null, $prefillFromExisting = 'true' ) {
		$handler = new self( $optionsString );
		return $handler -> storeSemanticData( $prefillFromExisting === 'true' );
	}

	function __construct ( $options ) {

		global $wgParser, $wgUser, $wgVersion;

		$title = Title::newFromText( 'DummyTitle' );

//		if ( version_compare( substr( $wgVersion, 0, 4 ), '1.17', '<' ) ) {
			if ( !StubObject::isRealObject( $wgParser ) )
				$wgParser -> _unstub();

			// perform offensive operation
			$wgParser -> startExternalParse( $title, ParserOptions::newFromUser( $wgUser ), Parser::OT_HTML, true );
//		} else {
//			$wgParser -> startExternalParse( $title, ParserOptions::newFromUser( $wgUser ), Parser::OT_HTML, true );
//		}

		// parse options
		$this -> parseDataFromQueryString( $this -> mOptions, $options, true );
	}

	/**
	 *
	 * @global  $wgOut
	 * @global  $wgRequest
	 * @global <type> $wgUser
	 * @global <type> $wgParser
	 * @return <type>
	 */
	private function storeSemanticData ( $prefillFromExisting = true ) {

		global $wgOut, $wgRequest, $wgParser, $wgTitle;

		if ( !array_key_exists( 'ok text', $this -> mOptions ) ) {
			$this -> mOptions[ 'ok text' ] = wfMsg( 'sf_autoedit_success' );
		}

		if ( !array_key_exists( 'error text', $this -> mOptions ) ) {
			$this -> mOptions[ 'error text' ] = '$1';
		}


		$oldRequest = $wgRequest;

		// If the wiki is read-only we might as well stop right away
		if ( wfReadOnly ( ) ) {
			return array( 'autoedit-readonly', wfReadOnlyReason() );
		}

		// If we have no target article and no form we might as well stop right away
		if ( !array_key_exists( 'target', $this -> mOptions )
			&& !array_key_exists( 'form', $this -> mOptions ) ) {
			return 'autoedit-notargetspecified';
		}

		// check if form was specified
		if ( !array_key_exists( 'form', $this -> mOptions ) ) {

			// no form specified, find one
			// get title object and id for requested target article
			$title = Title::newFromText( $this -> mOptions[ 'target' ] );
			$form_names = SFFormLinker::getDefaultFormsForPage( $title );

			// if no form can be found, return
			if ( count( $form_names ) == 0 ) {
				return 'autoedit-noformfound';
			}

			// if more than one form found, return
			if ( count( $form_names ) > 1 ) {
				return 'autoedit-toomanyformsfound';
			}

			// use the first found form
			$this -> mOptions[ 'form' ] = $form_names[ 0 ];
		}

		// we only care for the form's body
		$wgOut -> setArticleBodyOnly( true );

		$formedit = new SFFormEdit();
		$data = array( );

		////////////////////////////////////////////////////////////////////////
		// First get the Semantic Form and extract its data (if requested)
		// and modify or set as specified in the options string

		if ( $prefillFromExisting ) {

			$wgRequest = new FauxRequest( $this -> mOptions, true );

			// get the Semantic Form
			if ( array_key_exists( 'target', $this -> mOptions ) ) {
				$formedit -> execute( $this -> mOptions[ 'form' ] . '/' . $this -> mOptions[ 'target' ] );
			} else {
				$formedit -> execute( $this -> mOptions[ 'form' ] );
			}

			// extract its data
			$form = $this -> parseDataFromHTMLFrag( $data, trim( $wgOut -> getHTML() ), 'sfForm' );

			if ( !$form ) {
				// something went wrong
				return array(
					'autoedit-nosemanticform',
					array(
						$this -> mOptions[ 'target' ],
						$this -> mOptions[ 'form' ]
					)
				);
			}
		} else {
			$this -> addToArray( $data, "wpSave", "Save" );
		}
		// and modify as specified
		$data = $this -> array_merge_recursive_distinct( $data, $this -> mOptions );

		////////////////////////////////////////////////////////////////////////
		// Store the modified form
		//$wgOut -> clearHTML();
		$wgRequest = new FauxRequest( $data, true );

		// get the MW form
		if ( array_key_exists( 'target', $this -> mOptions ) ) {
			$formedit -> execute( $this -> mOptions[ 'form' ] . '/' . $this -> mOptions[ 'target' ], false );
		} else {
			$formedit -> execute( $this -> mOptions[ 'form' ], false );
		}

		$wgParser -> getOptions() -> enableLimitReport( false );

		if ( $formedit -> mError ) {

			$msg = $formedit -> mError; // Should this be sanitized? I.e. all html tags removed?

			$msg = $wgParser -> parse(
					wfMsgReplaceArgs( $this -> mOptions[ 'error text' ], array( $msg ) ),
					$wgTitle,
					$wgParser -> getOptions()
				) -> getText();

			$result = new AjaxResponse( $msg );
			$result -> setResponseCode( '400 Bad Request' );
			return $result;
		} else {

			header( "X-Location: " . $wgOut -> getRedirect() );
			header( "X-Form: " . $formedit -> mForm );
			header( "X-Target: " . $formedit -> mTarget );

			$msg = $wgParser -> recursiveTagParse( wfMsgReplaceArgs( $this -> mOptions[ 'ok text' ], array( $formedit -> mTarget, $formedit -> mForm ) ) );

			$result = new AjaxResponse( $msg );
			return $result;
		}
	}

	private function parseDataFromHTMLFrag ( &$data, $html, $formID ) {
		$doc = new DOMDocument();
		@$doc -> loadHTML(
				'<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd"><html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/></head><body>'
				. $html
				. '</body></html>'
		);

		$form = $doc -> getElementById( $formID );

		if ( !$form ) {
			return null;
		}

		// Process input tags
		$inputs = $form -> getElementsByTagName( 'input' );

		for ( $i = 0; $i < $inputs -> length; $i++ ) {

			$input = $inputs -> item( $i );
			$type = $input -> getAttribute( 'type' );
			$name = trim( $input -> getAttribute( 'name' ) );

			if ( !$name )
				continue;

			if ( $type == '' )
				$type = 'text';

			switch ( $type ) {
				case 'checkbox':
				case 'radio':
					if ( $input -> getAttribute( 'checked' ) )
						$this -> addToArray( $data, $name, $input -> getAttribute( 'value' ) );
					break;

				//case 'button':
				case 'hidden':
				case 'image':
				case 'password':
				//case 'reset':
				//case 'submit':
				case 'text':
					$this -> addToArray( $data, $name, $input -> getAttribute( 'value' ) );
					break;

				case 'submit':
					if ( $name == "wpSave" )
						$this -> addToArray( $data, $name, $input -> getAttribute( 'value' ) );
			}
		}

		// Process select tags
		$selects = $form -> getElementsByTagName( 'select' );

		for ( $i = 0; $i < $selects -> length; $i++ ) {

			$select = $selects -> item( $i );
			$name = trim( $select -> getAttribute( 'name' ) );

			if ( !$name )
				continue;

			$values = array( );
			$options = $select -> getElementsByTagName( 'option' );

			if ( count( $options ) && (!$select -> hasAttribute( "multiple" ) || $options -> item( 0 ) -> hasAttribute( 'selected' ) ) ) {
				$this -> addToArray( $data, $name, $options -> item( 0 ) -> getAttribute( 'value' ) );
			}

			for ( $o = 1; $o < $options -> length; $o++ ) {
				if ( $options -> item( $o ) -> hasAttribute( 'selected' ) )
					$this -> addToArray( $data, $name, $options -> item( $o ) -> getAttribute( 'value' ) );
			}
		}

		// Process textarea tags
		$textareas = $form -> getElementsByTagName( 'textarea' );

		for ( $i = 0; $i < $textareas -> length; $i++ ) {

			$textarea = $textareas -> item( $i );
			$name = trim( $textarea -> getAttribute( 'name' ) );

			if ( !$name )
				continue;

			$this -> addToArray( $data, $name, $textarea -> textContent );
		}

		return $form;
	}

	/**
	 * Parses data from a query string into the $data array
	 *
	 * @global $wgParser
	 * @global $wgOut
	 * @param Array $data
	 * @param String $queryString
	 * @param Boolean $expand  If this is set to true, field values will get urldecoded and expanded
	 *  This allows to slip parser functions by the MW parser on page creation
	 *  (by urlencoding them) and to pass them to autoedit to expand them now.
	 *  Expanding parser functions on page creation already might lead to cache
	 *  issues, e.g. for the {{#time:}} parser function
	 * @return <type>
	 */
	private function parseDataFromQueryString ( &$data, $queryString, $expand = false ) {
		$params = explode( '&', $queryString );

		foreach ( $params as $i => $param ) {
			$elements = explode( '=', $param, 2 );

			$key = trim( urldecode( $elements[ 0 ] ) );
			$value = count( $elements ) > 1 ? urldecode( $elements[ 1 ] ) : null;

			if ( $key == "query string" ) {
				$this -> parseDataFromQueryString( $data, $value, $expand );
			} elseif ( $expand ) {
				$this -> addToArray( $data, $key, $value );
			} else {
				$this -> addToArray( $data, $key, $value );
			}
		}

		return $data;
	}

	// This function recursively inserts the value into a tree.
	// $array is root
	// $key identifies path to position in tree.
	// Format: 1stLevelName[2ndLevel][3rdLevel][...], i.e. normal array notation
	// $value: the value to insert
	private function addToArray ( &$array, $key, $value ) {
		$matches = array( );

		if ( preg_match( '/^([^\[\]]*)\[([^\[\]]*)\](.*)/', $key, $matches ) ) {

			$key = str_replace( ' ', '_', $matches[ 1 ] );
			$key = str_replace( '.', '_', $key );

			if ( !array_key_exists( $key, $array ) )
				$array[ $key ] = array( );

			$this -> addToArray( $array[ $key ], $matches[ 2 ] . $matches[ 3 ], $value );
		} else {

			if ( $key ) {
//				$key = str_replace( ' ', '_', $key );
//				$key = str_replace( '.', '_', $key );
//				var_dump($key);
				$array[ $key ] = $value;
			} else {
				array_push( $array, $value );
			}
		}
	}

	/**
	 * array_merge_recursive merges arrays, but it converts values with duplicate
	 * keys to arrays rather than overwriting the value in the first array with the duplicate
	 * value in the second array, as array_merge does.
	 *
	 * array_merge_recursive_distinct does not change the datatypes of the values in the arrays.
	 * Matching keys' values in the second array overwrite those in the first array.
	 *
	 * Parameters are passed by reference, though only for performance reasons. They're not
	 * altered by this function.
	 *
	 * See http://www.php.net/manual/en/function.array-merge-recursive.php#92195
	 *
	 * @param array $array1
	 * @param array $array2
	 * @return array
	 * @author Daniel <daniel (at) danielsmedegaardbuus (dot) dk>
	 * @author Gabriel Sobrinho <gabriel (dot) sobrinho (at) gmail (dot) com>
	 */
	private function array_merge_recursive_distinct ( array &$array1, array &$array2 ) {

		$merged = $array1;

		foreach ( $array2 as $key => &$value ) {
			if ( is_array( $value ) && isset( $merged [ $key ] ) && is_array( $merged [ $key ] ) ) {
				$merged [ $key ] = $this -> array_merge_recursive_distinct( $merged [ $key ], $value );
			} else {
				$merged [ $key ] = $value;
			}
		}

		return $merged;
	}

}

