<?php

/**
 * An import script, converting HTML to wikitext, potentially usable with multiple wikiHTML flavours.
 *
 * This depends on RichTextEditor's (RTE) ReverseParser for all the magic.
 *
 * @file
 * @ingroup Maintenance
 * @author Lucas Garczewski <tor@wikia-inc.com>
 */

$optionsWithArgs = array( 'wikitype', 'comment' );
require( '../../commandLine.inc' );
require( "$IP/extensions/wikia/RTE/RTEReverseParser.class.php" );
require( 'reverseImporter.class.php' );

if ( empty( $options['wikitype'] ) ) {
	$importerClass = 'pbwikiImporter';
} else {
	$importerClass = strtolower( $options['wikitype'] ) . 'Importer';
}

require( "$importerClass.class.php" );

if ( empty( $options['comment'] ) ) {
	$comment = 'importing content';
} else {
	$comment = $options['comment'];
}

if( count( $args ) == 0 ) {
	die( "Specify an import directory.\n" );
}

$importdir = $args[0];

//get files list
$dir = opendir( $importdir );

while( false !== ( $file = readdir( $dir ) ) ) {
	$text = '';

	if ( strpos( $file, '.html' ) === false ) {
		echo "Skipping non-HTML file: $file\n";
		continue;
	}

	echo "Processing $file... ";

	$text = file_get_contents( $importdir . $file );

	if ( empty( $text ) ) {
		echo "Empty file. Skipping.\n";
		continue;
	}

	$title = Title::newFromText( substr( $file, 0, -5 ) );
	$article = new Article( $title );

	$importer = new $importerClass( $text );

	wfWaitForSlaves( 5 );
	$importer->parse();

	$article->doEdit( $importer->parse(), $comment, 0, false, $importer->getUser() );

	echo "\n";
}
