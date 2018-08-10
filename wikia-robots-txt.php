<?php

use Wikia\RobotsTxt\PathBuilder;
use Wikia\RobotsTxt\RobotsTxt;
use Wikia\RobotsTxt\WikiaRobots;

// This will prevent WFL from redirecting
$wgSkipWFLRedirect = true;

require_once( __DIR__ . '/includes/WebStart.php' );

class RobotsRedirect {
	public $redirectCancelled = false;

	/**
	 * Modifies the url so the robots.txt is at the root of the domain.
	 */
	private function removeRobotsPathPrefix( $url ) {
		$urlParts = parse_url( $url );
		$robots_pos = strpos( $urlParts['path'], '/robots.txt' );
		if ( $robots_pos  > 0 ) {
			// there is a path prefix, we want to redirect to domain root
			$urlParts['path'] = substr( $urlParts['path'], $robots_pos );
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
		$current = WikiFactoryLoader::getCurrentRequestUri( $_SERVER );
		$new = $this->removeRobotsPathPrefix( $redirect );

		if ( $current == $new ) {
			// we're on the correct url, prevent the redirect from happening
			$this->redirectCancelled = true;
			header( 'X-Robots-Redirect-Cancelled: 1' );	// debug header
			return false;
		}
		if ( $new !== $redirect ) {
			$redirectedBy[] = 'Robots-DomainRoot';
			$redirect = $new;
		}
		return true;
	}
};

$output = RequestContext::getMain()->getOutput();

Hooks::run( 'WikiaRobotsBeforeOutput', [ $wgRequest, $wgUser, $output ] );

$robotsRedirect = new RobotsRedirect( $wgRequest );

if ( $output->isRedirect() ) {
	$wgHooks['BeforePageRedirect'][] = [ $robotsRedirect, 'onBeforePageRedirect' ];
	$output->output();
}

if ( !$output->isRedirect() || $robotsRedirect->redirectCancelled ) {
	$wikiaRobots = new WikiaRobots( new PathBuilder() );
	$robots = $wikiaRobots->configureRobotsBuilder( new RobotsTxt() );

	header( 'Content-Type: text/plain' );
	header( 'Cache-Control: s-maxage=' . $wikiaRobots->getRobotsTxtCachePeriod() );
	header( 'X-Pass-Cache-Control: public, max-age=' . $wikiaRobots->getRobotsTxtCachePeriod() );

	echo join( PHP_EOL, $robots->getContents() ) . PHP_EOL;
}

