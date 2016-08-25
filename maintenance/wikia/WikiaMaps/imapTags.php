<?php

/**
 * Maintenance script to get information about imap tags used in articles on a wiki and to remove them
 */

ini_set( "include_path", dirname( __FILE__ )."/../../" );

require_once( "commandLine.inc" );

if ( isset( $options['help'] ) ) {
	die(
<<<TXT
Usage: php imapTags.php [--help] [--dry-run] [--action] [--city_id] [--map_id]
--action		which action you want to proceed with:
	info		to gather statistics
	remove		to remove <imaps> tag
--dry-run		dry run - prints information to the output but does not modify data
--help			you are reading it right now

TXT
	);
}
