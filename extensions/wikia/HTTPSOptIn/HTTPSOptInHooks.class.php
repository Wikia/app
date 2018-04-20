<?php

class HTTPSOptInHooks {

	// List of articles that shouldn't redirect to http versions even for users that don't have https enabled.
	// This array contains wgDBname mapped to array of article keys.
	static $httpsArticles = [
		/* www.wikia.com */
		'wikiaglobal' => [ 'Licensing', 'Privacy_Policy', 'Terms_of_Use'  ],
		/* ja.wikia.com */
		'jacorporate' => [ 'Privacy_Policy', 'Terms_of_Use' ],
		/* community.wikia.com */
		'wikia' => [ 'Community_Central:Licensing' ]
	];

	public static function onGetPreferences( User $user, array &$preferences ): bool {
		global $wgServer;
		if ( wfHttpsAllowedForURL( $wgServer ) && $user->isAllowed( 'https-opt-in' ) ) {
			$preferences['https-opt-in'] = [
				'type' => 'toggle',
				'label-message' => 'https-opt-in-toggle',
				'section' => 'under-the-hood/advanced-displayv2',
			];
		}
		return true;
	}

	public static function onMercuryWikiVariables( array &$wikiVariables ): bool {
		global $wgDisableHTTPSDowngrade;
		$basePath = $wikiVariables['basePath'];
		$user = RequestContext::getMain()->getUser();
		if ( startsWith( $basePath, 'http://' ) &&
			self::httpsAllowed( $user, $basePath )
		) {
			$wikiVariables['basePath'] = wfHttpToHttps( $basePath );
		} elseif ( startsWith( $basePath, 'https://' ) &&
			!self::httpsAllowed( $user, $basePath ) &&
			empty( $wgDisableHTTPSDowngrade )
		) {
			$wikiVariables['basePath'] = wfHttpsToHttp( $basePath );
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
		global $wgDisableHTTPSDowngrade;
		$requestURL = $request->getFullRequestURL();
		if ( WebRequest::detectProtocol() === 'http' &&
			self::httpsAllowed( $user, $requestURL )
		) {
			$output->redirect( wfHttpToHttps( $requestURL ) );
		} elseif ( WebRequest::detectProtocol() === 'https' &&
			!self::httpsAllowed( $user, $requestURL ) &&
			empty( $wgDisableHTTPSDowngrade ) &&
			!$request->getHeader( 'X-Wikia-WikiaAppsID' ) &&
			!self::httpsEnabledTitle( $title )
		) {
			$output->redirect( wfHttpsToHttp( $requestURL ) );
		}
		return true;
	}

	private static function httpsAllowed( User $user, string $url ): bool {
		return wfHttpsAllowedForURL( $url ) &&
			$user->isAllowed( 'https-opt-in' ) &&
			$user->getGlobalPreference( 'https-opt-in', false );
	}

	private static function httpsEnabledTitle( Title $title ): bool {
		global $wgDBname;
		return array_key_exists( $wgDBname, self::$httpsArticles ) &&
			in_array( $title->getPrefixedDBKey(), self::$httpsArticles[ $wgDBname ] );
	}
}
