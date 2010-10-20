<?php

/**
 * UserBlock
 *
 * This filter blocks a user (exactly the same as a local MediaWiki block),
 * if the user's name matches one of the blacklisted phrases or IPs.
 *
 * @author Marooned <marooned at wikia-inc.com>
 * @date 2010-06-09
 */

class UserBlock {
	public static function blockCheck(&$user) {
		global $wgUser, $wgMemc;
		wfProfileIn( __METHOD__ );

		$ret = true;

		// RT#42011: RegexBlock records strange results
		// don't write stats for other user than visiting user
		$isCurrentUser = $user->getName() == $wgUser->getName();

		// check cache first before proceeeding
		$cacheKey = wfSharedMemcKey( 'phalanx', 'user-status', $user->getID() );
		$cachedState = $wgMemc->get( $cacheKey );
		if ( !empty( $cachedState ) && $cachedState['timestamp'] > Phalanx::getLastUpdate() ) {
			if ( !$cachedState['return'] && $isCurrentUser ) {
				self::setUserData( $user, $cachedSate['block'], $text, $user->isAnon(), $isCurrentUser );
			}

			return $cachedState['return'];
		}

		$text = $user->getName();
		$blocksData = Phalanx::getFromFilter( Phalanx::TYPE_USER );

		if ( !empty($blocksData) && !empty($text) ) {
			if ( $user->isAnon() ) {
				$ret =  self::blockCheckInternal( $user, $blocksData, $text, true, $isCurrentUser );
			} else {
				$ret = self::blockCheckInternal( $user, $blocksData, $text, false, $isCurrentUser );
				//do not check IP for current user when checking block status of different user
				if ( $ret && $isCurrentUser ) {
					// if the user name was not blocked, check for an IP block
					$ret = self::blockCheckInternal( $user, $blocksData, wfGetIP(), true, $isCurrentUser );
				}
			}
		}

		// populate cache if not done before
		if ( $ret ) {
			$chachedState = array(
				'timestamp' => wfTimestampNow(),
				'block' => false,
				'return' => $ret,
			);
			$wgMemc->set( $cacheKey, $cachedState );
		}

		wfProfileOut( __METHOD__ );
		return $ret;
	}

	private static function blockCheckInternal( &$user, $blocksData, $text, $isBlockIP = false, $writeStats = true ) {
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

				$cacheKey = wfSharedMemcKey( 'phalanx', 'user-status', $user->getID() );
				$chachedState = array(
					'timestamp' => wfTimestampNow(),
					'block' => $blockData,
					'return' => false,
				);
				$wgMemc->set( $cacheKey, $cachedState );
				
				wfProfileOut( __METHOD__ );
				return false;
			}
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	//moved from RegexBlockCore.php
	private static function setUserData(&$user, $blockData, $address, $isBlockIP = false) {
		wfProfileIn( __METHOD__ );

		wfLoadExtensionMessages( 'Phalanx' );

		$user->mBlockedby = $blockData['author_id'];

		if ($blockData['reason']) {
			// a reason was given, display it
			$user->mBlockreason = $blockData['reason'];
		} else {
			// display generic reasons
			if ($blockData['exact']) {
				$user->mBlockreason = wfMsg('phalanx-user-block-reason-exact');
			} elseif ($isBlockIP) {
				$user->mBlockreason = wfMsg('phalanx-user-block-reason-ip');
			} else {
				$user->mBlockreason = wfMsg('phalanx-user-block-reason-similar');
			}
		}

		// set expiry information
		if ($user->mBlock) {
			$user->mBlock->mId = $blockData['id'];
			$user->mBlock->mExpiry = is_null($blockData['expire']) ? 'infinity' : $blockData['expire'];
			$user->mBlock->mTimestamp = $blockData['timestamp'];
			$user->mBlock->mAddress = $address;

			// account creation check goes through the same hook...
			if ($isBlockIP) {
				$user->mBlock->mCreateAccount = 1;
			}
		}

		wfProfileOut( __METHOD__ );
	}
}
