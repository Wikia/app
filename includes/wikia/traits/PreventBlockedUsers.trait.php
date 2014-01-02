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
	public function preventUsage( User $user, $action ) {
		$result = false;

		if ( !in_array( $action, $this->whitelist() ) && $user->isBlocked() ) {
			$result = true;
			$this->onUsagePrevented( $user );
		}

		return $result;
	}

	/**
	 * action to take when a user is prevented from taking an action
	 * @param User $user
	 */
	protected function onUsagePrevented( User $user ) {
	}
}

/**
 * Trait PreventBlockedUsersThrowsError
 * extends base trait to throw a UserBlockedError when a user is prevented from taking an action
 */
trait PreventBlockedUsersThrowsError {
	use PreventBlockedUsers;

	protected function onUsagePrevented( User $user ) {
		throw new UserBlockedError( $user->mBlock );
	}
}