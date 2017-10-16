<?php

namespace Email;
/**
 * Class Helper
 *
 * Common methods used between controllers and classes
 *
 * @package Email
 */
class Helper {
	const REQUIRED_USER_RIGHT = 'access-sendemail';

	public static function userCanAccess() {
		return \F::app()->wg->User->isAllowed( self::REQUIRED_USER_RIGHT );
	}
}
