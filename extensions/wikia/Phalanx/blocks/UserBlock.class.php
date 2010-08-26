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
		global $wgUser;
		wfProfileIn( __METHOD__ );

		// RT#42011: RegexBlock records strange results
		// don't write stats for other user than viewing user
		$writeStats = $user->getName() == $wgUser->getName();

		$text = $user->getName();
		$blocksData = Phalanx::getFromFilter( Phalanx::TYPE_USER );
		$ret = true;

		if ( !empty($blocksData) && !empty($text) ) {
			if ( $user->isAnon() ) {
				$ret =  self::blockCheckInternal( $user, $blocksData, $text, true, $writeStats );
			} else {
				$ret = self::blockCheckInternal( $user, $blocksData, $text, false, $writeStats );
				if ( $ret ) {
					// if the user name was not blocked, check for an IP block
					$ret = self::blockCheckInternal( $user, $blocksData, wfGetIP(), true );
				}
			}
		}

		wfProfileOut( __METHOD__ );
		return $ret;
	}

	private static function blockCheckInternal( &$user, $blocksData, $text, $isBlockIP = false, $writeStats = true ) {
		wfProfileIn( __METHOD__ );

		foreach ($blocksData as $blockData) {
			if ( $isBlockIP && !$user->isIP($blockData['text'])) {
				continue;
			}

			$result = Phalanx::isBlocked( $text, $blockData, $writeStats );

			if ( $result['blocked'] ) {
				Wikia::log(__METHOD__, __LINE__, "Block '{$result['msg']}' blocked '$text'.");
				self::setUserData( $user, $blockData, $text, $isBlockIP );
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
