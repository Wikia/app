<?php

class UserGlobalProfileDataDelete {
	public static function deleteGlobalProfileData( User $user ): bool {
		if ( !( $user instanceof User ) || $user->getId() === 0 ) {
			return false;
		}

		$userIdentityBox = new UserIdentityBox( $user );
		$userIdentityBox->clearMastheadContents();

		return true;
	}
}