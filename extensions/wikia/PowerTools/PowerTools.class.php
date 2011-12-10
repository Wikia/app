<?php

class PowerTools {
	static function onPowerDelete( $action, $article ) {
		global $wgOut, $wgUser, $wgRequest;

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

		$reason = $wgRequest->getText( 'reason' );

		$article->doDelete( $reason );
		$article->mTitle->updateTitleProtection( 'sysop', $reason, 'infinity' );

		return false;
	}
}
