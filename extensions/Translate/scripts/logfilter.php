<?php
/**
 * A script to forward error log messages with some rate limiting.
 *
 * @author Niklas Laxstrom
 *
 * @copyright Copyright © 2010, Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @file
 */

$file = @$_SERVER['argv'][1];
if ( !is_readable( $file ) ) {
	exit( "OMG\n" );
}

$handle = fopen( $file, "rt" );
fseek( $handle, 0, SEEK_END );
while ( true ) {
	$count = 0;
	$line = false;
	while ( !feof( $handle ) ) {
		$count++;
		$input = fgets( $handle );
		if ( $input !== false ) $line = $input;
	}

	// I don't know why this is needed
	fseek( $handle, 0, SEEK_END );

	if ( $line !== false ) {
		$prefix = '';
		if ( $count > 2 ) {
			$count -= 2;
			$prefix = "($count lines skipped) ";
		}
		if ( mb_strlen( $line ) > 400 ) {
			$line = mb_substr( $line, 0, 400 ) . '...';
		}
		echo trim( $prefix . $line ) . "\n";
	}

	sleep( 30 );
}
