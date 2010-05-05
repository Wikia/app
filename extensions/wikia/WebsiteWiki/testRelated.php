<?php

/**
 * test for related hosts
 */

ini_set( "include_path", dirname(__FILE__)."/../../../maintenance/" );
require_once( "commandLine.inc" );

#
# Location: viewpage.php?page_id=7
#
$job = new NewWebsiteJob( Title::newFromText( "Irma.org.pl", NS_MAIN ), array( "test" => true ) );
$job->run();

$job = new NewWebsiteJob( Title::newFromText( "Irbapol.pl", NS_MAIN ), array( "test" => true ) );
$job->run();

$job = new NewWebsiteJob( Title::newFromText( "Itaio.pl", NS_MAIN ), array( "test" => true ) );
$job->run();

$job = new NewWebsiteJob( Title::newFromText( "Jachty.net.pl", NS_MAIN ), array( "test" => true ) );
$job->run();

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
