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

		return false;
	}
}
