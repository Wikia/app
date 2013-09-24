<?php
/**
 * PreventBlockedUsers
 *
 * Trait that can be attached to objects to prevent blocked users from accessing content
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */
trait PreventBlockedUsers {
	static $name = 'PreventBlockedUsers';

	static $ACTION_ERROR = 0;

	static $ACTION_NONE = 1;

	/** @var bool whether or not this trait actively prevents blocked users from actions */
	protected $preventBlockedUsers = false;

	/** @var int what action to take when a user is prevented */
	protected $onUsagePrevented = 0; // self::$ACTION_ERROR;

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
	public function preventUsage( $user, $action ) {
		$result = false;

		if ( $this->preventBlockedUsers && !in_array( $action, $this->whitelist() ) && $user->isBlocked() ) {
			$result = true;
			switch ( $this->onUsagePrevented ) {
				case self::$ACTION_ERROR:
					throw new UserBlockedError( $user->mBlock );
					break;
			}
		}

		return $result;
	}
}