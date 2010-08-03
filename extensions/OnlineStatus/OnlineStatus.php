<?php

/**
 * Extension that adds a new toggle in user preferences to show if the user is
 * aviabled or not. See http://mediawiki.org/wiki/Extension:OnlineStatus for
 * more informations.
 * Require MediaWiki 1.11.0 to work.
 *
 * @addtogroup Extensions
 * @author Alexandre Emsenhuber
 * @license GPLv2 of greater
 */

// Add credit :)
$wgExtensionCredits['other'][] = array(
	'svn-date'       => '$LastChangedDate: 2008-09-19 20:33:16 +0200 (ptk, 19 wrz 2008) $',
	'svn-revision'   => '$LastChangedRevision: 41039 $',
	'name'           => 'OnlineStatus',
	'author'         => 'Alexandre Emsenhuber',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:OnlineStatus',
	'description'    => 'Add a preference to show if the user is currently present or not on the wiki',
	'descriptionmsg' => 'onlinestatus-desc',
);

// Configuration

/**
 * Allow the {{#anyuseronlinestatus:}} parser function ?
 */
$wgAllowAnyUserOnlineStatusFunction = true;

class OnlineStatus {

	static function init(){
		global $wgExtensionMessagesFiles, $wgExtensionFunctions, $wgHooks, $wgAjaxExportList;

		// Add messages file
		$wgExtensionMessagesFiles['OnlineStatus'] = dirname( __FILE__ ) . '/OnlineStatus.i18n.php';

		// Hooks for the Parser
		// Use ParserFirstCallInit if aviable
		if( defined( 'MW_SUPPORTS_PARSERFIRSTCALLINIT' ) )
			$wgHooks['ParserFirstCallInit'][] = 'OnlineStatus::ParserFirstCallInit';
		else
			$wgExtensionFunctions[] = 'OnlineStatus::Setup';

		// Magic words hooks
		$wgHooks['MagicWordwgVariableIDs'][] = 'OnlineStatus::MagicWordVariable';
		$wgHooks['LanguageGetMagic'][] = 'OnlineStatus::LanguageGetMagic';
		$wgHooks['ParserGetVariableValueSwitch'][] = 'OnlineStatus::ParserGetVariable';

		// Hooks for Special:Preferences
		$wgHooks['InitPreferencesForm'][] = 'OnlineStatus::InitPreferencesForm';
		$wgHooks['PreferencesUserInformationPanel'][] = 'OnlineStatus::PreferencesUserInformationPanel';
		$wgHooks['ResetPreferences'][] = 'OnlineStatus::ResetPreferences';
		$wgHooks['SavePreferences'][] = 'OnlineStatus::SavePreferences';

		// User hook
		$wgHooks['UserToggles'][] = 'OnlineStatus::UserToggles';
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
	 * Extension function
	 */
	static function Setup() {
		global $wgParser;
		self::ParserFirstCallInit( $wgParser );
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
	 * Hook function for LanguageGetMagic
	 * @todo maybe allow localisation
	 */
	static function LanguageGetMagic( &$magicWords, $langCode ) {
		$magicWords['onlinestatus_word'] = array( 1, 'ONLINESTATUS' );
		$magicWords['onlinestatus_word_raw'] = array( 1, 'RAWONLINESTATUS' );
		$magicWords['anyuseronlinestatus'] = array( 0, 'anyuseronlinestatus' );
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
	 * Hook function for SavePreferences
	 */
	static function SavePreferences( $prefs, $user, &$msg, $old = array() ){
		# We need to invalidate caches for these pages, maybe it would be good
		# to be done for subpages, but it would too expensive
		if( !is_array( $old ) || empty( $old ) ){
			# MediaWiki is < 1.13, at that time, $old param wasn't present
			# We can't check if the user changed the online toggle as it is
			# already saved :(
			$changed = true;
		} elseif( !isset( $old['online'] ) || !isset( $old['showonline'] ) )  {
			$changed = true;
		} else {
			$changed = !( $old['online'] == $user->mOptions['online']
				&& $old['showonline'] == $user->mOptions['showonline'] );
		}
		if( $changed ){
			$user->getUserPage()->invalidateCache();
			$user->getTalkPage()->invalidateCache();
		}
		return true;
	}

	/**
	 * Hook function for InitPreferencesForm
	 */
	static function InitPreferencesForm( $prefs, $request ) {
		$prefs->mToggles['online'] = $request->getVal( 'wpOnline' );
		$prefs->mToggles['showonline'] = $request->getCheck( 'wpOpShowOnline' ) ? 1 : 0;
		return true;
	}

	/**
	 * Hook function for ResetPreferences
	 */
	static function ResetPreferences( $prefs, $user ) {
		$prefs->mToggles['online'] = $user->getOption( 'online' );
		$prefs->mToggles['showonline'] = $user->getOption( 'showonline' );
		return true;
	}

	/**
	 * Hook function for PreferencesUserInformationPanel
	 */
	static function PreferencesUserInformationPanel( $prefsForm, &$html ) {
		wfLoadExtensionMessages( 'OnlineStatus' );
		$msg = wfMsgForContentNoTrans( 'onlinestatus-levels' );
		$lines = explode( "\n", $msg );
		$radios = array();
		foreach( $lines as $line ){
			if( substr( $line, 0, 1 ) != '*' )
				continue;
			$lev = trim( $line, '* ' );
			$radios[] = Xml::radioLabel(
				wfMsg( 'onlinestatus-toggle-' . $lev ),
				'wpOnline',
				$lev,
				'wpOnline-' . $lev,
				$lev == $prefsForm->mToggles['online']
			);
		}
		$out = "<ul>\n<li>";
		$out .= implode( "</li>\n<li>", $radios );
		$out .= "</li>\n</ul>";
		$html .= $prefsForm->tableRow(
			wfMsgExt( 'onlinestatus-toggles-desc', array( 'escapenoentities' ) ),
			$out .
			Xml::checkLabel( wfMsg( 'onlinestatus-toggles-show' ), 'wpOpShowOnline', 'wpOpShowOnline', (bool)$prefsForm->mToggles['showonline'] ) .
			wfMsgExt( 'onlinestatus-toggles-explain', array( 'parse' ) )
		);
		return true;
	}

	/**
	 * Hook for UserToggles
	 */
	static function UserToggles( &$toggles ){
		$toggles[] = 'onlineOnLogin';
		$toggles[] = 'offlineOnLogout';
		return true;	
	}

	/**
	 * Hook for UserLoginComplete
	 */
	static function UserLoginComplete( $user ){
		if( $user->getOption( 'offlineOnLogout' ) ){
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
		if( $oldUser->getOption( 'offlineOnLogout' ) ){
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
			global $wgScriptPath, $wgJsMimeType;
			$out->addScript( "<script type=\"{$wgJsMimeType}\" src=\"{$wgScriptPath}/extensions/OnlineStatus/OnlineStatus.js\"></script>" );
			$out->addLink( array(
				'rel' => 'stylesheet',
				'type' => 'text/css',
				'href' => "{$wgScriptPath}/extensions/OnlineStatus/OnlineStatus.css"
			) );
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