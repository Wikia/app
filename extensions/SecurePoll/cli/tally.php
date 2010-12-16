<?php

/**
 * Tally an election from a dump file or local database.
 *
 * Can be used to tally very large numbers of votes, when the web interface is 
 * not feasible.
 */

$optionsWithArgs = array( 'name' );
require( dirname(__FILE__).'/cli.inc' );

$wgTitle = Title::newFromText( 'Special:SecurePoll' );

$usage = <<<EOT
Usage: 
  php tally.php [--html] --name <election name>
  php tally.php [--html] <dump file>
EOT;

if ( !isset( $options['name'] ) && !isset( $args[0] ) ) {
	spFatal( $usage );
}

if ( !class_exists( 'SecurePoll_Context' ) ) {
	if ( isset( $options['name'] ) ) {
		spFatal( "Cannot load from database when SecurePoll is not installed" );
	}
	require( dirname( __FILE__ ) . '/../SecurePoll.php' );
}

$context = new SecurePoll_Context;
if ( !isset( $options['name'] ) ) {
	$context = SecurePoll_Context::newFromXmlFile( $args[0] );
	if ( !$context ) {
		spFatal( "Unable to parse XML file \"{$args[0]}\"" );
	}
	$electionIds = $context->getStore()->getAllElectionIds();
	if ( !count( $electionIds ) ) {
		spFatal( "No elections found in XML file \"{$args[0]}\"" );
	}
	$election = $context->getElection( reset( $electionIds ) );
} else {
	$election = $context->getElectionByTitle( $options['name'] );
	if ( !$election ) {
		spFatal( "The specified election does not exist." );
	}
}
$status = $election->tally();
if ( !$status->isOK() ) {
	spFatal( "Tally error: " . $status->getWikiText() );
}
$tallier = $status->value;
if ( isset( $options['html'] ) ) {
	echo $tallier->getHtmlResult();
} else {
	echo $tallier->getTextResult();
}


function spFatal( $message ) {
	fwrite( STDERR, rtrim( $message ) . "\n" );
	exit( 1 );
}
