<?php

/**
 * CookieBlock module
 *
 * Blocks user based on browser cookie, interacts with and depends on AccountCreationTracker
 *
 * @author Lucas Garczewski <tor@wikia-inc.com>
 * @date 2011-12-13
 */

class UserCookieBlock extends UserBlock {
	const TYPE = Phalanx::TYPE_COOKIE;
	const CACHE_KEY = 'user-cookie-status';

	/**
	 * @static
	 * @param User $user
	 * @return array|bool|null
	 */
	public static function blockCheck(User $user) {
		global $wgUser, $wgMemc;
		wfProfileIn( __METHOD__ );

		// dependancy -- if this doesn't exist, quit early
		if ( !class_exists( 'AccountCreationTracker' ) ) {
			wfProfileOut( __METHOD__ );
			return true;
		}

		// we don't block anons with this filter
		if ( $user->isAnon() ) {
			wfProfileOut( __METHOD__ );
			return true;
		}

		$ret = true;

		// RT#42011: RegexBlock records strange results
		// don't write stats for other user than visiting user
		$isCurrentUser = $user->getName() == $wgUser->getName();

		// check cache first before proceeding
		$cachedState = self::getBlockFromCache( $user, $isCurrentUser );
		if ( !is_null( $cachedState ) ) {
			wfProfileOut( __METHOD__ );
			return $cachedState;
		}

		$tracker = new AccountCreationTracker();
		$hashes = $tracker->getHashesByUser( $user );

		$blocksData = Phalanx::getFromFilter( self::TYPE );

		if ( !empty( $blocksData ) && !empty( $hashes ) ) {
			foreach ( $hashes as $hash ) {
				$ret = self::blockCheckInternal( $user, $blocksData, $hash, $isCurrentUser );
				if ( !$ret ) {
					// only check until we get first blocking match
					break;
				}
			}
		}

		// populate cache if not done before
		if ( $ret ) {
			$cacheKey = self::getCacheKey( $user );
			$cachedState = array(
					'timestamp' => wfTimestampNow(),
					'block' => false,
					'return' => $ret,
					);
			$wgMemc->set( $cacheKey, $cachedState );
		}

		wfProfileOut( __METHOD__ );
		return $ret;
	}
}
