<?php

/**
 * Extension that adds a new toggle in user preferences to show if the user is
 * aviabled or not. See http://mediawiki.org/wiki/Extension:OnlineStatus for
 * more informations.
 * Require MediaWiki 1.16 alpha r52503 or higher to work.
 *
 * @addtogroup Extensions
 * @author Alexandre Emsenhuber
 * @license GPLv2 of greater
 */

// Add credit :)
$wgExtensionCredits['other'][] = array(
	'path'           => __FILE__,
	'name'           => 'OnlineStatus',
	'author'         => 'Alexandre Emsenhuber',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:OnlineStatus',
	'version'        => '2009-08-22',
	'description'    => 'Add a preference to show if the user is currently present or not on the wiki',
	'descriptionmsg' => 'onlinestatus-desc',
);

// Configuration

/**
 * Allow the {{#anyuseronlinestatus:}} parser function ?
 */
$wgAllowAnyUserOnlineStatusFunction = true;

/**
 * New preferences for this extension
 */
$wgDefaultUserOptions['online'] = 'online';
$wgDefaultUserOptions['showonline'] = 0;
$wgDefaultUserOptions['onlineonlogin'] = 1;
$wgDefaultUserOptions['offlineonlogout'] = 1;

// Add messages files
$wgExtensionMessagesFiles['OnlineStatus'] = dirname( __FILE__ ) . '/OnlineStatus.i18n.php';
$wgExtensionMessagesFiles['OnlineStatusMagic'] = dirname( __FILE__ ) . '/OnlineStatus.i18n.magic.php';

// FIXME: Should be a separate class file
class OnlineStatus {
	// FIXME: Can't this just be in the core bit instead of the class? The init() will not have to be called
	static function init(){
		global $wgExtensionFunctions, $wgHooks, $wgAjaxExportList;

		// Hooks for the Parser
		$wgHooks['ParserFirstCallInit'][] = 'OnlineStatus::ParserFirstCallInit';

		// Magic words hooks
		$wgHooks['MagicWordwgVariableIDs'][] = 'OnlineStatus::MagicWordVariable';
		$wgHooks['ParserGetVariableValueSwitch'][] = 'OnlineStatus::ParserGetVariable';

		// Hooks for Special:Preferences
		$wgHooks['GetPreferences'][] = 'OnlineStatus::GetPreferences';

		// User hook
		$wgHooks['UserLoginComplete'][] = 'OnlineStatus::UserLoginComplete';
		$wgHooks['UserLogoutComplete'][] = 'OnlineStatus::UserLogoutComplete';

		// User page
		$wgHooks['BeforePageDisplay'][] = 'OnlineStatus::BeforePageDisplay';
		$wgHooks['PersonalUrls'][] = 'OnlineStatus::PersonalUrls';

		// Ajax stuff
		$wgAjaxExportList[] = 'OnlineStatus::Ajax';
	}

	/**
	 * Get the user online status
	 *
	 * @param mixed $title string of Title object, if it's a title, if have to be in
	 *                     User: of User_talk: namespace.
	 * @return either bool or null
	 */
	static function GetUserStatus( $title, $checkShowPref = false ){
		if( is_object( $title ) ){
			if( !$title instanceof Title )
				return null;
			if( !in_array( $title->getNamespace(), array( NS_USER, NS_USER_TALK ) ) )
				return null;
			$username = explode( '/', $title->getDBkey() );
			$username = $username[0];
		} else {
			$username = $title;
		}
		$user = User::newFromName( $username );
		if( !$user instanceof User || $user->getId() == 0 )
			return null;
		if( $checkShowPref && !$user->getOption( 'showonline' ) )
			return null;
		return $user->getOption( 'online' );
	}

	/**
	 * Used for ajax requests
	 */
	static function Ajax( $action, $stat = false ){
		global $wgUser;
		wfLoadExtensionMessages( 'OnlineStatus' );

		if( $wgUser->isAnon() )
			return wfMsgHtml( 'onlinestatus-js-anon' );

		switch( $action ){
		case 'get':
			$def = $wgUser->getOption( 'online' );
			$msg = wfMsgForContentNoTrans( 'onlinestatus-levels' );
			$lines = explode( "\n", $msg );
			$radios = array();
			foreach( $lines as $line ){
				if( substr( $line, 0, 1 ) != '*' )
					continue;
				$lev = trim( $line, '* ' );
				$radios[] = array(
					$lev,
					wfMsg( 'onlinestatus-toggle-' . $lev ),
					$lev == $def
				);
			}
			return json_encode( $radios );
		case 'set':
			if( $stat ){
				$dbw = wfGetDB( DB_MASTER );
				$dbw->begin();
				$actual = $wgUser->getOption( 'online' );
				$wgUser->setOption( 'online', $stat );
				if( $actual != $stat ){
					$wgUser->getUserPage()->invalidateCache();
					$wgUser->getTalkPage()->invalidateCache();
				}
				$wgUser->saveSettings();
				$wgUser->invalidateCache();
				$dbw->commit();
				return wfMsgHtml( 'onlinestatus-js-changed', wfMsgHtml( 'onlinestatus-toggle-'.$stat ) );
			} else {
				return wfMsgHtml( 'onlinestatus-js-error', $stat );
			}
		}
	}

	/**
	 * Hook for ParserFirstCallInit
	 */
	static function ParserFirstCallInit( $parser ){
		global $wgAllowAnyUserOnlineStatusFunction;
		if( $wgAllowAnyUserOnlineStatusFunction )
			$parser->setFunctionHook( 'anyuseronlinestatus', array( __CLASS__, 'ParserHookCallback' ) );
		return true;
	}

