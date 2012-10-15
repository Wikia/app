<?php
/**
 * Makes the required database changes for the CheckUser extension
 */

require_once ( getenv( 'MW_INSTALL_PATH' ) !== false
	? getenv( 'MW_INSTALL_PATH' ) . "/maintenance/commandLine.inc"
	: dirname( __FILE__ ) . '/../../maintenance/commandLine.inc' );
require_once dirname( __FILE__ ) . '/install.inc';

$db = wfGetDB( DB_MASTER );
if ( $db->tableExists( 'cu_changes' ) && !isset( $options['force'] ) ) {
	echo "...cu_changes already exists.\n";
} else {
	$cutoff = isset( $options['cutoff'] ) ? wfTimestamp( TS_MW, $options['cutoff'] ) : null;
	create_cu_changes( $db, $cutoff );
}
if ( $db->tableExists( 'cu_log' ) && !isset( $options['force'] ) ) {
	echo "...cu_log already exists.\n";
} else {
	create_cu_log( $db );
}
