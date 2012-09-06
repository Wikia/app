<?php

/**
 *
 */
class PowerTools {

	/**
	 * @static
	 * @param string $action
	 * @param Article $article
	 * @return bool
	 * @throws UserBlockedError
	 * @throws PermissionsError
	 */
	static function onPowerDelete( $action, $article ) {
		global $wgOut, $wgUser, $wgRequest;

		if ( $action !== 'powerdelete' ) {
			return true;
		}

		if ( !$wgUser->isAllowed( 'delete' ) || !$wgUser->isAllowed( 'powerdelete' ) ) {
			throw new PermissionsError( 'powerdelete' );
		}

		if ( $wgUser->isBlocked() ) {
			throw new UserBlockedError( $wgUser->mBlock );
		}

		if ( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return false;
		}

		$reason = $wgRequest->getText( 'reason' );

		$title = $article->getTitle();
		$file = $title->getNamespace() == NS_IMAGE ? wfLocalFile( $title ) : false;

		if ( $file ) {
			$oldimage = null;
			FileDeleteForm::doDelete( $title, $file, $oldimage, $reason, false );
		} else {
			$article->doDelete( $reason );
		}
		// this is stupid, but otherwise, WikiPage::doUpdateRestrictions complains about passing by reference
		$false = false;
		$article->doUpdateRestrictions(array('create'=>'sysop'), array('create'=>'infinity'), $false, $reason, $wgUser);

		return false;
	}
}
