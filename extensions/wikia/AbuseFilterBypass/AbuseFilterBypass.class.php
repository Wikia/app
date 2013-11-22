<?php
/**
 * AbuseFilterBypass
 *
 * Allows staff to bypass AbuseFilter checks
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

class AbuseFilterBypass {
	/**
	 * determine if a user should be allowed to skip filter checks
	 * @param User $user
	 * @return bool
	 */
	public static function onBypassCheck( User $user ) {
		$skipFilters = $user->isAllowed( 'abusefilter-bypass' );
		return !$skipFilters; // since we check that these hooks return false
	}
}