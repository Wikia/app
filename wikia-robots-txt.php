<?php

use Wikia\RobotsTxt\PathBuilder;
use Wikia\RobotsTxt\RobotsTxt;
use Wikia\RobotsTxt\WikiaRobots;

require_once( __DIR__ . '/includes/WebStart.php' );

$wikiaRobots = new WikiaRobots( new PathBuilder() );
$robots = $wikiaRobots->configureRobotsBuilder( new RobotsTxt() );

header( 'Content-Type: text/plain' );
header( 'Cache-Control: s-maxage=' . $wikiaRobots->getRobotsTxtCachePeriod() );
header( 'X-Pass-Cache-Control: public, max-age=' . $wikiaRobots->getRobotsTxtCachePeriod() );

echo join( PHP_EOL, $robots->getContents() ) . PHP_EOL;
