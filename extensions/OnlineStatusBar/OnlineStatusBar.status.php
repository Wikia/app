<?php
if ( !defined( 'MEDIAWIKI' ) ) {
		echo "This is a part of mediawiki and can't be started separately";
		die();
}

/**
 * File which contains status check for Online status bar extension.
 *
 * @file
 * @ingroup Extensions
 * @author Petr Bena <benapetr@gmail.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @link http://www.mediawiki.org/wiki/Extension:OnlineStatusBar Documentation
 */

class OnlineStatusBar_StatusCheck {
	/**
	 * Return cache key
	 * @param $user String
	 * @param $type String
	 */
	private static function getCacheKey( $user, $type ) {
		// get a key for cache
		return wfMemcKey( 'onlinestatusbar_cache', $type, $user );
	}

	/**
	 * Create a cache
	 * @param $user String
	 * @param $values String
	 * @param $type String
	 * @param $time Integer
	 * @return true
	 */
	private static function setCache( $user, $values, $type, $time = null ) {
		global $wgOnlineStatusBar_WriteTime, $wgMemc;
		// get a key
		$cache_key = self::getCacheKey( $user, $type );
		if ( $time === null ) {
			$time = $wgOnlineStatusBar_WriteTime;
		}
		$wgMemc->set( $cache_key, $values, $time );
		return true;
	}

	/**
	 * Return cache value
	 * @param $user string
	 * @param $type string
	 */
	private static function getCache( $user, $type ) {
		global $wgMemc;
		// get a key
		$cache_key = self::getCacheKey( $user, $type );
		// get a value
		return $wgMemc->get( $cache_key );
	}
	

	/**
	 * Status check
	 * @param $user User
	 * @param $delayed_check Boolean
	 * @return String
	 */
	public static function getStatus( $user, $delayed_check = false ) {
		global $wgOnlineStatusBarDefaultOffline, $wgOnlineStatusBarDefaultOnline;
		// instead of delete every time just select the records which are not that old
		if ( !$delayed_check ) {
			// first try to use cache
			$result = self::getCache( $user->getName(), ONLINESTATUSBAR_NORMAL_CACHE );
			
			if ( $result == '' ) {
				$t_time = OnlineStatusBar::getTimeoutDate();
				$dbr = wfGetDB( DB_SLAVE );
				$result = $dbr->selectField( 'online_status', 'timestamp', array( 'username' => $user->getName(),
					'timestamp > ' . $dbr->addQuotes( $dbr->timestamp( $t_time ) ) ),
					__METHOD__, array( 'LIMIT 1', 'ORDER BY timestamp DESC' ) );
				// cache it
				self::setCache( $user->getName(), $result, ONLINESTATUSBAR_NORMAL_CACHE );
			}
		} else {
			// checking only if we need to do write or not
			$result = self::getCache( $user->getName(), ONLINESTATUSBAR_DELAYED_CACHE );
			$w_time = OnlineStatusBar::getTimeoutDate( ONLINESTATUSBAR_CK_DELAYED );
			if ( $result == '' ) {
				$dbr = wfGetDB( DB_SLAVE );
				$result = $dbr->selectField( 'online_status', 'timestamp', array( 'username' => $user->getName() ),
					__METHOD__, array( 'LIMIT 1', 'ORDER BY timestamp DESC' ) );
				// cache it
				if ( $result !== false && $result > wfTimestamp( TS_MW, $w_time ) ) {
					self::setCache( $user->getName(), $result, ONLINESTATUSBAR_DELAYED_CACHE );
				}
			}
		}

		if ( $result === false ) {
			$status = $wgOnlineStatusBarDefaultOffline;
		} else {
			// let's check if it isn't anon
			if ( $user->isLoggedIn() ) {
				$status = $user->getOption( 'OnlineStatusBar_status', $wgOnlineStatusBarDefaultOnline );
				if ( $delayed_check ) {
					// check if it's old or not
					if ( $result < wfTimestamp( TS_MW, $w_time ) ) {
						$status = 'write';
					}
				} else if ( $user->getOption( 'OnlineStatusBar_away', true ) == true ) {
					if ( $result < wfTimestamp( TS_MW, OnlineStatusBar::getTimeoutDate( ONLINESTATUSBAR_CK_AWAY, $user ) ) ) {
						$status = 'away';
					}
				}
			} else {
				$status = $wgOnlineStatusBarDefaultOnline;
				if ( $delayed_check ) {
					if ( $result < wfTimestamp( TS_MW, $w_time ) ) {
						$status = 'write';
					}
				}
			}
		}

		if ( $status == 'hidden' && !($delayed_check) ) {
			$status = $wgOnlineStatusBarDefaultOffline;
		}

		return $status;
	}

