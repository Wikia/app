<?php
if ( ! defined( 'MEDIAWIKI' ) )
	die();

class AssertEdit {
	/**
	 * methods for core assertions
	 *
	 * @param $editPage
	 * @return bool
	 */
	static function assert_user( $editPage ) {
		global $wgUser;
		return $wgUser->isLoggedIn();
	}

	/**
	 * @static
	 * @param $editPage EditPage
	 * @return bool
	 */
	static function assert_bot( $editPage ) {
		global $wgUser;
		return $wgUser->isAllowed( 'bot' );
	}

	/**
	 * @static
	 * @param $editPage EditPage
	 * @return bool
	 */
	static function assert_exists( $editPage ) {
		return $editPage->mTitle->exists();
	}

	/**
	 * List of assertions; can be modified with setAssert
	 */
	public static $msAssert = array(
		// simple constants, i.e. to test if the extension is installed.
		'true' => true,
		'false' => false,
		// useful variable tests, to ensure we stay logged in
		'user' => array( 'AssertEdit', 'assert_user' ),
		'bot' => array( 'AssertEdit', 'assert_bot' ),
		'exists' => array( 'AssertEdit', 'assert_exists' ),
		// override these in LocalSettings.php
		// 'wikimedia' => false, //is this an offical wikimedia site?
		'test' => false      // Do we allow random tests?
	);

	static function setAssert( $key, $value ) {
		// Don't confuse things by changing core assertions.
		switch ( $key ) {
			case 'true':
			case 'false':
			case 'user':
			case 'bot':
			case 'exists':
				return false;
		}
		// make sure it's useable.
		if ( is_bool( $value ) || is_callable( $value ) ) {
			self::$msAssert[$key] = $value;
			return true;
		} else {
			return false;
		}
	}

	// call the specified assertion
	static function callAssert( $editPage, $assertName, $negate ) {
		if ( isset( self::$msAssert[$assertName] ) ) {
			if ( is_bool( self::$msAssert[$assertName] ) ) {
				$pass = self::$msAssert[$assertName];
			} elseif ( is_callable( self::$msAssert[$assertName] ) ) {
				$pass = call_user_func( self::$msAssert[$assertName], $editPage );
			}

			if ( $negate && isset( $pass ) ) {
				$pass = !$pass;
			}
		} else {
			// unrecognized assert fails, regardless of negation.
			$pass = false;
		}
		return $pass;
	}
}
