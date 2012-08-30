<?php

/**
 * UserBlock
 *
 * This filter blocks a user (exactly the same as a local MediaWiki block),
 * if the user's name matches one of the blacklisted phrases or IPs.
 *
 * @author Marooned <marooned at wikia-inc.com>
 * @author Lucas Garczewski <tor@wikia-inc.com>
 * @date 2010-06-09
 */

class UserBlock {
	const TYPE = Phalanx::TYPE_USER;
	const CACHE_KEY = 'user-status';

	/**
	 * @desc blockCheck() will return false if user is blocked. The reason why it was
	 * written in such way is below when you look at method UserBlock::onUserCanSendEmail().
	 */
	public static function blockCheck(User $user) {
		global $wgUser, $wgMemc, $wgRequest;
		wfProfileIn( __METHOD__ );

		$ret = true;
		$text = $user->getName();

		// RT#42011: RegexBlock records strange results
		// don't write stats for other user than visiting user
		$isCurrentUser = $text == $wgUser->getName();

		// check cache first before proceeding
		$cachedState = self::getBlockFromCache( $user, $isCurrentUser );
		if ( !is_null( $cachedState ) ) {
			wfProfileOut( __METHOD__ );
			return $cachedState;
		}

		$blocksData = Phalanx::getFromFilter( self::TYPE );
		if ( !empty($blocksData) && !empty($text) ) {
			if ( $user->isAnon() ) {
				$ret =  self::blockCheckInternal( $user, $blocksData, $text, true, $isCurrentUser );
			} else {
				$ret = self::blockCheckInternal( $user, $blocksData, $text, false, $isCurrentUser );
				//do not check IP for current user when checking block status of different user
				if ( $ret && $isCurrentUser ) {
					// if the user name was not blocked, check for an IP block
					$ret = self::blockCheckInternal( $user, $blocksData, $wgRequest->getIP(), true, $isCurrentUser );
				}
			}
		}

		// populate cache if not done before
		if ( $ret ) {
			$cachedState = array(
				'timestamp' => wfTimestampNow(),
				'block' => false,
				'return' => $ret,
			);
			$wgMemc->set( self::getCacheKey( $user ), $cachedState );
		}

		wfProfileOut( __METHOD__ );
		return $ret;
	}

