<?php

/**
 * Maintenance script that migrate configuration from serialzed file to plain
 * PHP, for security
 *
 * @file
 * @ingroup Extensions
 * @author Alexandre Emsenhuber
 * @license GPLv2 or higher
 */

$IP = getenv( 'MW_INSTALL_PATH' );
if ( $IP === false )
	$IP = dirname( __FILE__ ) . '/../..';

require_once( "$IP/maintenance/commandLine.inc" );

$handler = new ConfigureHandlerFiles();
$dir = $handler->getDir();

if ( !$dirObj = opendir( $dir ) ) {
	fwrite( STDERR, "The directory '$dir' doesn't exist, aborting.\n" );
	exit;
}

while ( ( $file = readdir( $dirObj ) ) !== false ) {
	if ( preg_match( '/^conf-(\d{14})\.ser$/', $file, $m ) || $file == 'conf-now.ser' ) {
		$old = "$dir/$file";
		$new = substr( $old, 0, -3 ) . 'php';
		
		$settings = unserialize( file_get_contents( $old ) );
		$cont = '<?php $settings = '.var_export( $settings, true ).";";

		file_put_contents( $new, $cont );
		fwrite( STDOUT, "$file done\n" );
	}
}

fwrite( STDOUT, "complete. Please delete all the files listed above for security.\n" );
