<?php
/**
 * Script to convert Translate extension database schema to v2
 *
 * @author Niklas Laxstrom
 * @copyright Copyright © 2011, Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @file
 */

// Standard boilerplate to define $IP
if ( getenv( 'MW_INSTALL_PATH' ) !== false ) {
	$IP = getenv( 'MW_INSTALL_PATH' );
} else {
	$dir = dirname( __FILE__ ); $IP = "$dir/../../..";
}
require_once( "$IP/maintenance/Maintenance.php" );

/**
 * Script to convert Translate extension database schema to v2.
 * Essentially gets rid of revtag_type table, which was unnecessary
 * abstraction.
 */
class TSchema2 extends Maintenance {

	public function __construct() {
		parent::__construct();
		$this->mDescription = 'Migrates db schema to version 2.';
	}

	public function execute() {
		$dbw = wfGetDB( DB_MASTER );
		if ( !$dbw->tableExists( 'revtag' ) ) {
			$this->error( "Table revtag doesn't exist. Translate extension is not installed?" );
			return;
		}

		if ( !$dbw->tableExists( 'revtag_type' ) ) {
			$this->error( "Table revtag_type doesn't exist. Migration is already done." );
			return;
		}

		if ( $dbw->getType() !== 'mysql' ) {
			$this->error( "This migration script only supports mysql. Please help us to write routine for {$dbw->getType()}." );
			return;
		}

		$table = $dbw->tableName( 'revtag' );
		$dbw->query( "ALTER TABLE $table MODIFY rt_type varbinary(60) not null", __METHOD__ );

		$res = $dbw->select(
			'revtag_type',
			array( 'rtt_id', 'rtt_name' ),
			array(),
			__METHOD__
		);

		foreach ( $res as $row ) {
			$dbw->update(
				'revtag',
				array( 'rt_type' => $row->rtt_name ),
				array( 'rt_type' => (string) $row->rtt_id ),
				__METHOD__
			);
		}

		if ( is_callable( $dbw, 'dropTable' ) ) {
			$dbw->dropTable( 'revtag_type', __METHOD__ );
		} else {
			// BC for MW <1.18
			$table = $dbw->tableName( 'revtag_type' );
			$dbw->query( "DROP TABLE $table", __METHOD__ );
		}

	}

}

$maintClass = 'TSchema2';
require_once( DO_MAINTENANCE );
