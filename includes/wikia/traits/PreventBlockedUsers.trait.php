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
	 * list of controller actions that should be allowed even if a user is blocked
	 * @return array
	 */
	protected function whitelist() {
		return [ ];
	}

	/**
	 * @param User $user
	 * @param string $action
	 * @return bool
	 * @throws UserBlockedError
	 */
	public function preventUsage( User $user, $action ) {
		$result = false;

		if ( !in_array( $action, $this->whitelist() ) && $user->isBlocked() ) {
			$result = true;
			$this->onUsagePrevented( $user );
		}

		return $result;
	}

	protected function onUsagePrevented( User $user ) {
		// do nothing in base implementation
	}
}

trait PreventBlockedUsersThrowsError {
	use PreventBlockedUsers;

	protected function onUsagePrevented( User $user ) {
		throw new UserBlockedError( $user->mBlock );
	}
}