	/**
	 * Callback for {{#anyuserstatus:}}
	 */
	static function ParserHookCallback( &$parser, $user, $raw = false ){
		$status = self::GetUserStatus( $user );
		if( $status === null )
			return array( 'found' => false );
		if( empty( $raw ) ){
			wfLoadExtensionMessages( 'OnlineStatus' );
			return wfMsgNoTrans( 'onlinestatus-toggle-' . $status );
		} else {
			return $status;
		}
	}

	/**
	 * Hook function for MagicWordwgVariableIDs
	 */
	static function MagicWordVariable( &$magicWords ) {
		$magicWords[] = 'onlinestatus_word';
		$magicWords[] = 'onlinestatus_word_raw';
		return true;
	}

	/**
	 * Hook function for ParserGetVariableValueSwitch
	 */
	static function ParserGetVariable( &$parser, &$varCache, &$index, &$ret ){
		if( $index == 'onlinestatus_word' ){
			$status = self::GetUserStatus( $parser->getTitle() );
			if( $status === null )
				return true;
			wfLoadExtensionMessages( 'OnlineStatus' );
			$ret = wfMsgNoTrans( 'onlinestatus-toggle-' . $status );
			$varCache['onlinestatus'] = $ret;
		} else if( $index == 'onlinestatus_word_raw' ){
			$status = self::GetUserStatus( $parser->getTitle() );
			if( $status === null )
				return true;
			$ret = $status;
			$varCache['onlinestatus'] = $ret;
		}
		return true;
	}

	/**
	 * Hook for user preferences
	 */
	public static function GetPreferences( $user, &$preferences ) {
		wfLoadExtensionMessages( 'OnlineStatus' );

		$msg = wfMsgForContentNoTrans( 'onlinestatus-levels' );
		$lines = explode( "\n", $msg );
		$radios = array();
		foreach( $lines as $line ){
			if( substr( $line, 0, 1 ) != '*' )
				continue;
			$lev = trim( $line, '* ' );
			$radios[wfMsg( 'onlinestatus-toggle-' . $lev )] = $lev;
		}

		$preferences['onlineonlogin'] =
			array(
				'type' => 'toggle',
				'section' => 'misc',
				'label-message' => 'onlinestatus-pref-onlineonlogin',
			);

		$preferences['offlineonlogout'] =
			array(
				'type' => 'toggle',
				'section' => 'misc',
				'label-message' => 'onlinestatus-pref-offlineonlogout',
			);

		$prefs = array(
			'online' => array(
				'type' => 'radio',
				'section' => 'personal/info',
				'options' => $radios,
				'label-message' => 'onlinestatus-toggles-desc',
			),
			'showonline' => array(
				'type' => 'check',
				'section' => 'personal/info',
				'label-message' => 'onlinestatus-toggles-show',
				'help-message' => 'onlinestatus-toggles-explain',
			)
		);

		$after = array_key_exists( 'registrationdate', $preferences ) ? 'registrationdate' : 'editcount';
		$preferences = wfArrayInsertAfter( $preferences, $prefs, $after );

		return true;
	}

	/**
	 * Hook for UserLoginComplete
	 */
	static function UserLoginComplete( $user ){
		if( $user->getOption( 'onlineonlogin' ) ){
			$user->setOption( 'online', 'online' );
			$user->saveSettings();
		}
		return true;
	}

	/**
	 * Hook for UserLoginComplete
	 */
	static function UserLogoutComplete( &$newUser, &$injected_html, $oldName = null ){
		if( $oldName === null )
			return true;
		$oldUser = User::newFromName( $oldName );
		if( !$oldUser instanceof User )
			return true;
		if( $oldUser->getOption( 'offlineonlogout' ) ){
			$oldUser->setOption( 'online', 'offline' );
			$oldUser->saveSettings();
		}
		return true;
	}

	/**
	 * Hook function for BeforePageDisplay
	 */
	static function BeforePageDisplay( &$out ){
		global $wgTitle, $wgRequest, $wgUser;
		global $wgUseAjax;

		if( $wgUser->isLoggedIn() && $wgUseAjax ){
			global $wgScriptPath;
			$out->addScriptFile( "{$wgScriptPath}/extensions/OnlineStatus/OnlineStatus.js" );
			$out->addExtensionStyle( "{$wgScriptPath}/extensions/OnlineStatus/OnlineStatus.css" );
		}

		if( !in_array( $wgRequest->getVal( 'action', 'view' ), array( 'view', 'purge' ) ) )
			return true;
		$status = self::GetUserStatus( $wgTitle, true );
		if( $status === null )
			return true;
		wfLoadExtensionMessages( 'OnlineStatus' );
		$out->setSubtitle( wfMsgExt( 'onlinestatus-subtitle-' . $status, array( 'parse' ) ) );

		return true;
	}

	/**
	 * Hook for PersonalUrls
	 */
	static function PersonalUrls( &$urls, &$title ){
		global $wgUser, $wgUseAjax;
		# Require ajax
		if( !$wgUser->isLoggedIn() || !$wgUseAjax || $title->isSpecial( 'Preferences' ) )
			return true;
		$arr = array();
		foreach( $urls as $key => $val ){
			if( $key == 'logout' ){
				wfLoadExtensionMessages( 'OnlineStatus' );
				$arr['status'] = array(
					'text' => wfMsgHtml( 'onlinestatus-tab' ),
					'href' => 'javascript:;',
					'active' => false,
				);
			}
			$arr[$key] = $val;
		}
		$urls = $arr;
		return true;
	}
}

OnlineStatus::init();
