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

	/**
	 * Handle redirecting users who have opted in to HTTPS, and those
	 * who haven't back to HTTP if necessary.
	 *
	 * @param  Title      $title
	 * @param             $unused
	 * @param  OutputPage $output
	 * @param  User       $user
	 * @param  WebRequest $request
	 * @param  MediaWiki  $mediawiki
	 * @return bool
	 */
	public static function onBeforeInitialize( Title $title, $unused, OutputPage $output,
		User $user, WebRequest $request, MediaWiki $mediawiki
	): bool {
		if ( WebRequest::detectProtocol() == 'http' &&
			$user->isAllowed( 'https-opt-in' ) &&
			$user->getGlobalPreference( 'https-opt-in', false )
		) {
			$output->redirect( preg_replace( '/^http:\/\//', 'https://', $request->getFullRequestURL() ) );
		} elseif ( WebRequest::detectProtocol() == 'https' &&
			( !$user->isAllowed( 'https-opt-in' ) || !$user->getGlobalPreference( 'https-opt-in', false ) )
		) {
			$output->redirect( preg_replace( '/^https:\/\//', 'http://', $request->getFullRequestURL() ) );
		}
		return true;
	}
}
