<?php
/**
 * Class containing hooked functions for a ConfirmAccount environment
 */
class ConfirmAccountUIHooks {
	/**
	 * @param $template
	 * @return bool
	 */
	public static function addRequestLoginText( &$template ) {
		$context = RequestContext::getMain();
		# Add a link to RequestAccount from UserLogin
		if ( !$context->getUser()->isAllowed( 'createaccount' ) ) {
			$template->set( 'header', wfMsgExt( 'requestaccount-loginnotice', 'parse' ) );

			$context->getOutput()->addModules( 'ext.confirmAccount' ); // CSS
		}
		return true;
	}

	/**
	 * @param $personal_urls
	 * @param $title
	 * @return bool
	 */
	public static function setRequestLoginLinks( array &$personal_urls, &$title ) {
		if ( isset( $personal_urls['anonlogin'] ) ) {
			$personal_urls['anonlogin']['text'] = wfMsg( 'nav-login-createaccount' );
		} elseif ( isset( $personal_urls['login'] ) ) {
			$personal_urls['login']['text'] = wfMsg( 'nav-login-createaccount' );
		}
		return true;
	}

	/**
	 * @param $user User
	 * @param $abortError
	 * @return bool
	 */
	public static function checkIfAccountNameIsPending( User $user, &$abortError ) {
		# If an account is made with name X, and one is pending with name X
		# we will have problems if the pending one is later confirmed
		if ( !UserAccountRequest::acquireUsername( $user->getName() ) ) {
			$abortError = wfMsgHtml( 'requestaccount-inuse' );
			return false;
		}
		return true;
	}

	/**
	 * Add "x email-confirmed open account requests" notice
	 * @param $notice
	 * @return bool
	 */
	public static function confirmAccountsNotice( OutputPage &$out, Skin &$skin ) {
		global $wgConfirmAccountNotice;

		$context = $out->getContext();
		if ( !$wgConfirmAccountNotice || !$context->getUser()->isAllowed( 'confirmaccount' ) ) {
			return true;
		}
		# Only show on some special pages
		$title = $context->getTitle();
		if ( !$title->isSpecial( 'Recentchanges' ) && !$title->isSpecial( 'Watchlist' ) ) {
			return true;
		}
		$count = ConfirmAccount::getOpenEmailConfirmedCount( '*' );
		if ( $count > 0 ) {
			$out->prependHtml( // parsemag for PLURAL
				'<div id="mw-confirmaccount-msg" class="plainlinks mw-confirmaccount-bar">' .
				$out->parse( wfMsgExt( 'confirmaccount-newrequests', 'parsemag', $count ), false ) .
				'</div>'
			);

			$out->addModules( 'ext.confirmAccount' ); // CSS
		}
		return true;
	}

	/**
	 * For AdminLinks extension
	 * @param $admin_links_tree
	 * @return bool
	 */
	public static function confirmAccountAdminLinks( &$admin_links_tree ) {
		$users_section = $admin_links_tree->getSection( wfMsg( 'adminlinks_users' ) );
		$extensions_row = $users_section->getRow( 'extensions' );

		if ( is_null( $extensions_row ) ) {
			$extensions_row = new ALRow( 'extensions' );
			$users_section->addRow( $extensions_row );
		}

		$extensions_row->addItem( ALItem::newFromSpecialPage( 'ConfirmAccounts' ) );
		$extensions_row->addItem( ALItem::newFromSpecialPage( 'UserCredentials' ) );

		return true;
	}
}
