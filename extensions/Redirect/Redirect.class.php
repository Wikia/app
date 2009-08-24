<?php
/**
 * Hooks for Redirect extension
 *
 * @file
 * @ingroup Extensions
 */

class RedirectHooks {
	public static function afterAddNewAccount( $user, $byEmail ) {
		// Do nothing if account creation was by e-mail
		if ( $byEmail ) {
			return true;
		}

		return self::addRedirect( 'addnewaccount' );
	}

	public static function afterUserLogoutComplete( &$user ) {
		return self::addRedirect( 'userlogoutcomplete' );
	}

	private static function addRedirect( $hookName ) {
		global $wgOut;

		wfLoadExtensionMessages( 'Redirect' );

		$targetPage = wfMsgForContent( 'redirect-' . $hookName );

		// Default for message is empty. Do nothing.
		if ( $targetPage == '' ) {
			return true;
		}

		$target = Title::newFromText( $targetPage );

		if ( $target->isKnown() ) {
			$wgOut->redirect( $target->getFullUrl() );
		}

		return true;
	}
}
