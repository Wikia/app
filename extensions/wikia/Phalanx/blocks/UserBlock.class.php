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
		wfProfileIn( __METHOD__ );

		$text = $user->getName();
		$blocksData = Phalanx::getFromFilter( Phalanx::TYPE_USER );

		if ( !empty($blocksData) && !empty($text) ) {
			foreach ($blocksData as $blockData) {
				$result = Phalanx::isBlocked( $text, $blockData );
				if ( $result['blocked'] ) {
					Wikia::log(__METHOD__, __LINE__, "Block '{$result['msg']}' blocked '$text'.");
					self::setUserData( $user, $blockData, $text );
					wfProfileOut( __METHOD__ );
					return false;
				}
			}

			//no user name matched - check IP address
			$userIP = wfGetIP();
			foreach ($blocksData as $blockData) {
				if (!$user->isIP($blockData['text'])) {
					continue;
				}
				$result = Phalanx::isBlocked( $userIP, $blockData );
				if ( $result['blocked'] ) {
					Wikia::log(__METHOD__, __LINE__, "Block '{$result['msg']}' blocked '$text'.");
					self::setUserData( $user, $blockData, $userIP, true );
					wfProfileOut( __METHOD__ );
					return false;
				}
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
