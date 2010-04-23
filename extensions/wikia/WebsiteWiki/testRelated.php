<?php

/**
 * test for related hosts
 */

ini_set( "include_path", dirname(__FILE__)."/../../../maintenance/" );
require_once( "commandLine.inc" );

$job = new NewWebsiteJob( Title::newFromText( "Gazeta.pl", NS_MAIN ), array( "test" => true ) );
$job->run();

$job = new NewWebsiteJob( Title::newFromText( "Uncyclopedia.org", NS_MAIN ), array( "test" => true ) );
$job->run();

$job = new NewWebsiteJob( Title::newFromText( "Kofeina.net", NS_MAIN ), array( "test" => true ) );
$job->run();

$job = new NewWebsiteJob( Title::newFromText( "Spektrum.de", NS_MAIN ), array( "test" => true ) );
$job->run();

$job = new NewWebsiteJob( Title::newFromText( "Allegro.pl", NS_MAIN ), array( "test" => true ) );
$job->run();

$job = new NewWebsiteJob( Title::newFromText( "Google.com", NS_MAIN ), array( "test" => true ) );
$job->run();
