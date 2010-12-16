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
	$IP = dirname( __FILE__ ) . '/../../..';

require_once( "$IP/maintenance/Maintenance.php" );

class MigrateFiles extends Maintenance {
	function __construct() {
		$this->mDescription = 'Convert serialized files to PHP files';
	}

	function execute() {
		$handler = new ConfigureHandlerFiles();
		$dir = $handler->getDir();

		if ( !$dirObj = opendir( $dir ) ) {
			$this->error( "The directory '$dir' doesn't exist, aborting.\n", true );
		}

		while ( ( $file = readdir( $dirObj ) ) !== false ) {
			if ( preg_match( '/^conf-(\d{14})\.ser$/', $file, $m ) || $file == 'conf-now.ser' ) {
				$old = "$dir/$file";
				$new = substr( $old, 0, -3 ) . 'php';
		
				$settings = unserialize( file_get_contents( $old ) );
				$cont = '<?php $settings = '.var_export( $settings, true ).";";

				file_put_contents( $new, $cont );
				$this->output( "$file done\n" );
			}
		}

		$this->output( "complete. Please delete all the files listed above for security.\n" );
	}
}

$maintClass = 'MigrateFiles';
require_once( DO_MAINTENANCE );
