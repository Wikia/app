<?php
/**
 * Assert
 *
 * wrapper for assertions. This is used because the php manual explicitly discourages the use of assert(), and that
 * functionality can be disabled. This will also log using WikiaLogger when the assertion fails.
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

namespace Wikia\Util\ErrorChecking;

use Wikia\Logger\WikiaLogger;

class Assert {
	/**
	 * @param mixed $check
	 * @param string|null $message
	 * @return bool true if the check passes
	 * @throws AssertionException if the check fails
	 */
	public static function true( $check, $message = 'Assert::true failed' ) {
		if ( !$check ) {
			$exception = new AssertionException( $message );
			WikiaLogger::instance()->error( $message, [
				'exception' => $exception,
			] );
			throw $exception;
		}

		return true;
	}
}
