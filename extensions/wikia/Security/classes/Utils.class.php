<?php

namespace Wikia\Security;

class Utils {

	/**
	 * A more generic version of User::matchEditToken that can be used for checking custom tokens
	 *
	 * @see PLATFORM-1703
	 *
	 * @param string $expectedValue expected token value
	 * @param string $value token value from the request
	 * @return boolean
	 */
	public static function matchToken( $expectedValue, $value ) {
		CSRFDetector::onUserMatchEditToken(); // set a flag that the token was checked

		// It is important to provide the user-supplied string as the second parameter, rather than the first.
		return hash_equals( $expectedValue, $value );
	}

	/**
	 * Call the above method and assert that the HTTP request method is secure (even if it's GET)
	 *
	 * @see PLATFORM-2207
	 *
	 * @param string $expectedValue expected token value
	 * @param string $value token value from the request
	 * @return boolean
	 */
	public static function matchSecretToken( $expectedValue, $value ) {
		$matches = self::matchToken( $expectedValue, $value );

		if ( $matches ) {
			\Wikia\Security\CSRFDetector::markHttpMethodAccepted( __METHOD__ );
		}

		return $matches;
	}
}