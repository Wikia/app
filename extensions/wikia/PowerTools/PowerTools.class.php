<?php

class PowerTools {
	static function onPowerDelete( $action, $article ) {
		global $wgOut, $wgUser;

		if ( $action !== 'powerdelete' ) {
			return true;
		}

		if ( !$wgUser->isAllowed( 'delete' ) || !$wgUser->isAllowed( 'powerdelete' ) ) {
			$wgOut->permissionRequired( 'powerdelete' );	
			return false;
		}

		if ( $wgUser->isBlocked() ) {
			$wgOut->blockedPage();
			return false;
		}

		if ( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return false;
		}

		$article->doDelete();
		$article->mTitle->updateTitleProtection( 'sysop', '', 'infinity' );

		// TODO: make this Oasis-agnostic
		NotificationsModule::addConfirmation( wfMsgExt('oasis-confirmation-page-deleted', array('parseinline'), $article->mTitle->getPrefixedText() ) );

		// redirect to main page
		$wgOut->redirect(Title::newMainPage()->getFullUrl( array( 'cb' => rand( 1, 1000 ) ) ));

		return false;
	}
}
