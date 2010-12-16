<?php

/**
 * Generate an XML dump of an election, including configuration and votes.
 */


$optionsWithArgs = array( 'o' );
require( dirname(__FILE__).'/cli.inc' );

$usage = <<<EOT
Usage: php dump.php [options...] <election name>
Options:
    -o <outfile>                Output to the specified file
    --votes                     Include vote records
    --all-langs                 Include messages for all languages instead of just the primary
    --jump                      Produce a configuration dump suitable for setting up a jump wiki
EOT;

if ( !isset( $args[0] ) ) {
	spFatal( $usage );
}

$context = new SecurePoll_Context;
$election = $context->getElectionByTitle( $args[0] );
if ( !$election ) {
	spFatal( "There is no election called \"$args[0]\"" );
}

if ( !isset( $options['o'] ) ) {
	$fileName = '-';
} else {
	$fileName = $options['o'];
}
if ( $fileName === '-' ) {
	$outFile = STDOUT;
} else {
	$outFile = fopen( $fileName, 'w' );
}
if ( !$outFile ) {
	spFatal( "Unable to open $fileName for writing" );
}

if ( isset( $options['all-langs'] ) ) {
	$langs = $election->getLangList();
} else {
	$langs = array( $election->getLanguage() );
}
$confXml = $election->getConfXml( array(
	'jump' => isset( $options['jump'] ),
	'langs' => $langs 
) );

$cbdata = array(
	'header' => "<SecurePoll>\n<election>\n$confXml",
	'outFile' => $outFile
);
$election->cbdata = $cbdata;

# Write vote records
if ( isset( $options['votes'] ) ) {
	$status = $election->dumpVotesToCallback( 'spDumpVote' );
	if ( !$status->isOK() ) {
		spFatal( $status->getWikiText() );
	}
}
if ( $election->cbdata['header'] ) {
	fwrite( $outFile, $election->cbdata['header'] );
}

fwrite( $outFile, "</election>\n</SecurePoll>\n" );

function spFatal( $message ) {
	fwrite( STDERR, rtrim( $message ) . "\n" );
	exit( 1 );
}

function spDumpVote( $election, $row ) {
	if ( $election->cbdata['header'] ) {
		fwrite( $election->cbdata['outFile'], $election->cbdata['header'] );
		$election->cbdata['header'] = false;
	}
	fwrite( $election->cbdata['outFile'], "<vote>" . $row->vote_record . "</vote>\n" );
}

