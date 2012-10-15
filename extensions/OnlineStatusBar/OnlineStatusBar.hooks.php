<?php
if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This is a part of mediawiki and can't be started separately";
	die();
}

/**
 * Hooks for OnlineStatusBar
 *
 * @group Extensions
 */
class OnlineStatusBarHooks {
	/**
	 * @param DatabaseUpdater|null $updater
	 * @return bool
	 */
	public static function ckSchema( $updater = null ) {
		if ( $updater !== null ) {
			$updater->addExtensionUpdate( array( 'addtable', 'online_status', dirname( __FILE__ ) . '/OnlineStatusBar.sql', true ) );
		} else {
			global $wgExtNewTables;
			$wgExtNewTables[] = array(
				'online_status', dirname( __FILE__ ) . '/OnlineStatusBar.sql' );
		}
		return true;
	}

	/**
	 * Called everytime when user logout
	 * @param $user User
	 * @return true
	 */
	public static function logout( &$user ) {
		global $wgOnlineStatusBarDefaultEnabled;
		// check if user had enabled this feature before we write to db
		if ( $user->getOption( 'OnlineStatusBar_active', $wgOnlineStatusBarDefaultEnabled ) ) {
			$userName = $user->getName();
			OnlineStatusBar_StatusCheck::deleteStatus( $userName );
			OnlineStatusBar::purge( $userName );
		}
		return true;
	}

	/**
	 * Called everytime on login
	 * @return bool
	 */
	public static function updateStatus() {
		global $wgUser;
		if (OnlineStatusBar::isValid( $wgUser )) {
			// Update status
			OnlineStatusBar_StatusCheck::updateStatus();
			// Purge user page (optional)
			OnlineStatusBar::purge( $wgUser );
		}
		return true;
	}

	/**
	 * Creates a bar
	 * @param $article Article
	 * @param $outputDone bool
	 * @param $pcache string
	 * @return bool
	 */
	public static function renderBar( &$article, &$outputDone, &$pcache ) {
		global $wgOnlineStatusBarCacheTime;
		// Update status of all users who wants to be tracked
		OnlineStatusBar_StatusCheck::updateStatus();

		// Performace fix
		$title = $article->getTitle();
		if ( $title->getNamespace() != NS_USER && $title->getNamespace() != NS_USER_TALK ) {
			return true;
		}

		// Retrieve status of user parsed from title
		$result = OnlineStatusBar::getUserInfoFromTitle( $title );
		// In case that status can't be parsed we check if it isn't anon
		if ( $result === false && User::isIP ( $title->getBaseText() ) ) {
			$result = OnlineStatusBar::getAnonFromTitle( $title );
		}

		// In case we were unable to get a status let's quit
		if ( $result === false ) {
			return true;
		}

		// Don't display status of those who don't want to show bar but only use magic
		if ( $result->getOption( 'OnlineStatusBar_hide', false ) == true ) {
			return true;
		}
		$context = $article->getContext();
		$context->getOutput()->addHtml( OnlineStatusBar::getStatusBarHtml() );

		return true;
	}

	/**
	 * Insert user options
	 * @param $user User
	 * @param $preferences array
	 * @return bool
	 */
	public static function preferencesHook( User $user, array &$preferences ) {
		global $wgOnlineStatusBarDefaultOnline, $wgOnlineStatusBarDefaultEnabled, $wgOnlineStatusBar_AwayTime, $wgOnlineStatusBar_LogoutTime, $wgOnlineStatusBarModes;
		$preferences['OnlineStatusBar_active'] = array( 'type' => 'toggle', 'label-message' => 'onlinestatusbar-used', 'section' => 'misc/onlinestatus' );
		$preferences['OnlineStatusBar_hide'] = array( 'type' => 'toggle', 'label-message' => 'onlinestatusbar-hide', 'section' => 'misc/onlinestatus' );
		$preferences['OnlineStatusBar_away'] = array( 'type' => 'toggle', 'label-message' => 'onlinestatusbar-away', 'section' => 'misc/onlinestatus' );
		$preferences['OnlineStatusBar_autoupdate'] = array( 'type' => 'toggle', 'label-message' => 'onlinestatusbar-purge', 'section' => 'misc/onlinestatus' );
		$preferences['OnlineStatusBar_status'] = array( 'type' => 'radio', 'label-message' => 'onlinestatusbar-status', 'section' => 'misc/onlinestatus',
			'options' => array(
				wfMessage( 'onlinestatusbar-status-online' )->escaped() => 'online',
				wfMessage( 'onlinestatusbar-status-busy' )->escaped() => 'busy',
				wfMessage( 'onlinestatusbar-status-away' )->escaped() => 'away',
				wfMessage( 'onlinestatusbar-status-hidden' )->escaped() => 'hidden'
			),
		);
		$preferences['OnlineStatusBar_awaytime'] = array( 'min' => 2, 'max' => $wgOnlineStatusBar_LogoutTime, 'type' => 'int', 'label-message' => 'onlinestatusbar-away-time', 'section' => 'misc/onlinestatus' );
		return true;
	}

	/**
	 * @param $defaultOptions array
	 * @return bool
	 */
	public static function setDefaultOptions( &$defaultOptions ) {
		global $wgOnlineStatusBar_AwayTime, $wgOnlineStatusBarDefaultOnline ,$wgOnlineStatusBarDefaultEnabled;
		// set defaults
		$defaultOptions['OnlineStatusBar_autoupdate'] = false;
		$defaultOptions['OnlineStatusBar_status'] = $wgOnlineStatusBarDefaultOnline;
		$defaultOptions['OnlineStatusBar_away'] = true;
		$defaultOptions['OnlineStatusBar_active'] = $wgOnlineStatusBarDefaultEnabled;
		$defaultOptions['OnlineStatusBar_hide'] = false;
		$defaultOptions['OnlineStatusBar_awaytime'] = $wgOnlineStatusBar_AwayTime;
		// quit
		return true;
	}

	/**
	 * @param $out OutputPage
	 * @param $skin Skin
	 * @return bool
	 */
	public static function stylePage( &$out, &$skin ) {
		$out->addModules( 'ext.OnlineStatusBar' );
		return true;
	}

	/**
	 * @param $vars array
	 * @return bool
	 */
	public static function magicWordSet( &$vars ) {
		$vars[] = 'ISONLINE';
		return true;
	}

	/**
	 * @param $parser Parser
	 * @param $varCache ??
	 * @param $index ??
	 * @param $ret string?
	 * @return bool
	 */
	public static function parserGetVariable( &$parser, &$varCache, &$index, &$ret ) {
		global $wgOnlineStatusBarCacheTime;
		if ( $index != 'ISONLINE' ) {
			return true;
		}

		// get a status of user parsed from title
		$result = OnlineStatusBar::getUserInfoFromString( $parser->getTitle()->getBaseText() );
		// if user is IP and we track them
		if ( User::isIP( $parser->getTitle()->getBaseText() ) && $result === false ) {
			$result = OnlineStatusBar::getAnonFromString( $parser->getTitle()->getBaseText() );
		}
		
		if ( $result === false ) {
			$ret = 'unknown';
			return true;
		}

		// if user is tracked we need to remove parser cache so that page update when status change
		if ( $result !== false  ) {
			$parser->getOutput()->updateCacheExpiry($wgOnlineStatusBarCacheTime[$result[0]] * 60);
		}

		$ret = $result[0];
		return true;
	}
}
