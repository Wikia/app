<?php
if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This is a part of mediawiki and can't be started separately";
	die();
}

/**
 * Main file of Online status bar extension.
 *
 * @file
 * @ingroup Extensions
 * @author Petr Bena <benapetr@gmail.com>
 * @author of magic word Alexandre Emsenhuber
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @link http://www.mediawiki.org/wiki/Extension:OnlineStatusBar Documentation
 */

class OnlineStatusBar {
	/**
	 * Create a html bar
	 * return HTML
	 **/
	public static function getStatusBarHtml() {
		return <<<HTML
<div class="onlinestatusbarbody metadata onlinestatusbartop" id="status-top">
<div class="onlinestatusbaricon">
</div></div>
HTML;
	}

	/**
	 * Returns image element
	 *
	 * @param $mode String
	 * @param $mode_text String
	 * @return string
	 */
	public static function GetImageHtml( $mode, $mode_text ) {
		global $wgExtensionAssetsPath, $wgOnlineStatusBarIcon;
		$icon = "$wgExtensionAssetsPath/OnlineStatusBar/{$wgOnlineStatusBarIcon[$mode]}";
		return Html::element( 'img', array( 'src' => $icon, 'alt' => $mode_text ) );
	}

	/**
	 * @param Title $title
	 */
	public static function getAnonFromTitle( Title $title ) {
		global $wgOnlineStatusBarTrackIpUsers;
		if ( $wgOnlineStatusBarTrackIpUsers == false ) {
			return false;
		}
		$user = User::newFromId( 0 );
		$user->setName( $title->getBaseText() );
	
		if (!($user instanceof User)) {
			return false;
		}
	
		return $user;
	}

	/**
	 * Returns the status and User element
	 *
	 * @param string $username a user
	 * @return array|bool Array containing the status and User object
         */
	public static function getAnonFromString( $username ) {
		global $wgOnlineStatusBarTrackIpUsers;
		// if user is anon and we don't track them stop
		if ( $wgOnlineStatusBarTrackIpUsers == false ) {
			return false;
		}

		// we need to create temporary user object
		$user = User::newFromId( 0 );
		$user->setName( $username );

		// Check if something wrong didn't happen
		if ( !($user instanceof User) ) {
			return false;
		}

		$status = OnlineStatusBar_StatusCheck::getStatus( $user );

		return array( $status, $user );
	}

	/**
	 * @param $title Title
	 * @return array
	 */
	public static function getUserInfoFromTitle( Title $title ) {
		$user = User::newFromName( $title->getBaseText() );
		// check
		if (!($user instanceof User)) {
			return false;
		}
		if ( !self::isValid($user)) {
			return false;
		}

		return $user;
	}

	/**
	 * Returns the status and User element
	 *
	 * @param string $username name of user
	 * @return array|bool Array containing the status and User object
	 */
	public static function getUserInfoFromString( $username ) {
		// We create an user object using name of user parsed from title
		$user = User::newFromName( $username );
		// Invalid user
		if ( !($user instanceof User) ) {
			return false;
		}
		if ( !self::isValid( $user ) ) {
			return false;
		}

		$status = OnlineStatusBar_StatusCheck::getStatus( $user );

		return array( $status, $user );
	}

	/**
	 * Purge page
	 * @return bool
	 *
	 */
	public static function purge( $user_type ) {
		// First of all we need to know if we already have user object or just a name
		// if so let's create new object
		if (  $user_type instanceof User  ) {
			$user = $user_type;
		} elseif ( is_string( $user_type ) ){
			$user = User::newFromName( $user_type );
		} else {
			return false;
		}

		// check if something weird didn't happen
		if ( $user instanceof User ) {
			// purge both pages now
			if ( $user->getOption('OnlineStatusBar_active', false) ) {
				if ( $user->getOption('OnlineStatusBar_autoupdate', false) == true ) {
					WikiPage::factory( $user->getUserPage() )->doPurge();
					WikiPage::factory( $user->getTalkPage() )->doPurge();
				}
			}
		}
		return true;
	}


	/**
	 * @param $delayed
	 * @param $away
	 * @param $user
	 * @return timestamp
	 */
	public static function getTimeoutDate( $checkType = false, $user = false ) {
		global $wgOnlineStatusBar_AwayTime, $wgOnlineStatusBar_WriteTime, $wgOnlineStatusBar_LogoutTime;

		if ($checkType != false) {
			switch($checkType) {
				case ONLINESTATUSBAR_CK_DELAYED:
					return wfTimestamp( TS_UNIX ) - $wgOnlineStatusBar_WriteTime;
				case ONLINESTATUSBAR_CK_AWAY:
					if ( $user === false ) {
						$time = $wgOnlineStatusBar_AwayTime;
					} else {
						$time = $user->getOption( 'OnlineStatusBar_awaytime', $wgOnlineStatusBar_AwayTime );
					}	
					return wfTimestamp( TS_UNIX ) - ( $time * 60 );
			}
		}
		return wfTimestamp( TS_UNIX ) - $wgOnlineStatusBar_LogoutTime;
	}

	/**
	 * Checks to see if the user can be tracked
	 *
	 * @param User $user
	 * @return bool
	 */
	public static function isValid( User $user ) {
		global $wgOnlineStatusBarTrackIpUsers, $wgOnlineStatusBarDefaultEnabled;

		// checks if anon
		if ( $user->isAnon() ) {
			return $wgOnlineStatusBarTrackIpUsers;
		}

		// do we track them
		return $user->getOption( 'OnlineStatusBar_active', $wgOnlineStatusBarDefaultEnabled );
	}
}
