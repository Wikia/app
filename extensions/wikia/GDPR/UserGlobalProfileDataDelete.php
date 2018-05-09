<?php

class UserGlobalProfileDataDelete {
	public static function deleteGlobalProfileData( User $user ): bool {
		if ( $user->isAnon() ) {
			return false;
		}

		$userIdentityBox = new UserIdentityBox( $user );
		$userIdentityBox->clearMastheadContents();

		return true;
	}
}
