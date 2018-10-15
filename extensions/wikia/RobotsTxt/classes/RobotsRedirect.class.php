<?php

namespace Wikia\RobotsTxt;

class RobotsRedirect {

	public $redirectCancelled = false;

	/**
	 * Modifies the url so the robots.txt is at the root of the domain.
	 */
	private function removeRobotsPathPrefix( $url ) {
		$urlParts = parse_url( $url );
		$robotsPos = strpos( $urlParts['path'], '/robots.txt' );
		if ( $robotsPos  > 0 ) {
			// there is a path prefix, we want to redirect to domain root
			$urlParts['path'] = substr( $urlParts['path'], $robotsPos );
			$urlParts['delimiter'] = '://';    // needed by the wfAssembleUrl to include scheme
			$url = wfAssembleUrl( $urlParts );
		}
		return $url;
	}

	/**
	 * Redirect listener, makes sure the target url point to the domain root.
	 * Also prevent redirects loops by cancelling the redirect if we are at
	 * the target url (domain root).
	 */
	public function onBeforePageRedirect($outputPage, &$redirect, &$code, &$redirectedBy) {
		$currentUri = \WikiFactoryLoader::getCurrentRequestUri( $_SERVER, true, true );
		$targetUri = $this->removeRobotsPathPrefix( $redirect );

		if ( $currentUri == $targetUri ) {
			// we're on the correct url, prevent the redirect from happening
			$this->redirectCancelled = true;
			header( 'X-Robots-Redirect-Cancelled: 1' );	// debug header
			return false;
		}
		if ( $targetUri !== $redirect ) {
			$redirectedBy[] = 'Robots-DomainRoot';
			$redirect = $targetUri;
		}
		return true;
	}
};
