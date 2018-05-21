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

	// wikis with ID greater than this threshold will get HTTPS on by default for
	// logged-in users despite the opt-in preference
	const WIKI_ID_THRESHOLD_WITH_HTTPS_ON = 1700000;

	public static function onGetPreferences( User $user, array &$preferences ): bool {
		global $wgServer, $wgHTTPSForLoggedInUsers, $wgCityId;
		if ( empty( $wgHTTPSForLoggedInUsers ) &&
			$wgCityId <= self::WIKI_ID_THRESHOLD_WITH_HTTPS_ON &&
			wfHttpsAllowedForURL( $wgServer )
		) {
			$preferences['https-opt-in'] = [
				'type' => 'toggle',
				'label-message' => 'https-opt-in-toggle',
				'section' => 'under-the-hood/advanced-displayv2',
			];
		}
		return true;
	}

	public static function onMercuryWikiVariables( array &$wikiVariables ): bool {
		$basePath = $wikiVariables['basePath'];
		$user = RequestContext::getMain()->getUser();
		if ( self::httpsAllowed( $user, $basePath ) ) {
			$wikiVariables['basePath'] = wfHttpToHttps( $basePath );
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
		if ( !empty( $_SERVER['HTTP_FASTLY_FF'] ) ) {  // don't redirect internal clients
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
		}
		return true;
	}

	private static function httpsAllowed( User $user, string $url ): bool {
		global $wgHTTPSForLoggedInUsers, $wgCityId;
		return wfHttpsAllowedForURL( $url ) &&
			$user->isLoggedIn() &&
			(
				!empty( $wgHTTPSForLoggedInUsers ) ||
				$user->getGlobalPreference( 'https-opt-in', false ) ||
				$wgCityId > self::WIKI_ID_THRESHOLD_WITH_HTTPS_ON
			);
	}

	private static function httpsEnabledTitle( Title $title ): bool {
		global $wgDBname;
		return array_key_exists( $wgDBname, self::$httpsArticles ) &&
			in_array( $title->getPrefixedDBKey(), self::$httpsArticles[ $wgDBname ] );
	}
}
