<?php

class HTTPSOptInHooks {
	public static function onGetPreferences( User $user, array &$preferences ): bool {
		if ( $user->isAllowed( 'https-opt-in' ) ) {
			$preferences['https-opt-in'] = [
				'type' => 'toggle',
				'label-message' => 'https-opt-in-toggle',
				'section' => 'under-the-hood/advanced-displayv2',
			];
		}
		return true;
	}
}
