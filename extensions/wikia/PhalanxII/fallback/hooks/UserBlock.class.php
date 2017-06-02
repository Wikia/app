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
 * @author Piotr Molski <moli@wikia-inc.com>
 * @date 2013-01-16
 */

class UserBlock {
	const TYPE = PhalanxFallback::TYPE_USER;
	const CACHE_KEY = 'user-status';

	protected static function blockCheckInternal( User $user, $blocksData, $text, &$block, $writeStats = true ) {
		global $wgMemc;
		wfProfileIn( __METHOD__ );

		$blockData = null;
		$result = PhalanxFallback::findBlocked( $text, $blocksData, $writeStats, $blockData );

		if ( $result['blocked'] ) {
			Wikia::log( __METHOD__, __LINE__, "Block '{$result['msg']}' blocked '$text'." );
			# self::setUserData( $user, $blockData, $text, false );

			# set block
			$block = ( object ) $blockData;

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

	protected static function getCacheKey( User $user ) {
		return wfSharedMemcKey( 'phalanx', self::CACHE_KEY, $user->getTitleKey() );
	}

	/**
	 * Format the message with user block reason. If additional description was provided when creating that block,
	 * it's included in the message.
	 *
	 * @param String $reason Optional reason that came with the block
	 * @param bool $isExact Set to true for exact block
	 * @param bool $isBlockIP Set to true for IP blocks
	 * @return String Translated message with optional reason details
	 */
	public static function getBlockReasonMessage( $reason, $isExact, $isBlockIP ) {
		if ( $reason ) {
			// a reason was given
			if ( $isExact ) {
				$result = wfMsg( 'phalanx-user-block-withreason-exact', $reason );
			} elseif ( $isBlockIP ) {
				$result = wfMsg( 'phalanx-user-block-withreason-ip', $reason );
			} else {
				$result = wfMsg( 'phalanx-user-block-withreason-similar', $reason );
			}
		} else {
			// no reason in block data, so use preexisting no-param worded versions
			if ( $isExact ) {
				$result = wfMsg( 'phalanx-user-block-reason-exact' );
			} elseif ( $isBlockIP ) {
				$result = wfMsg( 'phalanx-user-block-reason-ip' );
			} else {
				$result = wfMsg( 'phalanx-user-block-reason-similar' );
			}
		}
		return $result;
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
	public static function onAbortNewAccount( $user, &$abortError, &$block ) {
		$text = $user->getName();
		$blocksData = PhalanxFallback::getFromFilterShort( self::TYPE );
		$state = self::blockCheckInternal( $user, $blocksData, $text, $block, true );
		if ( !$state ) {
			$abortError = wfMsg( 'phalanx-user-block-new-account' );
			return false;
		}
		// Check if email is blocked
		$emailBlocksData = PhalanxFallback::getFromFilter( PhalanxFallback::TYPE_EMAIL );
		$userEmail = $user->getEmail();
		if ( $userEmail !== '' ) {
			$blockData = null;
			$result = PhalanxFallback::findBlocked( $userEmail, $emailBlocksData, true, $blockData );
			if ( $result['blocked'] ) {
				$block = ( object ) $blockData;
				$abortError = wfMsg( 'phalanx-user-block-new-account' );
				return false;
			}
		}
		return true;
	}
}
