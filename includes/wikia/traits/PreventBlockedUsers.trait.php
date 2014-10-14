<?php
/**
 * PreventBlockedUsers
 *
 * Trait that can be attached to objects to prevent blocked users from accessing content
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */
trait PreventBlockedUsers {
	/**
	 * list of actions that should be allowed even if a user is blocked
	 * @return array string list of actions that should be allowed
	 */
	protected function whitelist() {
		return [ ];
	}

	/**
	 * check whether a user is prevented from taking an action
	 * @param User $user
	 * @param string $action arbitrary action that the user is trying to take
	 * @return bool
	 */
	public function preventBlockedUsage( User $user, $action ) {
		$result = false;

		if ( !in_array( $action, $this->whitelist() ) && $user->isBlocked() ) {
			$result = true;
			$this->onBlockedUsagePrevented( $user );
		}

		return $result;
	}

	/**
	 * action to take when a user is prevented from taking an action
	 * @param User $user
	 */
	protected function onBlockedUsagePrevented( User $user ) {
	}
}

/**
 * Trait PreventBlockedUsersThrowsError
 * extends base trait to throw a UserBlockedError when a user is prevented from taking an action
 */
trait PreventBlockedUsersThrowsError {
	use PreventBlockedUsers;

	protected function onBlockedUsagePrevented( User $user ) {
		throw new UserBlockedError( $user->mBlock );
	}
}