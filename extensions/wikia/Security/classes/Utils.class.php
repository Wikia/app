<?php

namespace Wikia\Security;

class Utils {

	/**
	 * A more generic version of User::matchEditToken that can be used for checking custom tokens
	 *
	 * @see PLATFORM-1703
	 *
	 * @param $expectedValue
	 * @param $value
	 * @return boolean
	 */
	public static function matchToken( $expectedValue, $value ) {
		CSRFDetector::onUserMatchEditToken(); // set a flag that the token was checked

		return $expectedValue === $value;
	}
}