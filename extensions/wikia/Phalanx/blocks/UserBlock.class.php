<?php

/**
 * UserBlock
 *
 * This filter blocks a user (exactly the same as a local MediaWiki block),
 * if the user's name matches one of the blacklisted phrases or IPs.
 *
 * @author Marooned <marooned at wikia-inc.com>
 * @author Lucas Garczewski <tor@wikia-inc.com>
 * @author Władysław Bodzek
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

		if ( $user->isAllowed( 'phalanxexempt' ) ) {
			wfDebug ( __METHOD__ . ": user has 'phalanxexempt' right - no block will be applied\n" );
			wfProfileOut( __METHOD__ );
			return true;
		}

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

		if ( !empty($text) ) {
			if ( $user->isAnon() ) {
				$ret =  self::blockCheckIP( $user, $text, $isCurrentUser );
			} else {
				$blocksData = Phalanx::getFromFilterShort( self::TYPE );
				if ( !empty($blocksData) ) {
					$ret = self::blockCheckInternal( $user, $blocksData, $text, $isCurrentUser );
				}
				//do not check IP for current user when checking block status of different user
				if ( $ret && $isCurrentUser ) {
					// if the user name was not blocked, check for an IP block
					$ret = self::blockCheckIP( $user, $wgRequest->getIP(), $isCurrentUser );
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

	protected static function blockCheckInternal( User $user, $blocksData, $text, $writeStats = true ) {
		global $wgMemc;
		wfProfileIn( __METHOD__ );

		$blockData = null;
		$result = Phalanx::findBlocked( $text, $blocksData, $writeStats, $blockData );

		if ( $result['blocked'] ) {
			Wikia::log(__METHOD__, __LINE__, "Block '{$result['msg']}' blocked '$text'.");
			self::setUserData( $user, $blockData, $text, false );

			$cachedState = array(
				'timestamp' => wfTimestampNow(),
				'block' => $blockData,
				'return' => false,
			);
			$wgMemc->set( self::getCacheKey( $user ), $cachedState );

			wfProfileOut( __METHOD__ );
			return false;
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * Directly check for IP block which is quicker than looping through all filters as we don't support
	 * anything other than exact for IP blocks, and this significantly improves performance
	 *
	 * @author grunny
	 */
	protected static function blockCheckIP( User $user, $text, $writeStats = true ) {
		global $wgMemc, $wgExternalSharedDB;
		wfProfileIn( __METHOD__ );
		
		PhalanxShadowing::setType(Phalanx::TYPE_USER);	

		$dbr = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );
		$moduleId = Phalanx::TYPE_USER;
		$timestampNow = wfTimestampNow();
		$ipAddr = IP::toHex( $text );
		$row = $dbr->selectRow(
			'phalanx',
			'*',
			array(
				"p_type & $moduleId = $moduleId",
				"p_lang IS NULL",
				'p_ip_hex' => $ipAddr,
				"p_expire IS NULL OR p_expire > {$dbr->addQuotes( $timestampNow )}"
			),
			__METHOD__
		);
		if ( $row !== false ) {
			$blockData = array(
				'id' => $row->p_id,
				'author_id' => $row->p_author_id,
				'text' => $row->p_text,
				'type' => $row->p_type,
				'timestamp' => $row->p_timestamp,
				'expire' => $row->p_expire,
				'exact' => $row->p_exact,
				'regex' => $row->p_regex,
				'case' => $row->p_case,
				'reason' => $row->p_reason,
				'lang' => $row->p_lang
			);
			Wikia::log(__METHOD__, __LINE__, "Block '{$blockData['text']}' blocked '$text'.");
			if ( $writeStats ) {
				Phalanx::addStats($blockData['id'], $blockData['type']);
			}

			self::setUserData( $user, $blockData, $text, true );

			$cachedState = array(
				'timestamp' => wfTimestampNow(),
				'block' => $blockData,
				'return' => false,
			);
			$wgMemc->set( self::getCacheKey( $user ), $cachedState );

			PhalanxShadowing::check($user->getName(), $blockData['id']);		
			wfProfileOut( __METHOD__ );
			return false;
		}

		PhalanxShadowing::check($user->getName(), 0);		
		
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
		$blocksData = Phalanx::getFromFilterShort( self::TYPE );
		$state = self::blockCheckInternal( $user, $blocksData, $text, true );
		if ( !$state ) {
			$abortError = wfMsg( 'phalanx-user-block-new-account' );
			return false;
		}
		// Check if email is blocked
		$emailBlocksData = Phalanx::getFromFilter( Phalanx::TYPE_EMAIL );
		$userEmail = $user->getEmail();
		if ( $userEmail !== '' ) {
			$result = Phalanx::findBlocked( $userEmail, $emailBlocksData, true );
			if ( $result['blocked'] ) {
				$abortError = wfMsg( 'phalanx-user-block-new-account' );
				return false;
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
