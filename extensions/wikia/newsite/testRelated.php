<?php

/**
 * test for related hosts
 */

ini_set( "include_path", dirname(__FILE__)."/../../../maintenance/" );
require_once( "commandLine.inc" );

$job = new NeueWebsiteJob(
	Title::newFromText( "Eloy.wikia", NS_USER ),
	array( "domain" => "kofeina.net", "key" => "kofeina.net", "test" => true ) );

$job->run();
