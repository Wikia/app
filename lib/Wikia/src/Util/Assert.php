<?php
/**
 * Assert
 *
 * wrapper for assertions. This is used because the php manual explicitly discourages the use of assert(), and that
 * functionality can be disabled. This will also log using WikiaLogger when the assertion fails.
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

namespace Wikia\Util;

use Wikia\Logger\WikiaLogger;

class Assert {
	/**
	 * @param boolean $check
	 * @param string|null $message
	 * @return bool true if the check passes
	 * @throws \Exception if the check fails
	 */
	public static function boolean( $check, $message = 'Assert::boolean failed' ) {
		if ( !$check ) {
			$exception = new \Exception( $message );
			WikiaLogger::instance()->error( $message, [
				'exception' => $exception,
			] );
			throw $exception;
		}

		return true;
	}
}