	/**
	 * Insert to the database
	 * @return bool
	 */
	public static function updateDB() {
		global $wgUser;
		// Skip users we don't track
		if ( OnlineStatusBar::isValid ( $wgUser ) != true ) {
			return false;
		}
		// If we track them, let's insert it to the table
		$dbw = wfGetDB( DB_MASTER );
		$timestamp = $dbw->timestamp();
		$row = array(
			'username' => $wgUser->getName(),
			'timestamp' => $timestamp,
		);
		self::setCache( $wgUser->getName(), $timestamp, ONLINESTATUSBAR_NORMAL_CACHE );
		$dbw->insert( 'online_status', $row, __METHOD__ );
		return false;
	}

	 /**
	  * Delete user who logged out
	  * @param $userName string
	  * @return bool
	  */
	static function deleteStatus( $userName ) {
		$dbw = wfGetDB( DB_MASTER );
		$dbw->delete( 'online_status', array( 'username' => $userName ), __METHOD__ ); // delete user
		// remove from cache
		self::setCache( $userName, '', ONLINESTATUSBAR_NORMAL_CACHE );
		self::setCache( $userName, '', ONLINESTATUSBAR_DELAYED_CACHE );
		return true;
	}

	 /**
	  * Update status of user
	  * @return bool
	  */
	public static function updateStatus() {
		global $wgUser, $wgOnlineStatusBarDefaultOffline;
		// if anon users are not tracked and user is anon leave it
		if (!OnlineStatusBar::isValid( $wgUser )) {
			return false;
		}
		$user_status = self::getStatus( $wgUser, true );
		if ( $user_status == $wgOnlineStatusBarDefaultOffline ) {
			self::updateDB();
			return true;
		}

		if ( $user_status == 'write' ) {
			$dbw = wfGetDB( DB_MASTER );
			$timestamp = $dbw->timestamp();
			$dbw->update(
				'online_status',
				array( 'timestamp' => $timestamp ),
				array( 'username' => $wgUser->getName() ),
				__METHOD__
			);
			self::setCache( $wgUser->getName(), $timestamp, ONLINESTATUSBAR_NORMAL_CACHE );
			self::deleteOld();
		}
		return true;
	}

	/**
	 * Delete old records from the table, this function is called frequently to keep the table as small as possible
	 * it's also possible to disable this function to set automatic job in cron to do that
	 * @return int
	 */
	public static function deleteOld() {
		global $wgOnlineStatusBarAutoDelete;
		if ( !$wgOnlineStatusBarAutoDelete ) {
			return 0;
		}
		if ( self::getCache( 'null', 'delete' ) == 'true' ) {
			return 0;
		}
		// Check if we actually need to delete something before we write to master
		$dbr = wfGetDB( DB_SLAVE );
		$time = OnlineStatusBar::getTimeoutDate();
		$result = $dbr->selectField( 'online_status', 'timestamp', array( 'timestamp < ' . $dbr->addQuotes( $dbr->timestamp( $time ) ) ),
			__METHOD__, array( 'LIMIT 1' ) );
		if ( $result === false ) {
			// no need for delete
			return 0;
		}

		// calculate time and convert it back to mediawiki format
		$dbw = wfGetDB( DB_MASTER );
		$dbw->delete( 'online_status', array( 'timestamp < ' . $dbw->addQuotes( $dbw->timestamp( $time ) ) ), __METHOD__ );
		self::setCache( 'null', 'true', 'delete', 3600 ); // remember we deleted it for 1 hour so that we avoid calling this too many times
		return 0;
	}
}
