<?php

require_once dirname( dirname( dirname( dirname( __FILE__ ) ) ) ) .
	"/maintenance/commandLine.inc";

if ( isset( $options['help'] ) ) {
	echo "Rebuilds database structure for CommunityVoice.\n";
	echo "Usage:\n";
	echo "\tphp extensions/CommunityVoice/CLI/Initialize.php --confirm=yes \n";
} else {
	if ( isset( $options['confirm'] ) && $options['confirm'] == 'yes' ) {
		echo "Rebuilding database structure for CommunityVoice...\n";
		// Get a connection
		$dbw = wfGetDB( DB_MASTER );
		// Runs initialization
		$dbw->sourceFile( dirname( dirname( __FILE__ ) ) . '/CommunityVoice.sql' );
	} else {
		echo "Nothing was changed. Run with --help for usage information.\n";
	}
}