	protected static function blockCheckInternal( User $user, $blocksData, $text, $isBlockIP = false, $writeStats = true ) {
		global $wgMemc;
		wfProfileIn( __METHOD__ );

		foreach ($blocksData as $blockData) {
			if ( $isBlockIP && !$user->isIP($blockData['text'])) {
				continue;
			}

			$result = Phalanx::isBlocked( $text, $blockData, $writeStats );

			if ( $result['blocked'] ) {
				Wikia::log(__METHOD__, __LINE__, "Block '{$result['msg']}' blocked '$text'.");
				self::setUserData( $user, $blockData, $text, $isBlockIP );

				$cachedState = array(
					'timestamp' => wfTimestampNow(),
					'block' => $blockData,
					'return' => false,
				);
				$wgMemc->set( self::getCacheKey( $user ), $cachedState );

				wfProfileOut( __METHOD__ );
				return false;
			}
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	protected static function getCacheKey( User $user ) {
		return wfSharedMemcKey( 'phalanx', self::CACHE_KEY, $user->getTitleKey() );
	}

	protected static function getBlockFromCache( User $user, $isCurrentUser ) {
		global $wgMemc;
		wfProfilein( __METHOD__ );

		$cacheKey = self::getCacheKey( $user );
		$cachedState = $wgMemc->get( $cacheKey );

		if ( !empty( $cachedState ) && $cachedState['timestamp'] > (int) Phalanx::getLastUpdate() ) {
			if ( !$cachedState['return'] && $isCurrentUser ) {
				self::setUserData( $user, $cachedState['block'], '', $user->isAnon() );
			}

			//added to make User::isBlockedGlobally() work for this instance of User class
			$user->mBlockedGlobally = !$cachedState['return'];

			wfProfileOut( __METHOD__ );
			return $cachedState['return'];
		}

		wfProfileOut( __METHOD__ );
		return null;
	}

	//moved from RegexBlockCore.php
	private static function setUserData(User $user, $blockData, $address /* not used at all */, $isBlockIP = false) {
		wfProfileIn( __METHOD__ );
		$user->mBlockedby = $blockData['author_id'];

		//added to make User::isBlockedGlobally()
		//work for this instance of User class
		//-- Andrzej 'nAndy' Łukaszewski
		$user->mBlockedGlobally = true;

		if ($blockData['reason']) {
			// a reason was given
			$reason = $blockData['reason'];
			if ($blockData['exact']) {
				$user->mBlockreason = wfMsg('phalanx-user-block-withreason-exact', $reason);
			} elseif ($isBlockIP) {
				$user->mBlockreason = wfMsg('phalanx-user-block-withreason-ip', $reason);
			} else {
				$user->mBlockreason = wfMsg('phalanx-user-block-withreason-similar', $reason);
			}
		} else {
			// no reason in block data, so use preexisting no-param worded versions
			if ($blockData['exact']) {
				$user->mBlockreason = wfMsg('phalanx-user-block-reason-exact');
			} elseif ($isBlockIP) {
				$user->mBlockreason = wfMsg('phalanx-user-block-reason-ip');
			} else {
				$user->mBlockreason = wfMsg('phalanx-user-block-reason-similar');
			}
		}

		// set expiry information
		$user->mBlock = new Block();
		// protected
		$user->mBlock->setId( $blockData['id'] );
		$user->mBlock->setBlockEmail( true );
		// public
		$user->mBlock->mExpiry = is_null($blockData['expire']) ? 'infinity' : $blockData['expire'];
		$user->mBlock->mTimestamp = wfTimestamp( TS_MW, $blockData['timestamp'] );
		$user->mBlock->mAddress = $blockData['text'];

		// account creation check goes through the same hook...
		if ($isBlockIP) {
			$user->mBlock->setCreateAccount( 1 );
		}

		wfProfileOut( __METHOD__ );
	}

	/*
	 * Hook handler
	 * @author Marooned
	 */
	public static function onUserCanSendEmail(&$user, &$canSend) {
		$canSend = self::blockCheck($user);
		return true;
	}

	/**
	 * Hook handler
	 * Checks if user just being created is not blocked
	 *
	 * @author wladek
	 * @param $user User
	 * @param $name string
	 * @param $validate string
	 */
	public static function onAbortNewAccount( $user, &$abortError ) {
		$text = $user->getName();
		$blocksData = Phalanx::getFromFilter( self::TYPE );
		$state = self::blockCheckInternal( $user, $blocksData, $text, false, true );
		if ( !$state ) {
			$abortError = wfMsg( 'phalanx-user-block-new-account' );
			return false;
		}
		// Check if email is blocked
		$emailBlocksData = Phalanx::getFromFilter( Phalanx::TYPE_EMAIL );
		$userEmail = $user->getEmail();
		if ( $userEmail !== '' ) {
			foreach ( $emailBlocksData as $emailBlockData ) {
				$result = Phalanx::isBlocked( $userEmail, $emailBlockData, true );
				if ( $result['blocked'] ) {
					$abortError = wfMsg( 'phalanx-user-block-new-account' );
					return false;
				}
			}
		}
		return true;
	}

	/**
	 * Hook handler
	 * Checks if user name is not blocked
	 *
	 * @author wladek
	 * @param $userName string
	 * @param $abortError string [OUTPUT]
	 */
	public static function onValidateUserName( $userName, &$abortError ) {
		$user = User::newFromName($userName);
		$message = '';
		if ( !$user || !self::onAbortNewAccount($user, $message) ) {
			$abortError = wfMsg( 'phalanx-user-block-new-account' );
			return false;
		}
		return true;
	}
}
