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

	static $ACTION_NONE = 0; // do nothing, just return false to let the consumer know
	static $ACTION_ERROR = 1; // actively throw an error

	/** @var bool whether or not this trait actively prevents blocked users from actions */
	protected $preventBlockedUsers = false;

	/** @var int what action to take when a user is prevented */
	protected $onUsagePrevented = 1; // self::$ACTION_ERROR;

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