<?php
class UserService extends Service {

	const CACHE_EXPIRATION = 86400;//1 day

	private static $userCache;
	private static $userCacheMapping;

	public static function getNameFromUrl($url) {
		$out = false;

		$userUrlParted = explode(':', $url, 3);
		if( isset($userUrlParted[2]) ) {
			$user = User::newFromName( urldecode($userUrlParted[2]) );
			if( $user instanceof User ) {
				$out = $user->getName();
			}
		}

		return $out;
	}

	/**
	 * Method for acquiring the list of users from database as User class objects.
	 *
	 * @param $ids array|string list of ids or names for users, should be specified as
	 * array( 'user_id' => array(ids)|id [, 'user_name' => array(names)|name ]) or array( ids and names )
	 * @return mixed array list of User class objects
	 */
	public function getUsers( $ids ) {
		wfProfileIn( __METHOD__ );

		$where = $this->parseIds( $ids );
		$result = $this->getUsersObjects( $where );

		wfProfileOut( __METHOD__ );
		return array_unique( $result );
	}

	/**
	 * Given a user object, this method will create a temporary password and save it to the
	 * user's account.  Every time this is called, the reset password throttle is reset, which
	 * means the method User::isPasswordReminderThrottled will return true for the next
	 * $wgPasswordReminderResendTime hours
	 *
	 * @param User $targetUser
	 *
	 * @return String
	 *
	 * @throws MWException
	 */
	public function resetPassword( User $targetUser ) {
		$context = RequestContext::getMain();
		$currentUser = $context->getUser();
		$currentIp = $context->getRequest()->getIP();

		wfRunHooks( 'User::mailPasswordInternal', [
			$currentUser,
			$currentIp,
			$targetUser,
		] );

		$tempPass = $targetUser->randomPassword();
		$targetUser->setNewpassword( $tempPass, $resetThrottle = true );
		$targetUser->saveSettings();

		return $tempPass;
	}

	/** Helper methods for getUsers */

	/**
	 * Methods builds User object depending on Ids and Names in ids array
	 * @param $ids array list of user ids and names to look for
	 * @return array with User objects
	 */
	private function getUsersObjects( $ids ) {
		wfProfileIn( __METHOD__ );
		$result = array();

		if( isset( $ids[ 'user_id' ] ) ) {
			foreach( $ids[ 'user_id' ] as $id ) {
				$user = User::newFromId( $id );
				//skip default user
				if ( $user && $user->getTouched() != 0 ) {
					$result[] = $user;
				}
			}
		}
		if( isset( $ids[ 'user_name' ] ) ) {
			foreach( $ids[ 'user_name' ] as $name ) {
				$user = User::newFromName( $name );
				//skip default user
				if ( $user && $user->getTouched() != 0 ) {
					$result[] = $user;
				}
			}
		}
		wfProfileOut( __METHOD__ );
		return array_unique( $result );
	}


	/**
	 * The method parse ids so they can be used in sql query and cache
	 * @param $ids array|string ids and names to parse
	 * @return array
	 */
	private function parseIds( $ids ) {

		if ( !isset( $ids[ 'user_id' ] ) && !isset( $ids[ 'user_name' ] ) ) {
			$conds = array();
			//make it array, so we can filter it using array_filter
			if ( !is_array( $ids ) ) {
				$ids = array( $ids );
			}
			foreach ( $ids as $id ) {
				if ( is_numeric( $id ) ) {
					$numeric[] = $id;
				} elseif( !empty( $id ) ) {
					$text[] = $id;
				}
			}
			if ( !empty( $numeric ) ) {
				$conds[ 'user_id' ] = $numeric;
			}
			if ( !empty( $text ) ) {
				$conds[ 'user_name' ] = $text;
			}
			return $conds;
		}
		return $ids;
	}
}