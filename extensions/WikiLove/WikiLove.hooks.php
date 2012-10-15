<?php
/**
 * Hooks for WikiLove extension
 *
 * @file
 * @ingroup Extensions
 */

class WikiLoveHooks {
	private static $recipient = '';

	/**
	 * LoadExtensionSchemaUpdates hook
	 *
	 * @param $updater DatabaseUpdater
	 *
	 * @return true
	 */
	public static function loadExtensionSchemaUpdates( $updater = null ) {
		if ( $updater === null ) {
			global $wgExtNewTables;
			$wgExtNewTables[] = array( 'wikilove_log', dirname( __FILE__ ) . '/patches/WikiLoveLog.sql' );
			$wgExtNewTables[] = array( 'wikilove_image_log', dirname( __FILE__ ) . '/patches/WikiLoveImageLog.sql' );
		} else {
			$updater->addExtensionUpdate( array( 'addTable', 'wikilove_log',
				dirname( __FILE__ ) . '/patches/WikiLoveLog.sql', true ) );
			$updater->addExtensionUpdate( array( 'addTable', 'wikilove_image_log',
				dirname( __FILE__ ) . '/patches/WikiLoveImageLog.sql', true ) );
		}
		return true;
	}

	/**
	 * Add the preference in the user preferences with the GetPreferences hook.
	 * @param $user User
	 * @param $preferences array
	 *
	 * @return true
	 */
	public static function getPreferences( $user, &$preferences ) {
		global $wgWikiLoveGlobal;
		if ( !$wgWikiLoveGlobal ) {
			$preferences['wikilove-enabled'] = array(
				'type' => 'check',
				'section' => 'editing/labs',
				'label-message' => 'wikilove-enable-preference',
			);
		}
		return true;
	}

	/**
	 * Adds the required module if we are on a user (talk) page.
	 *
	 * @param $out OutputPage
	 * @param $skin Skin
	 *
	 * @return true
	 */
	public static function beforePageDisplay( $out, $skin ) {
		global $wgWikiLoveGlobal, $wgUser;
		if ( !$wgWikiLoveGlobal && !$wgUser->getOption( 'wikilove-enabled' ) ) {
			return true;
		}

		$title = self::getUserTalkPage( $skin->getTitle() );
		if ( !is_null( $title ) ) {
			$out->addModules( array( 'ext.wikiLove.icon', 'ext.wikiLove.init' ) );
			self::$recipient = $title->getBaseText();
		}
		return true;
	}

	/**
	 * Exports wikilove-recipient and edittoken variables to JS
	 *
	 * @param $vars array
	 *
	 * @return true
	 */
	public static function makeGlobalVariablesScript( &$vars ) {
		global $wgUser;
		$vars['wikilove-recipient'] = self::$recipient;
		$vars['wikilove-edittoken'] = $wgUser->edittoken();

		$vars['wikilove-anon'] = 0;
		if ( self::$recipient !== '' ) {
			$receiver = User::newFromName( self::$recipient );
			if ( $receiver === false || $receiver->isAnon() ) $vars['wikilove-anon'] = 1;
		}
		return true;
	}

	/**
	 * Adds a tab the old way (before MW 1.18)
	 * @param $skin
	 * @param $contentActions
	 * @return bool
	 */
	public static function skinTemplateTabs( $skin, &$contentActions ) {
		self::skinConfigViewsLinks( $skin, $contentActions );
		return true;
	}

	/**
	 * Adds a tab or an icon the new way (MW >1.18)
	 * @param $skin Skin
	 * @param $links array
	 * @return bool
	 */
	public static function skinTemplateNavigation( &$skin, &$links ) {
		if ( self::showIcon( $skin ) ) {
			self::skinConfigViewsLinks( $skin, $links['views']);
		} else {
			self::skinConfigViewsLinks( $skin, $links['actions']);
		}
		return true;
	}

	/**
	 * Configure views links.
	 * Helper function for SkinTemplateTabs and SkinTemplateNavigation hooks
	 * to configure views links.
	 *
	 * @param $skin Skin
	 * @param $views array
	 * @return bool
	 */
	private static function skinConfigViewsLinks( $skin, &$views ) {
		global $wgWikiLoveGlobal, $wgUser;

		// If WikiLove is turned off for this user, don't display tab.
		if ( !$wgWikiLoveGlobal && !$wgUser->getOption( 'wikilove-enabled' ) ) {
			return true;
		}

		if ( !is_null( self::getUserTalkPage( $skin->getTitle() ) ) ) {
			$views['wikilove'] = array(
				'text' => wfMsg( 'wikilove-tab-text' ),
				'href' => '#',
			);
			if ( self::showIcon( $skin ) ) {
				$views['wikilove']['class'] = 'icon';
				$views['wikilove']['primary'] = true;
			}
		}
		return true;
	}

	/**
	 * Only show an icon when the global preference is enabled and the current skin is Vector.
	 *
	 * @param $skin Skin
	 *
	 * @return bool
	 */
	private static function showIcon( $skin ) {
		global $wgWikiLoveTabIcon;
		return $wgWikiLoveTabIcon && $skin->getSkinName() == 'vector';
	}

	/**
	 * Find the editable talk page of the user we're looking at, or null
	 * if such page does not exist.
	 *
	 * @param $title Title
	 *
	 * @return Title|null
	 */
	public static function getUserTalkPage( $title ) {
		global $wgUser;

		// Exit early if the sending user isn't logged in
		if ( !$wgUser->isLoggedIn() ) {
			return null;
		}

		// Exit early if we're in the wrong namespace
		$ns = $title->getNamespace();
		if ( $ns != NS_USER && $ns != NS_USER_TALK ) {
			return null;
		}

		// If we're on a subpage, get the base page title
		$baseTitle = Title::newFromText( $title->getBaseText(), $ns );
		if ( $baseTitle === null ) {
			return null;
		}

		// Get the user talk page
		if ( $ns == NS_USER_TALK ) {
			// We're already on the user talk page
			$talkTitle = $baseTitle;
		} elseif ( $ns == NS_USER ) {
			// We're on the user page, so retrieve the user talk page instead
			$talkTitle = $baseTitle->getTalkPage();
		}

		// If it's a redirect, exit. We don't follow redirects since it might confuse the user or
		// lead to an endless loop (like if the talk page redirects to the user page or a subpage).
		// This means that the WikiLove tab will not appear on user pages or user talk pages if
		// the user talk page is a redirect.
		if ( $talkTitle->isRedirect() ) {
			return null;
		}

		// Make sure we can edit the page
		if ( $talkTitle->quickUserCan( 'edit' ) ) {
			return $talkTitle;
		} else {
			return null;
		}
	}
}
