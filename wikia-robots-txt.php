<?php

use Wikia\RobotsTxt\PathBuilder;
use Wikia\RobotsTxt\RobotsRedirect;
use Wikia\RobotsTxt\RobotsTxt;
use Wikia\RobotsTxt\WikiaRobots;

// This will prevent WFL from redirecting
$wgSkipWFLRedirect = true;

require_once( __DIR__ . '/includes/WebStart.php' );

$output = RequestContext::getMain()->getOutput();

Hooks::run( 'WikiaRobotsBeforeOutput', [ $wgRequest, $wgUser, $output ] );

$robotsRedirect = new RobotsRedirect();

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

